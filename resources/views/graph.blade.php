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
                color: #636b6f;
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

            #mynetwork {
              width: 800px;
              height: 600px;
              border: 1px solid lightgray;
            }

        </style>

    </head>


    <body>

        @include('footer')

        <center>
        <h1>Coprediction Network</h1>
        
        <div id="mynetwork"></div>

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

            // create a network
            var container = document.getElementById('mynetwork');
            var data = {
                nodes: nodes,
                edges: edges
            };
            var options = {};
            var network = new vis.Network(container, data, options);
        </script>


        </center>
    </body>
</html>
