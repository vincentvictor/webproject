<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>FuNeL User Interface</title>

        <!-- Fonts 
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css"> 
        -->
        {!! Html::style('css/app.css') !!}
        {!! Html::script('js/app.js') !!}

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            #box {
                width: 83%;
                height: 500px;
                top: 5%;
                border-radius: 25px;
                border: 2px solid #4682B4;
            }

        </style>



    </head>
    <body>
        <center>
            <h1>FuNel User Interface</h1>

            <h3>
                <a id="showfunel" href="/funel">Run a FuNeL</a> | 
                <a id="showgraph" href="/funel">Generate a Network</a>
            </h3>
        </center>
        <hr>

        <div class="col-md-11 col-md-offset-1" id="box" >
            <center>
            <h3>Your queue number is...</h3>
            <p style="font-size: 70pt;"> {{ $job_id}} </h1>
            </center>
             
        </div>

    </body>
</html>
