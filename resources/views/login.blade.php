<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('styles/style.css') }}">
</head>
<body>
    <div class="container">
        <div class="title">CafeOnline</div>
        <div class="title">Login</div>
        <div class="content">
            <div class="error">
                @if ($errors->any())
                    <span style="color:red">{{$errors->first()}}</span>
                @endif              
            </div>
            <br>
            <form enctype="multipart/form-data" action="/login/validate" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com">   
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password">  
                </div>

                <div class="form-group row justify-content-center">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button>
                    </div>
                </div>
            </form>
            <div style="text-align: center;"><a href={{url('/changePassword')}} class="text-red-brown">Change Password?</a></div>
            <div style="text-align: center;">Don't have an account? <a href={{url('/register')}} class="text-red-brown">Sign up</a></div>
        </div>
    </div>

<script>
    var message = '{{Session::get('message')}}';
    var exist = '{{Session::has('message')}}';
    if(exist){
        alert(message);
    }
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
</body>
</html>