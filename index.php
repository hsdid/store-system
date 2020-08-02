<?php
// Turn off all error reporting
error_reporting(0);  
$_SESSION['logged'] = false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoping Cart System</title>
    
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
                <a class="nav-link disabled" href="checkout.php" >Checkout</a>
                </li>
                <li class="nav-item " >
                    <a class="nav-link active" href="cart.php"><i class="fa fa-shopping-cart"></i><span id="cart-item" class="badge badge-danger"></span></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="container">
    <div id="mesagge"></div>    
    <div class="row mt-2 pb-3">
            <?php 
                include 'config.php';
                $stmt = $conn->prepare("SELECT * FROM product");
                $stmt->execute();
                $result = $stmt->get_result();

                while($row = $result->fetch_assoc()):
            ?>
            <div class="col-6 col-lg-3 col-md-4 col-sm-6 mb-2 mt-4">
                <div class="card-deck">
                    <div class="card p-2 border-secondary mb-2">
                        <img src="<?= $row['product_image'] ?>" class="card-img-top" height="250">
                        <div class="card-body ">
                            <h5 class="card-title text-center text-info"> 
                            <?= $row['product_name'] ?>
                            </h5>
                            <h5 class="card-text text-center text-danger"><?=number_format($row['product_price'],2)?>zł</h5>
                        </div>
                        <div class="card-footer p-1">
                            <form action="" class="form-submit">
                                <input type="hidden" class="pid" value="<?=$row['id'] ?>">
                                <input type="hidden" class="pname" value="<?=$row['product_name'] ?>">
                                <input type="hidden" class="pprice" value="<?=$row['product_price'] ?>">
                                <input type="hidden" class="pimage" value="<?=$row['product_image'] ?>">
                                <input type="hidden" class="pcode" value="<?=$row['product_code'] ?>">
                                <button class="btn btn-info btn-block btn-lg addItemBtn"><i class="fa fa-cart-plus"></i> Add to cart</button>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
                <?php endwhile; ?>
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
            $(".addItemBtn").click(function(e){
                
               
                e.preventDefault();
                var $form = $(this).closest(".form-submit");
                var pid = $form.find(".pid").val();
                var pname = $form.find(".pname").val();
                var pprice = $form.find(".pprice").val();
                var pimage = $form.find(".pimage").val();
                var pcode = $form.find(".pcode").val();

                //console.log(pid);
                $.ajax({
                    
                    url: 'action.php',
                    method: 'post',
                    
                    data: {pid:pid, pname:pname, pprice:pprice,pimage:pimage,pcode:pcode},
                    
                    success:function(response){
                        $("#mesagge").html(response);
                        window.scrollTo(0,0);
                        load_cart_item_number();
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