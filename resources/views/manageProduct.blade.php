@extends('layout')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script type="text/javascript" src="{{asset('js/jquery-3.6.0.js')}}"></script>

    <title>Manage Product</title>

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
                <form class="form-inline my-2 my-lg-0" enctype="multipart/form-data" action="/manageProduct" method="POST">
                    @csrf
                    <label for="search" class="nav-link">Product Name</label>
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search">
                    <button class="btn btn-primary my-2 my-sm-0" type="submit">Search</button>
                </form>
                <div class="form-inline my-2 my-lg-0">
                    <button class="btn btn-primary mar-left" data-toggle="modal" data-target="#addModal" type="button">Add New Product</button>
                </div>
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
                            <th scope="col">Stock</th>
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
                                        <td>{{$product->stock}}</td>
                                        <td><img class="image-size" src="{{URL::asset('/storage/public/'.$product->imagepath)}}"></td>
                                        <td>
                                            <button type="button" class="btn btn-primary mar-left" data-toggle="modal" data-target="#addModal"  data-whatever="{{json_encode($product)}}" >Update</button>
                                            <button type="button" class="btn btn-primary mar-left" onclick="deleteActivity({{ $product->id }})">Delete</button>
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
                        <h5 class="modal-title" id="addModalLabel">Create New Product</h5>
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
                            <div class="form-group">
                                <label for="type" class="col-form-label">Product Type:</label>
                                <select class="form-control" id="type" name="type">
                                    @foreach ($types as $type)
                                        <option value="{{$type->id}}">{{$type->producttype}}</option>
                                    @endforeach                              
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="price" class="col-form-label">Price:</label>
                                <input type="number" class="form-control" name="price" id="price">
                            </div>
                            <div class="form-group">
                                <label for="stock" class="col-form-label">Stock:</label>
                                <input type="number" class="form-control" name="stock" id="stock">
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-form-label">Description:</label>
                                <textarea class="form-control" name="description" id="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="product_image">Image:</label>
                                <input type="file" name="product_image" id="product_image">
                            </div>

                            <div class="modal-footer">
                                <input type="button" class="btn btn-primary" id="addBtn" value="Add">
                                <input type="button" class="btn btn-primary" id="editBtn" value="Update">
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
            $('#name').val(product.name)
            $('#type').val(product.product_type_id)
            $('#price').val(product.price)
            $('#stock').val(product.stock)
            $('#description').val(product.description)
            $('#formId').show()
            $('#addBtn').hide()
            $('#editBtn').show()
        }
        else{
            $('#addModalLabel').html("Create New Product")
            $('#id').val("")
            $('#id').attr('disabled', 'disabled')
            $('#name').val("")
            $('#type').val(1)
            $('#price').val("")
            $('#stock').val("")
            $('#description').val("")
            $('#formId').hide()
            $('#addBtn').show()
            $('#editBtn').hide()
        }
    });

    $(document).on('click', '#addBtn', function (e) {
        e.preventDefault();

        var message = ""

        var fileExtension = ['jpeg', 'jpg', 'png'];

        if($('#name').val() === "") message = "Product Name cannot be empty!"
        else if($('#price').val() === "") message = "Product Price cannot be empty!"
        else if($('#price').val() < 1000) message = "Product Price must be atleast 1000!"
        else if($('#stock').val() === "") message = "Product Stock cannot be empty!"
        else if($('#stock').val() <= 0) message = "Product Stock must be atleast 1!"
        else if($('#description').val() === "") message = "Description cannot be empty!"
        else if($('#product_image').val() === "") message = "Product Image cannot be empty!"
        else if($.inArray($('#product_image').val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            message = "Product Image extension must be .jpeg or .jpg or .png!"
        }

        if(message != ""){
            $('#message').html(message);
            $('#alert').show();

            return;
        }

        var files = $('#product_image')[0].files;

        var request = new FormData();

        request.append('name', $('#name').val());
        request.append('type', $('#type').val());
        request.append('price', $('#price').val());
        request.append('stock', $('#stock').val());
        request.append('description', $('#description').val());
        request.append('product_image', files[0]);

        $.ajax({
            url: '/manageProduct/create',
            type: 'POST',
            data: request,
            dataType: 'json',
            processData: false,
            contentType: false,
            success:function(data){
                console.log(data);  
                window.location.replace("/manageProduct"); 
                alert('Product successfully added')      
            },
        });
    });

    $(document).on('click', '#editBtn', function (e) {
        e.preventDefault();

        var message = ""

        var fileExtension = ['jpeg', 'jpg', 'png'];

        if($('#name').val() === "") message = "Product Name cannot be empty!"
        else if($('#price').val() === "") message = "Product Price cannot be empty!"
        else if($('#price').val() < 1000) message = "Product Price must be atleast 1000!"
        else if($('#stock').val() === "") message = "Product Stock cannot be empty!"
        else if($('#stock').val() <= 0) message = "Product Stock must be atleast 1!"
        else if($('#product_image').val() && $.inArray($('#product_image').val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            message = "Product Image extension must be .jpeg or .jpg or .png!"
        }

        if(message != ""){
            $('#message').html(message);
            $('#alert').show();

            return;
        }

        var request = new FormData();

        request.append('id', $('#id').val());
        request.append('name', $('#name').val());
        request.append('type', $('#type').val());
        request.append('price', $('#price').val());
        request.append('stock', $('#stock').val());
        request.append('description', $('#description').val());

        if($('#product_image')[0].files){
            var files = $('#product_image')[0].files;
            request.append('product_image', files[0]);
        }

        $.ajax({
            url: '/manageProduct/edit',
            type: 'POST',
            data: request,
            dataType: 'json',
            processData: false,
            contentType: false,
            success:function(data){
                console.log(data);  
                window.location.replace("/manageProduct"); 
                alert('Product successfully edited')      
            },
        });
    });

    function deleteActivity(id){
        var result = confirm("Are You sure want to delete this item?");
        if (result) {
            var request = new FormData();

            request.append('id', id);

            $.ajax({
                url: '/manageProduct/delete',
                type: 'POST',
                data: request,
                dataType: 'json',
                processData: false,
                contentType: false,
                success:function(data){
                    console.log(data);  
                    window.location.replace("/manageProduct"); 
                    alert('Product successfully deleted')      
                },
            });
        }
    }
</script>