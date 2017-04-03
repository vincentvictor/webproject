<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

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
        </style>
    </head>
    <body>
        <center>

            Display Data

            <table class="table">
                <tr>
                    <td>Project ID</td>
                    <td>Project name</td>
                    <td>Dataset</td>
                    <td>Configuration</td>
                    <td>Attributes</td>
                </tr>
                
                <?php
                    foreach ($funels as $funel_each) {
                    ?>

                    <tr>
                        <td><?php echo $funel_each->project_id ?></td>
                        <td><?php echo $funel_each->project_name ?></td>
                        <td><?php echo $funel_each->dataset ?></td>
                        <td><?php echo $funel_each->configuration ?></td>
                        <td><?php echo $funel_each->attributes ?></td>
                    </tr>

                    <?php
                    }
                    ?>
                
            </table>

            @foreach($funels as $funel)
                <img src="{{ $funel->dataset }}" alt="dataset" width="150" height="150">
            @endforeach


        </center>
    </body>
</html>
