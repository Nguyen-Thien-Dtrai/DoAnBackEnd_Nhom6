<?php
session_start();
require_once "config.php";
require_once "./models/db.php";
require_once "./models/product.php";
require_once "./models/protype.php";
require_once "./models/manufacturer.php";
require_once "./models/review.php";
require_once "./models/order.php";
require_once "./models/orderdetail.php";
require_once "./models/user.php";
$product = new Product;
$manufacturer = new Manufacturer;
$protype = new Protype;
$review = new Review;
$order = new Order;
$orderDetail = new OrderDetail;
$user = new User;

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $newId = substr($id, 1, strlen($id));
    OrderDetail::removeAll_ByOrderId($newId);
    if($id[0] == 'p'){
        header("location: cart.php?confirm=pay");
    }else{
        header("location: cart.php?confirm=remove");
    }
}
?>