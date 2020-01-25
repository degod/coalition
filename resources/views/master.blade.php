<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="DeGod">

        <title>Coalition Test</title>

        <!-- Custom fonts for this template-->
        <link href="{{asset('assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
        
        <!-- Page level plugin CSS-->
        <link href="{{asset('assets/vendor/datatables/dataTables.bootstrap4.css')}}" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="{{asset('assets/css/sb-admin.css')}}" rel="stylesheet">

        <!-- Bootstrap datepicker css -->
        <link href="{{asset('assets/css/datepicker.css')}}" rel="stylesheet">

        <!-- Custom font for this project -->
        <link href="https://fonts.googleapis.com/css?family=Quicksand:500" rel="stylesheet">
        <style>
            /* @font-face {
                font-family: FuturaB;
                src: url({{asset('assets/fonts/unicode.futurab.ttf')}});
            } */
            html, body{
                /* font-family: FuturaB !important; */
                font-family: 'Quicksand', sans-serif;
            }
            /* Custom font for this project */

            #footer-id{
                margin: 0 !important;
                padding: 0 !important;
            }
            footer{
                min-height: 500px;
                background-color: #212339;
                color: white;
                font-size: 16px;
                margin-bottom: -20px !important;
            }
            footer div h2{
                padding-top: 10px;
                font-size: 30px;
                text-align: center;
            }
            footer div p{
                padding-top: 15px;
                font-size: 15px;
                text-align: center;
            }
            .btn.special{
                margin: 0px 14px 0px 14px;
                width:350px;
                border-radius: 50px;
                padding: 12px;
                border: 1px solid #ccc;
            }
            .btn.special.btn-primary{
                border: none;
            }
        </style>
    </head>

    <body id="page-top">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    Some required fields are missing
                </ul>
            </div>  
        @endif
        @if(\Session::has('error'))
            <div class="alert alert-danger">
                <ul>
                    {{\Session::get('error')}}
                </ul>
            </div>  
        @endif
        @if(\Session::has('message'))
            <div class="alert alert-success">
                <ul>
                    {{\Session::get('message')}}
                </ul>
            </div>	
        @endif
        <div id="wrapper" style="min-height:70vh">
            @yield('body_content')
            <!-- /.content-wrapper -->
        </div>
        <!-- /#wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Bootstrap core JavaScript-->
        <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

        <!-- Core plugin JavaScript-->
        <script src="{{asset('assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

        <!-- Page level plugin JavaScript-->
        <script src="{{asset('assets/vendor/datatables/dataTables.bootstrap4.js')}}"></script>
        <script src="{{asset('assets/vendor/datatables/jquery.dataTables.js')}}"></script>
        <script src="{{asset('assets/vendor/datatables/dataTables.bootstrap4.js')}}"></script>

        <!-- Datepicker plugin JavaScript-->
        <script src="{{asset('assets/vendor/bootstrap/js/bootstrap-datepicker.js')}}"></script>
        <!-- Demo scripts for this page-->
        <script src="{{asset('assets/js/demo/datatables-demo.js')}}"></script>
        <script src="{{asset('assets/js/demo/chart-area-demo.js')}}"></script>

        @yield('footer_js')
    </body>
</html>
