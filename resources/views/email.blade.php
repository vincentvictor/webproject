<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>


        <title>Laravel</title>

        <!-- Fonts -->
               

        <!-- Styles -->
  
    </head>

    <body>
        <center>
            <form action="/send" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                Title: <input type="text" name="title"><br/>
                Content: <input type="text" name="content"><br/>
                <input type="submit" name="submit" value="SEND">


            </form>
        </center>
    </body>

</html>
