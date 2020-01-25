<?php

?>
@extends('master')

@section('title', 'Cars Refresh')
@section('body_content')
    <style>
        th{
            text-transform: uppercase;
            font-weight: bolder;
        }
    </style>
            <div id="content-wrapper">
                <div class="container"><br>
                    <div class="alert alert-danger" id="ajaxErr" style="display:none">
                        <ul id="errMsg">
                        </ul>
                    </div>  
                    <div class="alert alert-success" id="ajaxSux" style="display:none">
                        <ul id="suxMsg">
                        </ul>
                    </div>  
                    <h1>
                        <b>
                            Enter your new <span style="color:#00de95">Products.</span>
                        </b>
                    </h1>
                    <!-- <h5>Compare prices from local mechanics.</h5><br> -->

                    <div class="row" id="car-desc">
                        <div class="col-md-4">
                            <div>
                                <label>PRODUCT NAME</label>
                                <input name='p_name' id='p_name' class="form-control" placeholder="Product Name"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div>
                                <label>QUANTITY</label>
                                <input type="number" name='p_qty' id='p_qty' class="form-control" placeholder="Quantity"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div>
                                <label>PRICE PER QTY</label>
                                <input type="number" name="amount" id="amount" placeholder="Amount" class="form-control"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <div><br>
                                <button class="btn btn-success" style="float:right;height:100%" id="submitBtn">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                    <br><br>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity-in-Stock</th>
                                <th>Price (per item)</th>
                                <th>Datetime submitted</th>
                                <th>Total Value Number</th>
                            </tr>
                        </thead>
                        <tbody id="body-data">
                        </tbody>
                    </table>
                </div>
            </div>
