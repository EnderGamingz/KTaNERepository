<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Storage;
use Str;
class ModuleManualJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $ignoredFiles = ['font.css', 'main.css', 'normalize.css', 'SpecialElite.ttf',
                             'jquery.3.1.1.min.js', 'jquery-ui.1.12.1.min.js', 'ktane-utils.js', 'ruleseed.js',
                             'web-background.jpg', 'page-bg-noise-01.png', 'page-bg-noise-02.png', 'page-bg-noise-03.png', 
                             'page-bg-noise-04.png', 'page-bg-noise-05.png', 'page-bg-noise-06.png', 'page-bg-noise-07.png'
                            ];
    private $module;
    private $dirName;

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
        $useableFiles = collect();
        foreach ($files as $index => $file) {
            
            $fileName = base64_decode(str_replace($this->dirName.'/', '', $file));
            if(in_array($fileName, $this->ignoredFiles)) {
                Storage::delete($file);
                unset($files[$index]);
                continue;
            }

            $useableFiles->put($fileName, $file);
        }

        $this->compressHTML($useableFiles);
    }

    private function compressHTML($useableFiles) {
        $htmlFile = $useableFiles->filter(function($value, $key) {
            return Str::endsWith($key, '.html');
        })->first();

        
    }
}
