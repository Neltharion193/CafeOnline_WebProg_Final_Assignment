@extends('layout')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="{{asset('js/jquery-3.6.0.js')}}"></script>

    <title>History Transaction</title>

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
    </style>
</head>
<body>
    @section('content') 
        <div class="card">
            <div class="card-header">              
                <h4>History Transaction</h4>
            </div>
            <div class="card-body">
                <div class="card-content">
                    <table class="table">
                        <thead class="thead-red-brown">
                          <tr style="text-align:center">
                            <th scope="col">No</th>
                            <th scope="col">Fullname</th>
                            <th scope="col">Staff</th>
                            <th scope="col">Transaction Date</th>
                            <th scope="col">Total Fee</th>   
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if (!$headers->isEmpty())
                                @foreach ($headers as $header)
                                    <tr style="text-align:center">
                                        <td>
                                            @if(app('request')->input('page'))
                                                {{ (app('request')->input('page')-1)*5+$loop->iteration }}
                                            @else {{ $loop->iteration }}
                                            @endif
                                        </td>
                                        <td>{{$header->fullname}}</td>
                                        <td>{{$header->staff}}</td>
                                        <td>{{(new DateTime($header->transaction_date))->format('D, d M Y H:i:s')}}</td>
                                        <td>
                                            @if(app('request')->input('page'))
                                                {{'Rp. ' . number_format($totals[(app('request')->input('page')-1)*5+$loop->index]->total, 2)}}                                              
                                            @else 
                                                {{'Rp. ' . number_format($totals[$loop->index]->total, 2)}}
                                            @endif                  
                                        </td>
                                        <td>
                                            <a href="{{url("/historyTransactionDetail/".Crypt::encryptString($header->id))}}" class="btn btn-primary">View Detail</a>
                                        </td>
                                    </tr>                           
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    @if ($headers->isEmpty())
                        <div class="bg-light" style="padding:5px 5px 25px 5px">
                            <div style="padding: 0px 5px">
                                No data...
                            </div>
                        </div>
                    @else
                        <div style="text-align: right;">
                            {{ $headers->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endsection
</body>
</html>

<script type="text/javascript" charset="utf-8">
    var message = '{{Session::get('message')}}';
    var exist = '{{Session::has('message')}}';

    if(exist){
        alert(message);
    }

    $(document).ready(function(){
        $('#alert').hide();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    $(document).on('click', '#closeBtn', function (e) {
        e.preventDefault();

        $('#alert').hide();
    });

    $(document).on('show.bs.modal', '#addModal', function (event) {
        var button = $(event.relatedTarget) 

        if(button.data('whatever')){
            $('#addModalLabel').html("Edit Product")

            var product = button.data('whatever')
            $('#id').val(product.id)
            $('#id').attr('disabled', 'disabled')
            $('#formId').hide()
            $('#name').val(product.name)
            $('#name').attr('disabled', 'disabled')
            $('#stock').val(product.stock)
            $('#stock').attr('disabled', 'disabled')
            $('#stockForm').hide()
            $('#price').val(product.price)
            $('#price').attr('disabled', 'disabled')
            $('#priceForm').hide()
        }
    });

    $(document).on('click', '#addBtn', function (e) {
        e.preventDefault();

        var message = ""

        if($('#quantity').val() === "") message = "Quantity cannot be empty!"
        else if($('#quantity').val() <= 0) message = "Quantity must be atleast 1!"
        else if(parseInt($('#quantity').val()) > parseInt($('#stock').val())) message = "Quantity cannot be higher than " + $('#stock').val() + "!"

        if(message != ""){
            $('#message').html(message);
            $('#alert').show();

            return;
        }

        var result = confirm(
            "Price will be " + 
            $('#quantity').val() + " x " + $('#price').val() + " = " + ($('#quantity').val()*$('#price').val()) +
            ", Are You sure want to add this item to cart?");

        if (result) {
            var request = new FormData();

            request.append('id', $('#id').val());
            request.append('quantity', $('#quantity').val());

            $.ajax({
                url: '/viewProducts/addToCart',
                type: 'POST',
                data: request,
                dataType: 'json',
                processData: false,
                contentType: false,
                success:function(data){
                    console.log(data);  
                    window.location.replace("/viewProducts"); 
                    alert('Item successfully added to cart')      
                },
            });
        }
    });
</script>