<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use File;
use JavaScript;
use SSH;
use DB;

class graphController extends Controller
{
	private $job_status;
	private $result_status;
	private $result_file;

	public function submit(Request $req)
	{
		$job_id = Input::get('job_id');

		$this->validate($req, [
            'job_id' => 'required|integer',
        ]);

		$funel = DB::table('funel')->where('job_id', '=', $job_id)->first();
		if(empty($funel))
		{
			return view('funel');
		}
      
		/*
		$command = 'qstat -j '.$job_id;
        SSH::run($command, function($line){
           $this->job_status = $line.PHP_EOL;
        });
     
        $words = explode(" ", $this->job_status);
        if($words[0] !== 'Following') {
        	return view('submit_graph', [ 'option' => 1, 'job_id' => $job_id ]);
        }
        else {	
        	$this->checkResultStatus($funel);
        	$this->generateNetwork($this->result_file);
        	return view('graph');
        }
        // */
        $this->result_file = storage_path().'/result/1221625_co-prediction_network.txt';
        $this->generateNetwork($this->result_file);
        return view('graph', [ 'project_name' => $funel->project_name,
        					   'configuration' => $funel->configuration,
        					   'attribute' => $funel->attribute ]);
      	
	}

	/**
	 * Chcek if output file has string 'Co-prediction netowrk generated.' or not.
	 * If yes, the file is downloaded to local storage. 
	 * If not, this means that the network is impossible to be genearated.
	 *
	 * @return void
	 */
	public function checkResultStatus($funel)
	{
		$project_name = $funel->project_name;
		$file_name = 'strong-'.$project_name.'.o'.$funel->job_id;

		$command = 'cat '.$file_name;
        SSH::run($command, function($line){
           $this->result_status = $line.PHP_EOL;
        });

        if(trim($this->result_status) === 'Co-prediction network generated.') 
        {
        	$this->downloadFile($funel);
        } 
        else 
        {
        	return view('submit_graph', ['option' => 2]);
        }
	}

	/**
	 * Download co-prediction_network.txt from remote server to local storage
	 *
	 * @return void
	 */
	public function downloadFile($funel)
	{	
		$project_name = $funel->project_name;
		$job_id = $funel->job_id;

		$remote_path = 'funel/results/'.$project_name.'/co-prediction_network.txt';
		$file_name = $job_id.'_co-prediction_network.txt';;

		SSH::get($remote_path, storage_path().'/result/'.$file_name);

		$this->result_file = storage_path().'/result/'.$file_name;
	}

	/**
	 * Create nodes and edges from the file and send data to View
	 *
	 * @return void
	 */
	public function generateNetwork($file) {

		$nodes_str = array(); // single nodes
		$edges_str = array(); // each edge contains left node and right node

		// Extract each node from text file line by line
		foreach(file($file) as $line) {
			$left_node = substr($line, 0, strpos($line, ' '));
			$space_position = strpos($line, ' ') + 1;
			$right_node = substr($line, $space_position , strlen($line) - $space_position -1);

			//echo $left_node . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
			//echo $right_node . '<br/>';

			array_push($edges_str, ['left_node' => $left_node, 'right_node' => $right_node]);

			if(!in_array($left_node, $nodes_str)) {
				array_push($nodes_str, $left_node);
			}
			if(!in_array($right_node, $nodes_str)) {
				array_push($nodes_str, $right_node);
			}
		}

		JavaScript::put([
	        'nodes_str' => $nodes_str,
	        'edges_str' => $edges_str
    	]);

	}
}