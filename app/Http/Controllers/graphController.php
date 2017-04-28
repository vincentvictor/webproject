<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use File;
use JavaScript;
use Structures_Graph;
use Structures_Graph_Node;
use SSH;


class graphController extends BaseController
{


	public function submit()
	{
		$job_id = Input::get('job_id');
		$record = DB::table('funel')->where('job_id', '=', $job_id)->first();
		$project_name = $record->project_name;

		$file_name = 'strong-'.$project_name.'e*';
		$commands = 'cat '.$file_name;
        SSH::run($commands, function($line){
            $results = $line.PHP_EOL;
        });
        /*
        if($result='...')
        {
        	SSH::get(...);
        }
        else 
        {

        }
		*/
	}






	public function getFile() {

		$path = '/Users/nichyhan/Documents/funel/results/lym6/co-prediction_network.txt';

		/*
		 * @param boolean $directed Set to true if the graph is directed.
         *                      	Set to false if it is not directed.
      	 */

		$nodes_str = array(); // single nodes
		$edges_str = array(); // each edge contains left node and right node

		// Extract each node from text file line by line
		foreach(file($path) as $line) {
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

		foreach($nodes_str as $key => $node) {
			//echo $node.'<br/>';
		}

		JavaScript::put([
	        'nodes_str' => $nodes_str,
	        'edges_str' => $edges_str
    	]);

    	return view('graph');

	}
}