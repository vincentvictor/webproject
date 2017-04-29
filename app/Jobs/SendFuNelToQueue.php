<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Storage;
use SSH;
use File;
use App;
use DB;

class SendFunelToQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $project_name;
    public $configuration;
    public $attribute;
    public $hash;
    //public $job_str = '';
    public $job_id = 'hello';
    public $file_name;

    /**
     * Create a new job instance.
     *
     * @return void
    */
    public function __construct($funel, $file_name)
    {
        $this->project_name = $funel->getProjectName();
        $this->configuration = $funel->getConfiguration();
        $this->attribute = $funel->getAttributes();
        $this->hash = $funel->getHash();
        $this->file_name = $file_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Get the file from local storage and upload to remote server
        $file_path  = Storage::disk('app')->getDriver()->getAdapter()->getPathPrefix().$this->file_name;
        SSH::put($file_path, 'input_data/'.$this->file_name);

        sleep(2);

        // Run funel command
        $command = './funel/coprediction.sh '.$this->project_name.' input_data/'.$this->file_name.' '.$this->configuration.' '.$this->attribute;
        
        SSH::run($command, function($line){
            echo $line.PHP_EOL;
            $this->job_id = $line.PHP_EOL;
        });

        echo $this->job_id;

        // Save output from the command to database 
        DB::table('funel')->where('hash', $this->hash)->update(['job_id' => $this->job_id]);


    }

}
