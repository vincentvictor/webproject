<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        {!! Html::script('js/app.js') !!}
        {!! Html::style('css/app.css') !!}
        
        {!! Html::script('js/vis.js') !!}
        {!! Html::style('css/vis.css') !!}

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

            #mynetwork {
              width: 100%;
              height: 550px;
              border: 2px solid #4682B4;
              border-radius: 25px;
             /* border: 1px solid lightgray;*/
            }

        </style>

    </head>


    <body>
        @include('footer')
        <center>
            <h1>FuNel User Interface</h1>

            <h3>
            <a id="showfunel" href="/funel">Run a FuNeL</a> | 
            <a id="showgraph" href="/funel">Generate a Network</a>
            </h3>
        </center>
        <hr>

        <div class="col-md-9">
            <div id="mynetwork"></div>
        </div>
        <div class="col-md-3">
            <h3>Co-prediction network</h3>
            <div class="col-md-12">
                <h4><b>Project name:</b></h4>
            </div>
            <div class="col-md-11 col-md-offset-1">
                <h4>{{ $project_name }}</h4>
            </div>
            <div class="col-md-12">
                 <h4><b>Configuration:</b></h4>
            </div>
            <div class="col-md-11 col-md-offset-1">
                <h4>C{{ $configuration }}</h4>
            </div>
            <div class="col-md-6">
                <h4><b>Attribute:</b></h4>
            </div>
            <div class="col-md-11 col-md-offset-1">
                <h4>{{ $attribute }} </h4>
            </div>

         

        </div>

        <script type="text/javascript">
            // Create nodes
            var nodes_arr = [];
            for (var i = 0 ; i < nodes_str.length ; i++) {
                nodes_arr.push({
                    id: nodes_str[i],
                    label: nodes_str[i]
                });
            }

            // Create edges
            var edges_arr = [];
            for (var i = 0 ; i < edges_str.length ; i++) {
                edges_arr.push({
                    from: edges_str[i].left_node,
                    to: edges_str[i].right_node
                });
            }

            var nodes = new vis.DataSet(nodes_arr);
            var edges = new vis.DataSet(edges_arr);

            // Create a network
            var container = document.getElementById('mynetwork');
            var data = {
                nodes: nodes,
                edges: edges
            };
            var options = {};
            var network = new vis.Network(container, data, options);
        </script>

    </body>
</html>
