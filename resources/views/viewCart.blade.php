@extends('layout')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="{{asset('js/jquery-3.6.0.js')}}"></script>

    <title>View Cart</title>

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
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if (!$carts->isEmpty())
                                @foreach ($carts as $cart)
                                    <tr style="text-align:center">
                                        <td>
                                            @if(app('request')->input('page'))
                                                {{ (app('request')->input('page')-1)*5+$loop->iteration }}
                                            @else {{ $loop->iteration }}
                                            @endif
                                        </td>
                                        <td>{{$cart->name}}</td>
                                        <td><img class="image-size" src="{{URL::asset('/storage/public/'.$cart->imagepath)}}"></td>
                                        <td>{{$cart->quantity}}</td>  
                                        <td>{{'Rp. ' . number_format($cart->price, 2)}}</td>  
                                        <td>{{'Rp. ' . number_format($cart->quantity * $cart->price, 2)}}</td>       
                                        <td>
                                            @if($status[0]->status == "Not Finalized")
                                                <button type="button" class="btn btn-primary mar-left" data-toggle="modal" data-target="#addModal"  data-whatever="{{json_encode($cart)}}">Edit</button>  
                                                <button type="button" class="btn btn-primary mar-left" onclick="deleteActivity({{ $cart->id }})">Remove</button>  
                                            @endif                                      
                                        </td>
                                    </tr>                           
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    @if ($carts->isEmpty())
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

                        @if($status[0]->status == "Finalized")
                            <button type="button" class="btn btn-secondary mar-left" >Go to Cashier to Complete The Transaction</button>
                        @else
                            <button type="button" class="btn btn-primary mar-left" onclick="finalizeCart({{ $carts }})">Finalize</button>    
                        @endif
                    @endif
                </h5>
            </div>
        </div>

        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add to Cart</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert">
                            <div id="message"></div>
                            <button type="button" class="close" id="closeBtn" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form>
                            <div class="form-group" id="formId">
                                <label for="id" class="col-form-label">Id:</label>
                                <input type="text" class="form-control" name="id" id="id">
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-form-label">Product Name:</label>
                                <input type="text" class="form-control" name="name" id="name">
                            </div>

                            <div class="form-group" id="priceForm">
                                <label for="price" class="col-form-label">Price:</label>
                                <input type="text" class="form-control" name="price" id="price">
                            </div>

                            <div class="form-group" id="stockForm">
                                <label for="stock" class="col-form-label">Stock:</label>
                                <input type="number" class="form-control" name="stock" id="stock">
                            </div>

                            <div class="form-group">
                                <label for="quantity" class="col-form-label">Quantity:</label>
                                <input type="number" class="form-control" name="quantity" id="quantity">
                            </div>

                            <div class="modal-footer">
                                <input type="button" class="btn btn-primary" id="addBtn" value="Add">
                            </div>
                        </form>
                    </div>
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

            var cart = button.data('whatever')
            $('#id').val(cart.id)
            $('#id').attr('disabled', 'disabled')
            $('#formId').hide()
            $('#name').val(cart.name)
            $('#name').attr('disabled', 'disabled')
            $('#stock').val(cart.stock)
            $('#stock').attr('disabled', 'disabled')
            $('#stockForm').hide()
            $('#price').val(cart.price)
            $('#price').attr('disabled', 'disabled')
            $('#priceForm').hide()
            $('#quantity').val(cart.quantity)
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
                url: '/viewCart/edit',
                type: 'POST',
                data: request,
                dataType: 'json',
                processData: false,
                contentType: false,
                success:function(data){
                    console.log(data);  
                    window.location.replace("/viewCart"); 
                    alert('Item successfully edited')      
                },
            });
        }
    });

    function deleteActivity(id){
        var result = confirm("Are You sure want to remove this item from cart?");
        if (result) {
            var request = new FormData();

            request.append('id', id);

            $.ajax({
                url: '/viewCart/delete',
                type: 'POST',
                data: request,
                dataType: 'json',
                processData: false,
                contentType: false,
                success:function(data){
                    console.log(data);  
                    window.location.replace("/viewCart"); 
                    alert('Item successfully removed from cart')      
                },
            });
        }
    }

    function finalizeCart(carts){
        var result = confirm("Are You sure want to finalize this cart?");
        if (result) {
            for(cart of carts){
                if(parseInt(cart.quantity) > parseInt(cart.stock)){
                    alert(cart.name + " quantity cannot be higher than " + cart.stock + "!")

                    return;
                }
            }

            $.ajax({
                url: '/viewCart/finalize',
                type: 'POST',
                data: {},
                dataType: 'json',
                processData: false,
                contentType: false,
                success:function(data){
                    console.log(data);  
                    window.location.replace("/viewCart"); 
                    alert('Successfully finalize cart')      
                },
            });
        }
    }

</script>