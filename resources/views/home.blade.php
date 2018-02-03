<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>GUI</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <body>
        <div class="flex-center position-ref full-height">
            <form action="/add" method="post">
                {{ csrf_field() }}
                <input type="text" name="name" id="name" placeholder="username" />
                <input type="submit" value="Add user" />
            </form>

            @if (count($users) > 0)
                @include('users')
            @endif

            @if (count($holds) > 0)
                @include('holds')
            @endif
        </div>
    </body>
</html>
