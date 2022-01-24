@extends('layout')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="{{asset('js/jquery-3.6.0.js')}}"></script>

    <title>View Products</title>

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

    </style>
</head>
<body>
    @section('content') 
        <div class="card">
            <div class="card-header">              
                <form class="form-inline my-2 my-lg-0" enctype="multipart/form-data" action="/viewProducts" method="POST">
                    @csrf
                    <label for="search" class="nav-link">Product Name</label>
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search">
                    <button class="btn btn-primary my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
            <div class="card-body">
                <div class="card-content">
                    <table class="table">
                        <thead class="thead-red-brown">
                          <tr style="text-align:center">
                            <th scope="col">No</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Product Type</th>
                            <th scope="col">Description</th>
                            <th scope="col">Price</th>
                            <th scope="col">Image</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if (!$products->isEmpty())
                                @foreach ($products as $product)
                                    <tr style="text-align:center">
                                        <td>
                                            @if(app('request')->input('page'))
                                                {{ (app('request')->input('page')-1)*5+$loop->iteration }}
                                            @else {{ $loop->iteration }}
                                            @endif
                                        </td>
                                        <td>{{$product->name}}</td>
                                        <td>{{$product->producttype}}</td>
                                        <td>{{$product->description}}</td>
                                        <td>{{'Rp. ' . number_format($product->price, 2)}}</td>
                                        <td><img class="image-size" src="{{URL::asset('/storage/public/'.$product->imagepath)}}"></td>
                                        <td>
                                            @if (!$header->isEmpty())
                                                @foreach ($header as $obj)                                              
                                                    @if($product->id == $obj->product_id)
                                                        <button type="button" class="btn btn-secondary mar-left" >Already Added to Cart</button>
                                                        @break
                                                    @elseif ($loop->last)
                                                        <button type="button" class="btn btn-primary mar-left" data-toggle="modal" data-target="#addModal"  data-whatever="{{json_encode($product)}}" >Add to Cart</button>                                               
                                                    @endif                                       
                                                @endforeach   
                                            @else  
                                                <button type="button" class="btn btn-primary mar-left" data-toggle="modal" data-target="#addModal"  data-whatever="{{json_encode($product)}}" >Add to Cart</button>
                                            @endif                                      
                                        </td>
                                    </tr>                           
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    @if ($products->isEmpty())
                    <div class="bg-light" style="padding:5px 5px 25px 5px">
                        <div style="padding: 0px 5px">
                            No data...
                        </div>
                    </div>
                    @endif
                    <div style="text-align: right;">
                        @if (!$products->isEmpty())
                            {{ $products->links() }}
                        @endif
                    </div>
                </div>
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
                                <label for="id" class="col-form-label">Product Id:</label>
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