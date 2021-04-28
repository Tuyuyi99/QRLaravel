<!DOCTYPE html>
<html>
    <head>
        <title>@yield("title")</title>
        <link rel="stylesheet" {{ asset('css/styles.css') }}>
    </head>
    <body>
        <div>@yield("content")</div>
    </body>
</html>
