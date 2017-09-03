<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')  }}">
</head>

<body>
<div class="container">
    <div class="row">
        <h3>Hello Mr./Ms. {{ $user->getName() }}</h3>
        <p>
            {!! $message_text !!}
        </p>
    </div>
</div>

</body>
</html>