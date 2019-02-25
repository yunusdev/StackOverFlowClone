<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <title>E-learning Platform  - Register</title>

    <!-- Styles -->
    <link href="assets/css/core.min.css" rel="stylesheet">
    <link href="assets/css/thesaas.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png">
    <link rel="icon" href="assets/img/favicon.png">
    <style>
        .has-error{
            border-color: #dd4b39;
        }
    </style>
</head>

<body class="mh-fullscreen bg-img center-vh p-20" style="background-image: url({{asset('assets/img/bg-girl.jpg')}});">




<div class="card card-shadowed p-50 w-400 mb-0" style="max-width: 100%">
    <h5 class="text-uppercase text-center">Register</h5>
    <br><br>

    <form method="POST" action="{{ route('register') }}" class="form-type-material">
        @csrf
        <div class="form-group">
            <input type="text" value="{{old('name')}}" class="form-control {{ $errors->has('name') ? 'has-error' : '' }}" name="name" placeholder="Name" >
            @if ($errors->has('name'))
                <span  class="help-block" >
                      <strong style="color: #dd4b39; font-size: 12px"><i>{{ $errors->first('name') }}</i></strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <input type="email" value="{{old('email')}}" class="form-control {{ $errors->has('email') ? 'has-error' : '' }}" name="email" placeholder="Email address" >
            @if ($errors->has('email'))
                <span  class="help-block" >
                      <strong style="color: #dd4b39; font-size: 12px"><i>{{ $errors->first('email') }}</i></strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <input type="password" class="form-control {{ $errors->has('password') ? 'has-error' : '' }}" name="password" placeholder="Password" >
            @if ($errors->has('password'))
                <span  class="help-block" >
                      <strong style="color: #dd4b39; font-size: 12px"><i>{{ $errors->first('password') }}</i></strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <input type="password" id="password-confirm" name="password_confirmation" class="form-control" placeholder="Password (confirm)">
        </div>

        <br>
        <button class="btn btn-bold btn-block btn-primary" type="submit">Register</button>
    </form>

    <hr class="w-30">

    <p class="text-center text-muted fs-13 mt-20">Already have an account? <a href="page-login.html">Sign in</a></p>
</div>




<!-- Scripts -->
<script src="assets/js/core.min.js"></script>
<script src="assets/js/thesaas.min.js"></script>
<script src="assets/js/script.js"></script>

</body>
</html>
