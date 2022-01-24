@extends('layout')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="{{asset('js/jquery-3.6.0.js')}}"></script>

    <title>History Checkout Detail</title>

    <style>
        .card{
            border-radius: 0px !important;
            border: 0px !important;
            height: auto !important;
            min-height: 90vh !important;
        }

        .card-header{
            display:flex;
        }

        .card-body{
            height: auto;
        }

        .mar-left{
            margin-left: 10px;
        }

        .thead-red-brown{
            background-color: #800000;
            color:white
        }

        .image-size{
            width:100px; 
            height:auto;
        }
        .total{
            text-align:right;
            margin-right: 2%;
        }
    </style>
</head>
<body>
    @section('content') 
        <div class="card">
            <div class="card-header">              
                <h4>History Checkout Detail</h4>
            </div>
            <div class="card-body">
                <div class="card-content">
                    <table class="table">
                        <thead class="thead-red-brown">
                          <tr style="text-align:center">
                            <th scope="col">No</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Image</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                            <th scope="col">Sub-Total</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if (!$details->isEmpty())
                                @foreach ($details as $detail)
                                    <tr style="text-align:center">
                                        <td>
                                            @if(app('request')->input('page'))
                                                {{ (app('request')->input('page')-1)*5+$loop->iteration }}
                                            @else {{ $loop->iteration }}
                                            @endif
                                        </td>
                                        <td>{{$detail->name}}</td>
                                        <td><img class="image-size" src="{{URL::asset('/storage/public/'.$detail->imagepath)}}"></td>
                                        <td>{{$detail->quantity}}</td>  
                                        <td>{{'Rp. ' . number_format($detail->price, 2)}}</td>  
                                        <td>{{'Rp. ' . number_format($detail->quantity * $detail->price, 2)}}</td>       
                                    </tr>                           
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    @if ($details->isEmpty())
                    <div class="bg-light" style="padding:5px 5px 25px 5px">
                        <div style="padding: 0px 5px">
                            No data...
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="card-footer">
                <h5 class="total">
                    @if ($total)
                        {{'Total Fee = Rp. ' . number_format($total, 2)}}
                    @endif
                </h5>
            </div>
        </div>
    @endsection
</body>
</html>