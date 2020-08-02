<?php

session_start();


require "config.php";

if(isset($_POST['pid'])){
    $pid = $_POST['pid'];
    $pname = $_POST['pname'];
    $pprice = $_POST['pprice'];
    $pimage = $_POST['pimage'];
    $pcode = $_POST['pcode'];
    $pqty = 1;

    $stmt = $conn->prepare("SELECT product_code FROM cart WHERE product_code=?");
    $stmt->bind_param("s",$pcode);
    $stmt->execute();
    $res = $stmt->get_result();
    $r = $res->fetch_assoc();
    $code = $r['product_code'];

    if (!$code){
        $query = $conn->prepare("INSERT INTO cart (product_name,product_price,product_image,qty,total_price,product_code) VALUES (?,?,?,?,?,?)");

        $query->bind_param("sssiss",$pname,$pprice,$pimage,$pqty,$pprice,$pcode);
        $query->execute();

        echo '<div class="alert alert-success mt-2 alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Item added to your cart!</strong> 
        </div>';
    } 
    else{
        echo '<div class="alert alert-danger mt-2  alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Item already added to your cart!</strong> 
        </div>';
    }
}

if (isset($_GET['cartItem']) && isset($_GET['cartItem']) == 'cart_item'){
    $stmt = $conn->prepare("SELECT * FROM cart");
    $stmt->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows;

    echo $rows;
}

if (isset($_GET['remove'])) {
  $id = $_GET['remove'];

  $stmt = $conn->prepare("DELETE FROM cart WHERE id=?");
  $stmt->bind_param("i",$id);
  $stmt->execute();

  $_SESSION['showAlert'] = 'block';
  $_SESSION['message'] = 'Item removed from the cart!';

  header('location:cart.php');
  
}
if (isset($_GET['clear'])){
  $stmt = $conn->prepare("DELETE FROM cart");
  $stmt->execute();
  $_SESSION['showAlert'] = 'block';
  $_SESSION['message'] = 'All Item removed from the cart!';
  header('location:cart.php');
  
}

if (isset($_POST['qty'])) {
  
  $qty = $_POST['qty'];
  $pid = $_POST['pid'];
  $pprice = $_POST['pprice'];
  
  $tprice = $qty*$pprice;

  

  $stmt = $conn->prepare("UPDATE cart SET qty=?, total_price=? WHERE id=?");
  $stmt->bind_param("isi", $qty, $tprice, $pid);
  $stmt->execute();
  
}

if (isset($_POST['action']) && isset($_POST['action']) == 'order') {
 
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $addres = $_POST['addres'];
  $mpayment = $_POST['mpayment'];
  $products = $_POST['products'];
  $topaid = $_POST['topaid'];

  $data = '';

  $stmt = $conn->prepare("INSERT INTO orders (pname,email,phone,adres,pmode,products,amount_paid)VALUES  (?,?,?,?,?,?,?)");
  $stmt->bind_param("sssssss",$name,$email,$phone,$addres,$mpayment,$products,$topaid);
  $stmt->execute();


  $data = '<div class="text-center">
              <h1 class="display-4 mt-2 text-danger">Thank you</h1>
              <h2 class="text-success">Your order placed successfully</h2>
              <h4 class="bg-danger text-light rounded p-2">Item Purchased : '.$products.'</h4>
              <h4>Your Name: ' .$name. '</h4>
              <h4>Your email: ' .$email. '</h4>
              <h4>Your Phone: ' .$phone. '</h4>
              <h4>Your Total Amount Paid: ' .number_format($topaid,2).'zł</h4>
              <h4>Your Payment Mode: ' .$mpayment. '</h4>
              <h4>Your Delivery Address: ' .$addres. '</h4>
           </div>
            ';
          echo $data;  

    
}
///DASHBOAD PANEL 

//if (isset($_POST['action']) && isset($_POST['action']) == 'admin_login') {
if(isset($_POST['login'])){

  $_SESSION['show'] = false;
  $_SESSION['add'] = false;


  $_SESSION['login'] = false;
  $_SESSION['logged'] = false;

  $login = $_POST['login'];
  $pass = $_POST['pass'];
  
  $login = htmlentities($login, ENT_QUOTES, "UTF-8");
  $pass = htmlentities($pass, ENT_QUOTES, "UTF-8");

  //password_verify('rasmuslerdorf', $hash)

  $stmt = $conn->prepare("SELECT * FROM logadmin WHERE login=?");
  $stmt->bind_param("s",$login);
  $stmt->execute();
  $res = $stmt->get_result();
  $r = $res->fetch_assoc();
  

  if(password_verify($pass,$r['pass'])){
    
    //header('location:dashboard.php');
    $_SESSION['logged'] = true;
    echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
  }
  else {
    echo '<div class="alert alert-danger mt-2 alert-dismissible">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>Wrong password or login!</strong> 
          </div>';
    }
  
}


//deleting items in dashboard
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];

  $stmt = $conn->prepare("DELETE FROM product WHERE id=?");
  $stmt->bind_param("i",$id);
  $stmt->execute();

  $_SESSION['showAlert'] = 'block';
  $_SESSION['message'] = 'Item removed from the cart!';

  header('location:dashboard.php');

}

//show/hide products in dashboard 
if (isset($_POST['show'])) {
  
    $_SESSION['show'] ^= true;
    

}
if (isset($_POST['add'])) {
  
  $_SESSION['add'] ^= true;
  

}

if (isset($_POST['close'])) {
  
  $_SESSION['add'] = false;
  

}
if (isset($_POST['addSubmit'])) {

  $_SESSION['add'] = false;
  
  $pname = $_POST['pname'];
  $pprice = $_POST['pprice'];
  $pimage = $_POST['pimage'];
  $pcode = $_POST['pcode'];

  $stmt = $conn->prepare("INSERT INTO product (product_name, product_price, product_image, product_code) VALUES (?,?,?,?)");
  $stmt->bind_param('ssss',$pname, $pprice, $pimage, $pcode);
  if($stmt->execute()) {
    echo '<div class="alert alert-success mt-2 alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Product added to store!</strong> 
    </div>';

  } else {
    echo $stmt->error;
  }

}

if (isset($_POST['logout'])) {
  

  //session_unset();
  $_SESSION['show'] = false;
  $_SESSION['add'] = false;
  $_SESSION['logged'] = false;
  
  echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
  
}


$conn->close();