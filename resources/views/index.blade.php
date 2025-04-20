<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Coalition Product Index</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="jumbotron text-center">
          <h1>Product Store Page</h1>
          <p>Enter Product below:</p>
        </div>

        <div class="container">
            <div id="message"></div>
          <div class="row">
            <div class="col-sm-6">
                <form method="POST" action="{{ route('product.store') }}" id="formSubmit">
                    @csrf
                    <table class="table table-striped">
                        <tr>
                            <td>Product name:</td>
                            <td><input type="text" name="product_name" class="form-control" placeholder="Product name" /></td>
                        </tr>
                        <tr>
                            <td>Quantity in stock:</td>
                            <td><input type="number" name="product_quantity" class="form-control" placeholder="Quantity in stock" /></td>
                        </tr>
                        <tr>
                            <td>Price per item:</td>
                            <td><input type="number" name="product_price" class="form-control" placeholder="Price per item" /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><button type="submit" name="btn-submit" class="btn btn-success">Submit</button></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="col-sm-6">
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
                <table class="table table-striped table-hovered">
                    <thead>
                        <tr>
                            <th>Product name</th>
                            <th>Quantity in stock (pcs)</th>
                            <th>Price per item ($)</th>
                            <th>Datetime submitted</th>
                            <th>Total value number ($)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="products">
                        @if($products)
                            @foreach($products as $index=>$product)
                                <tr>
                                    <td>{{ $product['product_name'] }}</td>
                                    <td>{{ $product['product_quantity'] }}</td>
                                    <td>{{ $product['product_price'] }}</td>
                                    <td>{{ $product['created_at'] }}</td>
                                    <td>{{ number_format(floatval($product['total'])) }}</td>
                                    <td>
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#editModal_{{ $index }}">Edit</button>
                                        <button type="button" class="btn btn-danger" onclick="deleteProduct('{{ route('product.delete', ['id'=>$index]) }}', '{{ $product['product_name'] }}')">Delete</button>

                                        <div id="editModal_{{ $index }}" class="modal fade" role="dialog">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Edit Product</h4>
                                              </div>
                                              <div class="modal-body">
                                                <table class="table table-striped">
                                                    <tr>
                                                        <td>Product name:</td>
                                                        <td><input type="text" name="product_name_{{ $index }}" class="form-control" placeholder="Product name" value="{{ $product['product_name'] }}"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Quantity in stock:</td>
                                                        <td><input type="number" name="product_quantity_{{ $index }}" class="form-control" placeholder="Quantity in stock" value="{{ $product['product_quantity'] }}"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Price per item:</td>
                                                        <td><input type="number" name="product_price_{{ $index }}" class="form-control" placeholder="Price per item" value="{{ $product['product_price'] }}"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>
                                                            <button type="button" onclick="editProduct('{{ route('product.edit', ['id'=>$index]) }}', '{{ $index }}')" name="btn-submit" class="btn btn-success" data-dismiss="modal">Submit</button>
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </td>
                                                    </tr>
                                                </table>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <th colspan="4">Total Value</th>
                                <th colspan="2">{{ number_format($total) }}</th>
                            </tr>
                        @else
                            <tr>
                                <td colspan="5" align="center">No Products Yet</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
          </div>
        </div>

        <script type="text/javascript">
            function deleteProduct(url, name){
                var askAgain =  confirm('Are you sure you want to delete '+name+'?');

                if(askAgain){
                    $.ajax({
                        url: url,
                        success: function(sx){
                            $('#products').html("");
                            var refreshedProducts = "";
                            sx.products.forEach(function(product, index) {
                                $('#products').append(tableData(product, index));
                            });
                            $('#products').append(`
                                <tr>
                                    <th colspan="4">Total Value</th>
                                    <th colspan="2">${sx.total}</th>
                                </tr>
                            `);

                            $('#message').html(`
                                <div class="alert alert-success">
                                  <strong>Success!</strong> ${sx.message}
                                </div>
                            `);
                        }
                    });
                }
            }

            function editProduct(url, index){
                $('#editModal_'+index).modal('hide');
                setTimeout(function(){
                    var productName = $('[name="product_name_'+index+'"]').val();
                    var productQuantity = $('[name="product_quantity_'+index+'"]').val();
                    var productPrice = $('[name="product_price_'+index+'"]').val();


                    if(productName!='' || productQuantity!='' || productPrice!=''){
                        $.ajax({
                            url: url,
                            data: {
                                _token: "{{ csrf_token() }}",
                                product_name: productName,
                                product_quantity: productQuantity,
                                product_price: productPrice
                            },
                            type: 'POST',
                            success: function(sx){
                                $('#products').html("");
                                var refreshedProducts = "";
                                sx.products.forEach(function(product, index) {
                                    $('#products').append(tableData(product, index));
                                });
                                $('#products').append(`
                                    <tr>
                                        <th colspan="4">Total Value</th>
                                        <th>${sx.total}</th>
                                    </tr>
                                `);

                                $('#message').html(`
                                    <div class="alert alert-success">
                                      <strong>Success!</strong> ${sx.message}
                                    </div>
                                `);
                            }
                        });
                    }else{
                        $('#message').html(`
                            <div class="alert alert-danger">
                              <strong>ERROR!</strong> Make sure all fields are filled in correctly.
                            </div>
                        `);
                    }
                }, 500);
            }

            function tableData(product, index){
                return `
                        <tr>
                            <td>${product.product_name}</td>
                            <td>${product.product_quantity}</td>
                            <td>${product.product_price}</td>
                            <td>${product.created_at}</td>
                            <td>${product.total}</td>
                            <td>
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#editModal_${index}">Edit</button>
                                <button type="button" class="btn btn-danger" onclick="deleteProduct('delete/${index}', '${product.product_name}')">Delete</button>

                                <div id="editModal_${index}" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Edit Product</h4>
                                      </div>
                                      <div class="modal-body">
                                        <table class="table table-striped">
                                            <tr>
                                                <td>Product name:</td>
                                                <td><input type="text" name="product_name_${index}" class="form-control" placeholder="Product name" value="${product.product_name}"/></td>
                                            </tr>
                                            <tr>
                                                <td>Quantity in stock:</td>
                                                <td><input type="number" name="product_quantity_${index}" class="form-control" placeholder="Quantity in stock"  value="${product.product_quantity}"/></td>
                                            </tr>
                                            <tr>
                                                <td>Price per item:</td>
                                                <td><input type="number" name="product_price_${index}" class="form-control" placeholder="Price per item"  value="${product.product_price}"/></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <button type="button" onclick="editProduct('edit/${index}', '${index}')" name="btn-submit" class="btn btn-success">Submit</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </td>
                                            </tr>
                                        </table>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </td>
                        </tr>
                    `;
            }

            $(document).ready(function(){
                $('#formSubmit').submit(function(e){
                    e.preventDefault();
                    var productName = $('[name="product_name"]').val();
                    var productQuantity = $('[name="product_quantity"]').val();
                    var productPrice = $('[name="product_price"]').val();


                    if(productName!='' || productQuantity!='' || productPrice!=''){
                        $.ajax({
                            url: "{{ route('product.store') }}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                product_name: productName,
                                product_quantity: productQuantity,
                                product_price: productPrice
                            },
                            type: 'POST',
                            beforeSend: function(bs){
                                $('[name="btn-submit"]').attr('disabled', true);
                                $('[name="btn-submit"]').text('Saving...');
                            },
                            success: function(sx){
                                $('[name="btn-submit"]').attr('disabled', false);
                                $('[name="btn-submit"]').text('Submit');
                                
                                // Clear Form
                                $('[name="product_name"]').val("");
                                $('[name="product_quantity"]').val("");
                                $('[name="product_price"]').val("");

                                $('#products').html("");
                                var refreshedProducts = "";
                                sx.products.forEach(function(product, index) {
                                    $('#products').append(tableData(product, index));
                                });
                                $('#products').append(`
                                    <tr>
                                        <th colspan="4">Total Value</th>
                                        <th>${sx.total}</th>
                                    </tr>
                                `);

                                $('#message').html(`
                                    <div class="alert alert-success">
                                      <strong>Success!</strong> ${sx.message}
                                    </div>
                                `);
                            }
                        });
                    }else{
                        $('#message').html(`
                            <div class="alert alert-danger">
                              <strong>ERROR!</strong> Make sure all fields are filled in correctly.
                            </div>
                        `);
                    }
                });
            });
        </script>
    </body>
</html>
