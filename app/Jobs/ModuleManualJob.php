<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Storage;
use Str;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Options;
use PHPHtmlParser\Dom\Node\TextNode;
use App\ModuleManual;
use Cache;

class ModuleManualJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $embedableThreashold = 40000; // 40 Kilobytes in bytes
    private $ignoredFiles = ['font.css', 'main.css', 'normalize.css', 'SpecialElite.ttf',
                             'jquery.3.1.1.min.js', 'jquery-ui.1.12.1.min.js', 'ktane-utils.js', 'ruleseed.js',
                             'web-background.jpg', 'page-bg-noise-01.png', 'page-bg-noise-02.png', 'page-bg-noise-03.png', 
                             'page-bg-noise-04.png', 'page-bg-noise-05.png', 'page-bg-noise-06.png', 'page-bg-noise-07.png'
                            ];
    private $dirName;
    private $path;
    private $moduleManual;
    private $useableFiles;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ModuleManual $moduleManual, $dirName)
    {
        $this->moduleManual = $moduleManual;
        $this->dirName = $dirName;
        $this->path = 'temp/' . $dirName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $files = Storage::files($this->path);
        
        // Filter out files
        $this->useableFiles = collect();
        foreach ($files as $index => $file) {
            
            $fileName = base64_decode(str_replace($this->path.'/', '', $file));
            if(in_array($fileName, $this->ignoredFiles)) {
                Storage::delete($file);
                unset($files[$index]);
                continue;
            }

            $this->useableFiles->put($fileName, $file);
        }

        $this->compressHTML();
    }

    private function compressHTML() {
        $htmlFile = $this->useableFiles->filter(function($value, $key) {
            return Str::endsWith($key, '.html');
        })->first();

        // Get's the contens of the HTML File
        $contents = Storage::get($htmlFile);

        // Initialize a new dom parser instance
        // and set the options
        $dom = new Dom;
        $dom->setOptions((new Options())
            ->setcleanupInput(true)
            ->setpreserveLineBreaks(false)
        );

        // Load the dom with the html file contents
        $dom->loadStr($contents);

        // Try to embed images
        $this->embedImages($dom);
        // Try to replace links
        $this->changeLinks($dom);
        // Try to replace and delte referenced scripts
        $this->changeScripts($dom);

        $indexFile = $this->dirName . '/' . sha1($htmlFile) . '.html';
        // Saves the html file to disk
        Storage::disk('public')->put($indexFile, $dom);

        // Updating the module with the information
        $this->moduleManual->update([
            // 'processes' => true,
            'source_path' => $indexFile
        ]);

        $this->cleanup();
    }

    private function cleanup() {
        Storage::deleteDirectory($this->path);
        Cache::clear('modules');
    }

    private function changeScripts($dom) {
        $scriptTags = $dom->find('script');

        foreach ($scriptTags as $tag) {
            $attr = $tag->getAttribute('href');
            if(!$attr) {
                continue;
            }

            $referenceName = $this->getReferenceName($attr);
            if(in_array($referenceName, $this->ignoredFiles)) {
                $tag->delete();
            }
        }

        $elements = $dom->find('body');
        if(sizeof($elements) == 0) {
            return;
        }

        $body = $elements[0];

        $scriptTag = new TextNode('<script src="/js/manual/js"></script>');
        $scriptTag->setParent($body);
    }

    private function changeLinks($dom) {
        $linkTags = $dom->find('link');

        foreach ($linkTags as $tag) {
            $attr = $tag->getAttribute('href');
            if(!$attr) {
                continue;
            }

            $referenceName = $this->getReferenceName($attr);
            if(in_array($referenceName, $this->ignoredFiles)) {
                $tag->delete();
            }
        }

        $elements = $dom->find('head');
        if(sizeof($elements) == 0) {
            return;
        }

        $head = $elements[0];

        $manualCssLink = new TextNode('<link rel="stylesheet" type="text/css" href="/css/manual.css">');
        $manualCssLink->setParent($head);
    }

    private function embedImages($dom) {
        $imgTags = $dom->find('img');

        foreach ($imgTags as $tag) {
            $attr = $tag->getAttribute('src');
            if(!$attr) {
                continue;
            }

            $srcReference = $this->getReferenceName($attr);
            // Check if the blank src reference file exists in the parsed files
            if(!$this->useableFiles->has($srcReference)) {
                continue;
            }

            // Removing the src attribute
            $tag->removeAttribute('src');

            $referenceContents = Storage::get($this->useableFiles[$srcReference]);
            $extension = $this->getExtension($srcReference);
            $referenceFileSize = Storage::size($this->useableFiles[$srcReference]);
            if($referenceFileSize > $this->embedableThreashold) {
                $fileName = sha1($srcReference) . '.' . $extension;
                // Check if the image does not already exist in the public directory
                if(!Storage::disk('public')->has($this->dirName . '/'. $fileName)) {
                    // Copy the image to the public directory
                    Storage::disk('public')->put($this->dirName . '/' . $fileName, $referenceContents);
                }

                // Replace the src with the file name
                $tag->setAttribute('src', $fileName);
                continue;
            }

            if($extension == 'svg') {
                // Createing empty svg node
                $svgNode = new TextNode('<svg></svg>');
                // Coyping the attributes
                $this->copyAttributes($tag, $svgNode);
                // Cleaning up the file contents
                $referenceContents = preg_replace( "/\r|\n/", "", $referenceContents);
                // Set text as the contents of the cleanred up file contents
                $svgNode->setText($referenceContents);
                // Replace the tag with the new tag
                $tag->getParent()->replaceChild($tag->id(), $svgNode);
            } else if($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg') {
                // Encode contents in base64 of image
                $encodedContents = base64_encode($referenceContents);
                // Set the source attribute to the generated base64 content
                $tag->setAttribute('src', 'data:image/' . $extension . ';base64, ' . $encodedContents);
            }
        }
    }

    private function copyAttributes($original, $target) {
        foreach ($original->getAttributes() as $key => $attr) {
            $target->setAttribute($key, $attr);
        }
    }

    private function getExtension($name) {
        return substr($name, strrpos($name, '.') + 1);
    }

    private function getReferenceName($name) {
        return substr($name, strrpos($name, '/') + 1);
    }
}