@endsection
@section('footer_js')
    <script>
        function formatMoney(value){
            value = value+'';
            return '$' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function buildBodyData(res){
            var buildBody = "";
            for(var i = 0; i < res.data.length; i++){
                var newRow = res.data[i];
                buildBody = buildBody + `
                    <tr>
                        <td>`+(i+1)+`.) &nbsp;&nbsp;&nbsp;&nbsp;`+newRow.p_name+`</td>
                        <td>`+newRow.p_qty+`</td>
                        <td>`+formatMoney(newRow.amount)+`</td>
                        <td>`+newRow.created_at+`</td>
                        <td>
                            `+formatMoney(newRow.total_amount)+` &nbsp;&nbsp;
                            <button class="btn btn-warning"  data-toggle="modal" data-target="#editModal`+i+`">
                                EDIT
                            </button>
                            <button class="btn btn-danger" onclick="deleteProduct(`+i+`)">
                                DELETE
                            </button>
                            <div class="modal fade" id="editModal`+i+`" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Editing Product `+(i+1)+`</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row" id="car-desc">
                                                <div class="col-md-4">
                                                    <div>
                                                        <label>PRODUCT NAME</label>
                                                        <input value='`+newRow.p_name+`' id='p_name`+i+`' class="form-control" placeholder="Product Name"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div>
                                                        <label>QUANTITY</label>
                                                        <input type="number" value='`+newRow.p_qty+`' id='p_qty`+i+`' class="form-control" placeholder="Quantity"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div>
                                                        <label>PRICE PER QTY</label>
                                                        <input type="number" value="`+newRow.amount+`" id="amount`+i+`" placeholder="Amount" class="form-control"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                            <a class="btn btn-success" data-dismiss="modal" onclick="editProduct(`+i+`)" style="color:white">Edit Product</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>`;
            }
            return buildBody;
        }

        function loadStart(){
            $.ajax({
                url: "{{url('')}}/ajax-get",
                type: "GET",
                data: "",
                success: function(res){
                    console.log(res);
                    if(res.code == "E00"){
                        $("#suxMsg").text(res.message);

                        var buildBody = "";

                        if(res.data.length > 0){
                            // BUILD BODY DATA
                            buildBody = buildBodyData(res);
                        }else{
                            buildBody = buildBody + `
                                <tr>
                                    <td colspan='6' align="center">NO DATA FOUND</td>
                                </tr>`;
                        }

                        // ADD BODY DATA
                        $("#body-data").html("");
                        $("#body-data").html(buildBody);
                    }
                }
            });
        }
        
        function editProduct(ind){
            $("#editModal"+ind+" .close").click();
            $("#editModal"+ind).modal().hide();
            $("#editModal"+ind).modal('hide');
            $("#editModal"+ind).removeClass('show');

            var p_name = document.getElementById("p_name"+ind).value;
            var p_qty = document.getElementById("p_qty"+ind).value;
            var amount = document.getElementById("amount"+ind).value;

            if(p_name.trim()!="" && p_qty.trim()!="" && amount.trim()!=""){
                $.ajax({
                    url: "{{url('')}}/ajax-edit",
                    type: "GET",
                    data: "p_name="+p_name+"&p_qty="+p_qty+"&amount="+amount+"&index="+ind,
                    success: function(res){
                        console.log(res);
                        if(res.code == "E00"){
                            $("#suxMsg").text(res.message);
                            $("#ajaxSux").show();
                            setTimeout(function(){
                                $("#ajaxSux").fadeOut(1000);
                            }, 5000);

                            var buildBody = "";

                            if(res.data.length > 0){
                                // BUILD BODY DATA
                                buildBody = buildBodyData(res);
                            }else{
                                buildBody = buildBody + `
                                    <tr>
                                        <td colspan='6' align="center">NO DATA FOUND</td>
                                    </tr>`;
                            }

                            // ADD BODY DATA
                            $("#body-data").html("");
                            $("#body-data").html(buildBody);
                        }else{
                            $("#errMsg").text(res.message);
                            $("#ajaxErr").show();
                            setTimeout(function(){
                                $("#ajaxErr").fadeOut(1000);
                            }, 5000);
                        }
                    },
                    error: function(e){
                        console.log(e);
                        $("#errMsg").text("There was an error carrying out operation. Please try again later.");
                        $("#ajaxErr").show();
                        setTimeout(function(){
                            $("#ajaxErr").fadeOut(1000);
                        }, 5000);
                    }
                });
            }else{
                $("#errMsg").text("Please fill in necessary details to proceed");
                $("#ajaxErr").show();
                setTimeout(function(){
                    $("#ajaxErr").fadeOut(1000);
                }, 5000);
            }
        }
        
        function deleteProduct(ind){
            $.ajax({
                url: "{{url('')}}/ajax-delete/"+ind,
                type: "GET",
                data: "",
                success: function(res){
                    console.log(res);
                    if(res.code == "E00"){
                        $("#suxMsg").text(res.message);
                        $("#ajaxSux").show();
                        setTimeout(function(){
                            $("#ajaxSux").fadeOut(1000);
                        }, 5000);

                        var buildBody = "";

                        if(res.data.length > 0){
                            // BUILD BODY DATA
                            buildBody = buildBodyData(res);
                        }else{
                            buildBody = buildBody + `
                                <tr>
                                    <td colspan='6' align="center">NO DATA FOUND</td>
                                </tr>`;
                        }

                        // ADD BODY DATA
                        $("#body-data").html("");
                        $("#body-data").html(buildBody);
                    }else{
                        $("#errMsg").text(res.message);
                        $("#ajaxErr").show();
                        setTimeout(function(){
                            $("#ajaxErr").fadeOut(1000);
                        }, 5000);
                    }
                },
                error: function(e){
                    console.log(e);
                    $("#errMsg").text("There was an error carrying out operation. Please try again later.");
                    $("#ajaxErr").show();
                    setTimeout(function(){
                        $("#ajaxErr").fadeOut(1000);
                    }, 5000);
                }
            });
        }

        $(document).ready(function(){
            $("#submitBtn").click(function(e){
                e.preventDefault();
                var p_name = $("#p_name").val();
                var p_qty = $("#p_qty").val();
                var amount = $("#amount").val();

                if(p_name.trim()!="" && p_qty.trim()!="" && amount.trim()!=""){
                    $.ajax({
                        url: "{{url('')}}/ajax-save",
                        type: "GET",
                        data: "p_name="+p_name+"&p_qty="+p_qty+"&amount="+amount,
                        success: function(res){
                            console.log(res);
                            if(res.code == "E00"){
                                $("#suxMsg").text(res.message);
                                $("#ajaxSux").show();
                                setTimeout(function(){
                                    $("#ajaxSux").fadeOut(1000);
                                }, 5000);

                                var buildBody = "";

                                if(res.data.length > 0){
                                    // BUILD BODY DATA
                                    buildBody = buildBodyData(res);
                                }else{
                                    buildBody = buildBody + `
                                        <tr>
                                            <td colspan='6' align="center">NO DATA FOUND</td>
                                        </tr>`;
                                }

                                // ADD BODY DATA
                                $("#body-data").html("");
                                $("#body-data").html(buildBody);
                            }else{
                                $("#errMsg").text(res.message);
                                $("#ajaxErr").show();
                                setTimeout(function(){
                                    $("#ajaxErr").fadeOut(1000);
                                }, 5000);
                            }
                        },
                        error: function(e){
                            console.log(e);
                            $("#errMsg").text("There was an error carrying out operation. Please try again later.");
                            $("#ajaxErr").show();
                            setTimeout(function(){
                                $("#ajaxErr").fadeOut(1000);
                            }, 5000);
                        }
                    });
                }else{
                    $("#errMsg").text("Please fill in necessary details to proceed");
                    $("#ajaxErr").show();
                    setTimeout(function(){
                        $("#ajaxErr").fadeOut(1000);
                    }, 5000);
                }
            });

            loadStart();
        });
    </script>
@endsection