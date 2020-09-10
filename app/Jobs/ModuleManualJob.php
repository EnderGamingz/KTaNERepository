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
class ModuleManualJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $embedableThreashold = 40000; // 40 Kilobytes in bytes
    private $ignoredFiles = ['font.css', 'main.css', 'normalize.css', 'SpecialElite.ttf',
                             'jquery.3.1.1.min.js', 'jquery-ui.1.12.1.min.js', 'ktane-utils.js', 'ruleseed.js',
                             'web-background.jpg', 'page-bg-noise-01.png', 'page-bg-noise-02.png', 'page-bg-noise-03.png', 
                             'page-bg-noise-04.png', 'page-bg-noise-05.png', 'page-bg-noise-06.png', 'page-bg-noise-07.png'
                            ];
    private $module;
    private $dirName;
    private $useableFiles;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($module, $dirName)
    {
        $this->module = $module;
        $this->dirName = $dirName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $files = Storage::files($this->dirName);
        
        // Filter out files
        $this->useableFiles = collect();
        foreach ($files as $index => $file) {
            
            $fileName = base64_decode(str_replace($this->dirName.'/', '', $file));
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

        $dom = new Dom;
        $dom->setOptions((new Options())
            ->setcleanupInput(true)
            ->setpreserveLineBreaks(false)
        );

        $dom->loadStr($contents);

        $this->embedImages($dom);
        dd(strval($dom));
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

            $extension = $this->getExtension($srcReference);
            $referenceFileSize = Storage::size($this->useableFiles[$srcReference]);
            if($referenceFileSize > $this->embedableThreashold) {
                // TODO Handle embedables

                continue;
            }

            $referenceContents = Storage::get($this->useableFiles[$srcReference]);
            if($extension == 'svg') {
                // Embedding SVG
                $svgNode = new TextNode('<svg></svg>');
                $this->copyAttributes($tag, $svgNode);
                $svgNode->setText($referenceContents);
                $tag->getParent()->replaceChild($tag->id(), $svgNode);
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
