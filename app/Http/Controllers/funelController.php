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

        $job = new SendFunelToQueue($funel, $file_name);
        $this->dispatch($job);

        $job_id = $this->extractJobID($funel);
        $funel->updateData($hash, 'job_id', $job_id);

        return view('submit_funel', ['job_id' => $job_id ]);
       
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
        while(true) 
        {
            $record = DB::table('funel')->where('hash', '=', $funel->getHash())->first();
            sleep(1);

            if(!empty($record->job_id)) {
                $words = explode(" ", $record->job_id);
                $job_id = $words[2];
                break;
            }
        }
        return $job_id;
    }

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
