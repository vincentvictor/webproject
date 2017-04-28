<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Contracts\Filesystem\Filesystem;


use App\Jobs\SendFuNelToQueue;
use App\FunelModel;
use App;
use DB;
use File;
use Redirect;
use Storage;
use SSH;


class FunelController extends Controller
{

    public function submit(Request $req) 
    {

        $this->validateInput($req);
        
        $project_name = Input::get('project_name');
        $dataset = Input::file('dataset');
        $configuration = Input::get('configuration');
        $attribute = Input::get('attribute');
        $hash = md5(uniqid(rand(), true));
        $timestamp = date("Y-m-d H:i:s");

        $funel = new App\Funel($project_name, $configuration, $attribute, $hash, $timestamp);
        $funel->store();

        $file_name = $hash.'_'.$dataset->getClientOriginalName();
        $this->saveFileToStorage($dataset, $file_name);

        // $this->uploadToS3($dataset, $file_name);
        // $isUpload = $this->isUploadSuccessfully($file_name);

        //$job = new SendFunelToQueue($funel, $file_name);
        //$this->dispatch($job);

        //$this->extractJobID($funel);
        //return view('submit_funel', ['job_id' => $funel->job_id]);

        $job_id = 123456789;
        return view('submit_funel', ['job_id' => $funel->job_id]);
       
    }

    /**
     * Validate data inputs
     *
     * @return void
     */
    public function validateInput($req)
    {
        $this->validate($req, [
            'project_name' => 'required|alpha_dash',
            'dataset' => 'required|file',
            'configuration' => 'required',
            'attribute' => 'required|integer|between:1,1000',
        ]);

        $dataset = Input::file('dataset');
        $regex = "/.*"."\\".".arff/i";

        if(!preg_match($regex, $dataset->getClientOriginalName())) 
        {
            return Redirect::back()->with(['file_error' => 'File type is not compatible.']);
        } 
    }

    /**
     * Save the dataset file to local storage
     *
     * @return void
     */
    public function saveFileToStorage($dataset, $file_name)
    {
        $local = \Storage::disk('app');
        $local->put($file_name, file_get_contents($dataset));
    }

    /**
     * Extract job id from the string and update job id to database
     *
     * @return void
     */
    public function extractJobID($funel)
    {
        echo '<br/>';
        while(true) 
        {
            $record = DB::table('funel')->where('hash', '=', $funel->getHash())->first();
            sleep(1);
            echo $record->job_id.'----- <br/>';

            if(!empty($record->job_id)) {
                echo $record->job_id.'<br/>';;
                $words = explode(" ", $record->job_id);
                $job_id = $words[2];
                echo $job_id;
                DB::table('funel')->where('hash', $funel->getHash())->update(['job_id' => $job_id]);

                break;
            }
        }
    }


        
        
        // $outputs = App\OutputModel::all();
        // foreach ($outputs as $output) {
        //     echo $output->output_str.'<br/>';
        // }

        
        
        
        //Save to database
        /*
        
        if(Input::hasFile('dataset')){
            $file = Input::file('dataset');
            $file->move(public_path(). '/', $file->getClientOriginalName());
            $dataset = $file->getClientOriginalName();
        
            $data = array('project_name'=>$project_name, 'dataset'=>$dataset, 'configuration'=>$configuration, 'attributes'=>$attributes);
            DB::table('funel')->insert($data);
            
            echo 'success<br />';
        }
        */

        
        // * Laravel Collective
         
       //SSH::put($file->getRealPath(), 'input_data/' . $file->getClientOriginalName());
        /*
        SSH::get('input_data/' . $file->getClientOriginalName(), storage_path().'/'.$file->getClientOriginalName());

        sleep(10);
        
        $run_funel = './run_funel.sh '.$project_name.' '.'~/input_data/'.$file->getClientOriginalName().' '.$configuration.' '.$attributes;

        $commands = array($run_funel);

        SSH::run($commands, function($line)
        {
            echo $line.PHP_EOL;
        });
        */    

    /**
     * Upload a file to Amazon S3 
     *
     * @return void
     */
    public function uploadToS3($dataset, $file_name)
    {
        $s3 = \Storage::disk('s3');
        $file_path = $file_name; //specify folder name here
        $s3->put($file_path, file_get_contents($dataset), 'public');
    }


    /**
     * Check if the file is uploaded to Amazon S3 successfully
     *
     * @return boolean
     */
    public function isUploadSuccessfully($file_name)
    {
        $i = 0;
        do {
            $i += 1;
            echo $i . '<br/>';
            $exists = \Storage::disk('s3')->exists($file_name);

        } while($exists == false);

        return true;
    }  

    

    public function show()
    {
        // work with constructor with no param
        $funels = App\FunelModel::all();

        return view('display', ['funels' => $funels]);
    }
}
