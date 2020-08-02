<?php
require 'config.php';
session_start();
if ($_SESSION['logged']) {
    header('location:dashboard.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    
</head>
<body>
    <div class="container-fluid">
        <div class="row navbar navbar-expand-sm bg-dark navbar-dark ">
            <ul class="nav nav-pills">
                <li class="nav-item">
                <a class="nav-link active" href="index.php"><i class="fa fa-mobile "></i>&nbsp;&nbsp;Moblile Store</a>
            </ul>
            <ul class="nav nav-pills ml-auto ">
                </li>
                <li class="nav-item ">
                <a class="nav-link " href="index.php">Products</a>
                </li>
                <li class="nav-item">
                <a class="nav-link " href="admin.php">admin</a>
                </li>
                <li class="nav-item">
                <a class="nav-link " href="checkout.php">Checkout</a>
                </li>
                <li class="nav-item " >
                    <a class="nav-link active" href="cart.php"><i class="fa fa-shopping-cart"></i><span id="cart-item" class="badge badge-danger"></span></a>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="cal-lg-6 px-4 pb-4 mt-5" id="order">
            <div id="mesagge"></div>
            <h2 class="text-center text-info p-2 ">Log in</h4>
                
                <form action="" method="post" id="pleaceOrder">
                    
                    <div class="form-group">
                        <input type="login" name="login" class="form-control" placeholder="Enter login" required style = "min-width:300px;" >
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Enter password" required style = "min-width:300px;">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="Log_in" value="Log in" class="btn btn-danger btn-block">
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            
            $('input[name ="Log_in"]').on('click', function (e) {
                e.preventDefault();
                var login = $('input[name="login"]').val();
                var pass = $('input[name="password"]').val();
                
                $.ajax({
                    url: 'action.php',
                    method: 'post',
                    data: {login:login, pass:pass},
                    success:function(response){
                        //console.log(response);
                        $('#mesagge').html(response)  
                    }
                });
            });
            
            load_cart_item_number();

            function load_cart_item_number(){
                $.ajax({
                    url: 'action.php',
                    method: 'get',
                    data: {cartItem:"cart_item"},
                    success:function(response){
                        $("#cart-item").html(response);

                    }
                })
            }
        });
    </script>

</body>
</html>