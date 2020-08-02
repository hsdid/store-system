<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <style>
        #overlay{
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.6);
        }

    </style>
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
                <!-- <li class="nav-item">
                <a class="nav-link " href="checkout.php" disable>Checkout</a>
                </li> -->
                <li class="nav-item " >
                    <a class="nav-link " href="cart.php"><i class="fa fa-shopping-cart"></i><span id="cart-item" class="badge badge-danger"></span></a>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="mesage"></div>
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr><h4 class="text-center text-info mb-4">Admin dashboard</h4> </tr>
                        <tr>
                            <td  colspan=6>
                                <button id="addBtn" class="btn btn-success">Add new product</button>
                                <button id="showBtn" class="btn btn-success" >Show/Hide all products</button>
                                <button id="editBtn" class="btn btn-success" >Edit Product</button>
                                <button id="deleteBtn" class="btn btn-success">Delete product</button>
                                <button id="logout" class="btn btn-danger">Log out</button>
                            </td>
                        </tr>
                        <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Product code</th>
                                <th>Delete</th>
                                <!-- <th>Quantity</th> -->
                                <!-- <th>Total Price</th> -->
                                <!-- <th>
                                    <a href="action.php?clear=all" class="badge-danger badge p-1" onclick="return confirm('Are you sure want to clear your cart ?')"><i class="fa fa-trash"></i>&nbsp;&nbsp; Clear card</a>
                                </th> -->
                            </tr>

                    </thead>
                    <tbody>
                        <?php 
                          
                          if($_SESSION['show']) {
                            require 'config.php';
                            $stmt = $conn->prepare("SELECT * FROM product");
                            $stmt->execute();
                            $result = $stmt->get_result();
                            

                            while($row = $result->fetch_assoc()):
                            
                        ?>
                        <tr>
                            <td><?= $row['id'] ?> </td>
                            <td><img src="<?= $row['product_image'] ?>" width="50"> </td>
                            <td><?= $row['product_name'] ?></td>
                            <td><?= $row['product_price'] ?></td>
                            <td><?= $row['product_code'] ?></td>
                            <td>
                                    <a href="action.php?delete=<?= $row['id'] ?>" class="text-danger lead" onclick="return confirm('Are you sure want to remove this item ?')"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endwhile;  
                          }
                        ?>
                    </tbody>
                </table>
                <!--Adding new products -->
                <?php if($_SESSION['add']) {
                    
                ?>
                <div id="overlay" v-if="showAddModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add new product</h5>
                                <button type="button" class="close" >
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body p-4">
                                <form action="#" method="post">
                                    <div class="form-group">
                                        <input type="text" name="pname" class="form-control form-control-lg" placeholder="Product name" >
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="pprice" class="form-control form-control-lg" placeholder="Product price" >
                                    </div>
                                    <div class="form-group">
                                        <input type="tel" name="pimage" class="form-control form-control-lg" placeholder="Image" >
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="pcode" class="form-control form-control-lg" placeholder="Product code" >
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-info btn-block btn-lg" id="addSubmit">Add Product</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>
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
           
           ///show/hide products 
            $('#showBtn').on('click',function(e){
                e.preventDefault();
                var show = true;
                $.ajax({
                    url: 'action.php',
                    method: 'post',
                    data: {show:show},
                    success:function(response){
                        //$('.mesage').html(response);
                        location.reload()
                        //console.log(response);
                    }
                });
            });
            //show add model
            $('#addBtn').on('click',function(e){
                e.preventDefault();
                var add = true;
                $.ajax({
                    url: 'action.php',
                    method: 'post',
                    data: {add:add},
                    success:function(response){
                        //$('.mesage').html(response);
                        location.reload()
                        //console.log(response);
                    }
                });
            });
            //close add model
            $('.close').on('click',function(e){
                e.preventDefault();
                var close = true;
                $.ajax({
                    url: 'action.php',
                    method: 'post',
                    data: {close:close},
                    success:function(response){
                        //$('.mesage').html(response);
                        location.reload()
                        //console.log(response);
                    }
                });
            });

            
            /// send data to db 
            $('#addSubmit').on('click',function(e){
                e.preventDefault();
               
                var addSubmit = true;
                var pname = $('input[name ="pname"]').val();
                var pprice = $('input[name ="pprice"]').val();
                var pimage = $('input[name ="pimage"]').val();
                var pcode = $('input[name ="pcode"]').val();

                
                $.ajax({
                    url: 'action.php',
                    method: 'post',
                    data: {addSubmit:addSubmit, pname:pname, pprice:pprice, pimage:pimage, pcode:pcode},
                    success:function(response){
                        $('.mesage').html(response);
                        location.reload();
                        //console.log(response);
                    }
                });
            });
            /// logout from admin panel
            $('#logout').on('click',function(e){
                e.preventDefault();
                var logout = true;
                $.ajax({
                    url: 'action.php',
                    method: 'post',
                    data: {logout:logout},
                    success:function(response){
                        $('.mesage').html(response);
                        
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