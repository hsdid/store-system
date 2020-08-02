<?php 
require 'config.php';

$grand_total = 0;
$allItems = '';
$items = array();

$sql = "SELECT CONCAT(product_name, '(',qty,')') AS ItemQty, total_price FROM cart";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()){

    $grand_total += $row['total_price'];
    $items[] = $row['ItemQty'];

}
$allItems = implode(", ", $items);

?>

<?php
// Turn off all error reporting
error_reporting(0);  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    
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
                <a class="nav-link " href="#">Categories</a>
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
            <div class="cal-lg-6 px-4 pb-4" id="order">
            <h4 class="text-center text-info p-2">Complete your order!</h4>
                <div class="jumbotron p-3 mb-2 text-center">
                    <h6 class="lead"><b>Product(s) : </b><?= $allItems; ?> </h6>
                    <h6 class="lead"><b>Delivery Charge : </b>Free</h6>
                    <h5><b>Amound Payable : </b><?= number_format($grand_total,2) ?>zł</h5>
                </div>
                <form action="" method="post" id="pleaceOrder">
                    <input type="hidden" name="products" value="<?= $allItems; ?>">
                    <input type="hidden" name="grand_total" value="<?= $grand_total; ?>">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Enter name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Enter E-Mail" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" name="phone" class="form-control" placeholder="Enter phone" required>
                    </div>
                    <div class="form-group">
                        <textarea name="addres" class="form-control"  rows="3" cols="10" placeholder="Enter your address here ..."></textarea>
                    </div>
                    <h6 class="text-center lead">Select Payment Mode</h6>
                    <div class="form-group">
                        <select name="pmode" class="form-control">
                            <option value="" selected disabled>Select Payment Mode</option>
                            <option value="cod">Cash On delivery</option>
                            <option value="netbanking">Net Banking</option>
                            <option value="cards">Debit/Credit Card</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" value="Place Order" class="btn btn-danger btn-block">
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
        
            $('input[name ="submit"]').on('click',function (e) {
                
                e.preventDefault();

                var name = $('input[name ="name"]').val();
                var email = $('input[name ="email"]').val();
                var phone = $('input[name ="phone"]').val();
                var addres =$('textarea[name ="addres"]').val();
                var mpayment = $('select[name ="pmode"]').val();

                var products = $('input[name ="products"]').val();
                var topaid = $('input[name ="grand_total"]').val();

                $.ajax({
                    url: 'action.php',
                    method: 'post',
                    data: {name:name, email:email, phone:phone, addres:addres, mpayment:mpayment, products:products, topaid:topaid,action:'&action=order'},
                    success: function(response){
                        $('#order').html(response);
                       
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