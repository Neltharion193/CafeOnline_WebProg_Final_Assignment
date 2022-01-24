<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>

    <title>@yield('title')</title>

    <style>
        .pad{
            padding-left: 10px;
        }

        .title-style{
            padding: 20px 0px 20px;
            font-size: 40px;
            color: white;
        }

        .foot-style{
            font-size: 14px;
            color: white;
        }

        .navbar{
            padding: 0;
        }

        .footer {
            bottom: 0;
            width: 100%;
            height: 30px;
            line-height: 30px;
        }

        .bg-red-brown{
            background-color: #800000;
            color: white;
        }

        .btn-primary{
            background-color: #800000 !important;
            border-color: #800000 !important
        }

        .btn-primary:hover{
            background-color: #A52A2A !important;
            border-color: #A52A2A !important
        }

        .navbar a:hover{
            opacity: 50%;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-red-brown">
        <a class="navbar-brand text-white pad" href="{{url('/home')}}">CafeOnline</a>
        <button class="navbar-toggler bg-white" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            @if (Session::get('usersession')['user_type_id'] != 3)
                <a class="nav-link text-white" href="{{url('/manageProduct')}}">Manage Product</a>
                @if (Session::get('usersession')['user_type_id'] == 1)
                    <a class="nav-link text-white" href="{{url('/registerStaff')}}">Create Staff Account</a>
                @endif      
                <a class="nav-link text-white" href="{{url('/viewCheckout')}}">Manage Checkout</a> 
                <a class="nav-link text-white" href="{{url('/historyCheckout')}}">History Checkout</a>           
            @else
                <a class="nav-link text-white" href="{{url('/viewProducts')}}">View Product</a>
                <a class="nav-link text-white" href="{{url('/viewCart')}}">View Cart</a> 
                <a class="nav-link text-white" href="{{url('/historyTransaction')}}">History Transaction</a>
            @endif
          </div>
        </div>
        <a class="nav-link text-white" href="{{url('/logout')}}">Logout</a>
    </nav>

    @yield('content')

    <footer class="footer bg-red-brown">
        <div class="foot-style text-center">
            © CafeOnline 2021
        </div>
    </footer>

</body>
</html>