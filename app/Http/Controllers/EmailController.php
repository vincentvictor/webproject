<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use Log;
use App\Jobs\SendWelcomeEmail;

class EmailController extends Controller
{
    public function send(Request $request){

    	/*	Send data and test with mailtrap, not using queue

    	$title = $request->input('title');
    	$content = $request->input('content');
    	echo $title.<'br/'>;
    	echo $content.<'br/'>;

    	Mail::send('email', ['title' => $title, 'content' => $content], function($message) {
    		$message->from('nichy.han@gmail.com', 'Nichy han');
    		$message->to('hi@gmail.com');
    	});

    	return response()->json(['message' => 'Request completed']);

    	*/


   		
    	$title = $request->input('title');
    	$content = $request->input('content');

    	Log::info("Request Cycle with Queues Begins");
        $this->dispatch((new SendWelcomeEmail($title, $content))->delay(10));
        Log::info("Request Cycle with Queues Ends");
		



    }
}
