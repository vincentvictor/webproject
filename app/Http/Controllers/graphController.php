<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use File;
use Structures_Graph;
use Structures_Graph_Node;


class graphController extends BaseController
{
	public function getFile() {

		$path = '/Users/nichyhan/Documents/funel/results/lymphoma3/co-prediction_network.txt';

		/*
		 * @param boolean $directed Set to true if the graph is directed.
         *                      	Set to false if it is not directed.
      	 */
		$nonDirectedGraph = new Structures_Graph(false);


		$edges = array();
		$nodes = array();

		foreach(file($path) as $line) {
			$leftNode = substr($line, 0, strpos($line, ' '));
			$spacePos = strpos($line, ' ') + 1;
			$rightNode = substr($line, $spacePos , strlen($line) - $spacePos -1);

			echo $leftNode . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
			echo $rightNode . '<br/>';

			if(!in_array($leftNode, $nodes)) {
				array_push($nodes, $leftNode);
			}
			if(!in_array($rightNode, $nodes)) {
				array_push($nodes, $rightNode);
			}
		}

		echo '/////////////////////////////////////////<br/>';

		$graphNodes = array();
		foreach($nodes as &$node) {
			$temp = new Structures_Graph_Node();
			$temp->setData($node);
			array_push($graphNodes, $temp);
		}


		echo '//////////////////// LAST /////////////////////<br/>';

		foreach($graphNodes as $key => $gnn) {
			echo $gnn->getData() . ' '. $graphNodes[$key]->getData();
			echo '<br/>';
		}


		return view('graph');

	}

}