@extends('layout')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>

    <script type="text/javascript" src="{{asset('js/jquery-3.6.0.js')}}"></script>

    <style>
        .card{
            background-image: url("/storage/public/images/home-wallpaper.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            border-radius: 0px !important;
            border: 0px !important;
        }

        .card-body{
            height: 68.9vh;
        }

        .card-content{
            position: absolute;
            top: 50%;
            left: 50%;
            margin-right: -50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body>
    @section('content')
        <div class="card text-center">
            <div class="card-header">
                @if (Session::get('usersession'))
                    <h4 class="text-white"> Welcome, {{Session::get('usersession')['gender'] == 'male' ? 'Mr. ' : 'Mrs. '}}
                        {{Session::get('usersession')['fullname']}} 
                    </h4> 
                @endif
            </div>
            <div class="card-body">
                <div class="card-content">
                    @if (Session::get('usersession')['user_type_id'] == 3)
                        <h5 class="card-title text-white">Our cafe will always provides the greatest menu and services to you!!!</h5>
                        <p class="card-text text-white">To View and Buy our Product, please click this button</p>
                        <a href="{{url('/viewProducts')}}" class="btn btn-primary">View Product</a>
                    @else
                        <h5 class="card-title text-white">To manage our Product, please click this button</h5>
                        <a href="{{url('/manageProduct')}}" class="btn btn-primary">Manage Product</a>
                    @endif
                </div>
            </div>
            <div class="card-footer">
                <h5 class="text-white">Have a great day!!!</h5>
            </div>
        </div>
    @endsection
</body>
</html>

<script>
    var message = '{{Session::get('message')}}';
    var exist = '{{Session::has('message')}}';
    if(exist){
        alert(message);
    }
</script>