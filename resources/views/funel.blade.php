<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>FuNeL User Interface</title>

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

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: black;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            #box {
              width: 83%;
              height: 500px;
              top: 5%;
              /*border: 1px solid lightgray;*/
            }

            #description {
                top: 5px;
                height: 100%;
                border-radius: 25px;
                border: 2px solid #4682B4;
            }

        </style>

    </head>
    <body>
        <center>

        <h1>FuNel User Interface</h1>

        <h3>
        <a id="showfunel" href="#" onclick="$('.graphrequest').hide(); $('.funelrequest').slideDown();">Run a FuNeL</a> | 
        <a id="showgraph" href="#" onclick="$('.funelrequest').slideUp(); $('.graphrequest').slideDown();">Generate a Network</a>
        </h3>
        </center>
        <hr>

        <div class="col-md-11 col-md-offset-1" id="box" >

             <div class="col-md-6 well" id="description">
                <center> 
                    <h4>What is FuNeL?</h4>  FuNeL is a biological data analysis which uses machine learning to generate functional networks using the co-prediction paradigm. A machine learning rule-based classification algorithm called BioHEL identifies relationships between genes. The genes within the same classification rules could be assumed that they are more likely to be functionally related at biological level. 

                    <br/>
                    <a href="http://ico2s.org/software/tutorials/funel.html" target="_blank">FuNeL Tutorial</a> |
                    <a href="https://biodatamining.biomedcentral.com/articles/10.1186/s13040-016-0106-4" target="_blank">Full Documentation</a>
                
                    <br/>
                   
                    <h4> How to run a FuNel...</h4>
                    </center>
                    1. Enter your project name <br/>
                    2. Select a dataset you would like to run. The file must be in <b>.arff</b> format <br/>
                    3. Select your configuration: <br/>
                    &emsp;C1: Reduced dataset + 1 stage of network generation <br/>
                    &emsp;C2: Original dataset + 1 stage of network generation <br/> 
                    &emsp;C3: Reduced dataset + 2 stages of network generation <br/>
                    &emsp;C4: Original dataset + 2 stages of network generation <br/>
                    4. Enter the number of attributes <br/>
                    5. Press Submit button. You will receive a queue number <br/>
                    6. Wait for the results then enter your queue number in Generate a Network page
            </div>
            
            <div class="col-md-6">
                <div class="funelrequest">

                    <h3><center>Run a FuNeL</center> </h3>
                    <form align="left" action="/submit_funel" method="post" enctype="multipart/form-data">
                        
                        <!-- This line is for security reason -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">  <br/><br/>

                        <div class="col-md-12">
                            <div class="col-md-4 col-md-offset-1">Project name:</div>
                            <div class="col-md-6">
                                <input type="text" name="project_name"> <br/><br/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-4 col-md-offset-1">Dataset:</div>
                            <div class="col-md-6">
                                <input type="file" name="dataset" > <br/><br/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-4 col-md-offset-1">Configuration:</div>
                            <div class="col-md-6">
                                <input name="configuration" type="radio" value="1"> C1 
                                <input name="configuration" type="radio" value="2"> C2 
                                <input name="configuration" type="radio" value="3"> C3
                                <input name="configuration" type="radio" value="4"> C4 <br/><br/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-4 col-md-offset-1">Attributes:</div> 
                            <div class="col-md-6">
                                <input type="number" name="attribute"> <br/><br/>
                            </div>
                        </div>
                        <br/><br/><br/>
                      
                        <!-- <input type="submit" name="submit" value="Submit"> -->
                        <div class="col-md-offset-5">
                            <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                        </div>

                    </form>
                </div>

                <div class="graphrequest" style="display:none">
                    <h3><center>Generate a Network</center> </h3> <br/><br/>
                    <form align="left" action="/submit_graph" method="post" enctype="multipart/form-data">
                        
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"> 

                        <div class="col-md-12">
                            <div class="col-md-4 col-md-offset-1">Queue Number:</div>
                            <div class="col-md-6">
                                <input type="text" name="job_id"> <br/><br/>
                            </div>
                        </div>
                        <br/> <br/> <br/>

                        <div class="col-md-offset-5">
                            <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                        </div>
                    </form>
                </div>

                <br/>

                <div class="col-md-12">
                     @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>   
                    @endif
                </div>

            </div>

        </div>

    </body>
</html>
