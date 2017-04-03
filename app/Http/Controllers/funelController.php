<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use DB;
use App\Funel;
use App\files;
use File;
use Storage;
use SSH;


class funelController extends BaseController
{

    public function submit(Request $req) 
    {
        $project_name = Input::get('project_name');
        $configuration = Input::get('configuration');
        $attributes = Input::get('attributes');
        
        // Save to database
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

        //=========================================================================

        /*
         * Laravel Collective
         */
        $file = Input::file('dataset');
        SSH::put($file->getRealPath(), 'input_data/' . $file->getClientOriginalName());
        SSH::get('input_data/' . $file->getClientOriginalName(), storage_path().'/'.$file->getClientOriginalName());

        sleep(10);
        
        $run_funel = './run_funel.sh '.$project_name.' '.'~/input_data/'.$file->getClientOriginalName().' '.$configuration.' '.$attributes;

        $commands = array($run_funel);

        SSH::run($commands, function($line)
        {
            echo $line.PHP_EOL;
        });

        //=========================================================================
        
        /*
         * Symfony

        $move_to_funel = '/Users/nichyhan/Documents/funel';

        //$process = new Process('./coprediction.sh '.$project_name.' data/lymphoma_dataset '.$configuration.' '.$attributes);
        $process = new Process('ssh b6062185@cs-hpcgateway-mgmt.ncl.ac.uk cdls funel/results');

        
        $process->setWorkingDirectory($move_to_funel);
        $process->setTimeout(3600);
        $process->run();

        echo '<br/> Command line: ' . $process->getCommandLine() . '<br/>';

        $process->restart();
        if (!$process->isSuccessful()) {
            echo "<br/ >Failed<br/>";
            throw new ProcessFailedException($process);
        } else {
            echo '<br/> Success <br/>';
            echo $process->getOutput();
            echo $process->isTerminated();;
        }
        */

        //=========================================================================        
    	
    }

    public function show()
    {
        $funels = funel::all();

        return view('display', ['funels' => $funels]);
    }
}
