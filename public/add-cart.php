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

if (isset($_SESSION['isLogin']['User'])) {
    $userLogin = $_SESSION['isLogin']['User'];
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $orderId = Order::getOrder_ByCustomerId($id);
        $product = Product::getProduct_ByID($id);
        if ($id[0] == 'r' || $id[0] == 'p' || $id[0] == 'm') {
            $newId = substr($id, 1, strlen($id));
            $product1 = Product::getProduct_ByID($newId);
            switch ($id[0]) {
                case 'r':
                    $getOrder_ByOrderId = OrderDetail::getOrder_ByOrderId($orderId);
                    foreach ($getOrder_ByOrderId as $value) {
                        if ($value['productid'] == $newId) {
                            $removeProduct_ById =  OrderDetail::removeProduct_ById($orderId, $newId);
                        }
                    }
                    break;
                case 'm':
                    $getOrder_ByProductId = OrderDetail::getOrder_Product($newId, $orderId);
                    $qty = $getOrder_ByProductId[0]['quantity'];
                    if ($qty == 1) {
                        $removeProduct_ById =  OrderDetail::removeProduct_ById($orderId, $newId);
                    } else {
                        $oldQuantity = $getOrder_ByProductId[0]['quantity'];
                        $price = $product1['price'];
                        $newTolalPrice = ($oldQuantity - 1) * $price;
                        $UpdateOrder = OrderDetail::updateCart($orderId, $newId, ($oldQuantity - 1), $newTolalPrice);
                    }
                    break;
                    case 'p':  
                        // Lấy thông tin sản phẩm từ giỏ hàng  
                        $getOrder_Product = OrderDetail::getOrder_Product($newId, $orderId);  
                    
                        // Kiểm tra xem sản phẩm có tồn tại trong giỏ hàng hay không  
                        if (!empty($getOrder_Product)) {  
                            $oldQuantity = $getOrder_Product[0]['quantity']; // Lấy số lượng cũ  
                            $price = $product1['price']; // Lấy giá sản phẩm  
                    
                            // Tính toán số lượng mới và giá tổng mới  
                            $newQuantity = $oldQuantity + 1; // Tăng số lượng lên 1  
                            $newTotalPrice = $newQuantity * $price; // Tính toán giá tổng mới  
                    
                            // Cập nhật giỏ hàng với số lượng và giá mới  
                            $UpdateOrder = OrderDetail::updateCart($orderId, $newId, $newQuantity, $newTotalPrice);  
                        } else {  
                            // Xử lý trường hợp sản phẩm không có trong giỏ hàng (nếu cần thiết)  
                            $newQuantity = 1; // Thêm sản phẩm mới với số lượng 1  
                            $newTotalPrice = $product1['price']; // Giá cho sản phẩm mới  
                    
                            // Gọi hàm thêm sản phẩm mới vào giỏ hàng  
                            $newOrder = OrderDetail::insertOrder($orderId, $newId, $newQuantity, $newTotalPrice);  
                        }  
                        break;
                default:
                    break;
            }
            header('location:./cart.php');
        } else {
            $number_Quantity = 1;
            if (isset($_GET['quantity'])) {
                $number_Quantity = $_GET['quantity'];
            }
            $getOrder_Product = OrderDetail::getOrder_Product($id, $orderId);
            // var_dump($getOrder_Product);
            if (count($getOrder_Product) == 0) {
                $totalPrice = $number_Quantity * $product['price'];
                $newOrder = OrderDetail::insertOrder($orderId, $id, $number_Quantity, $totalPrice);
                 echo "1";
                  // Hiển thị thông báo nếu không có sản phẩm nào trong giỏ hàng
                  if ($newOrder) {
                    $_SESSION['paymentNotification'] = "Vui lòng thêm hàng vào giỏ hàng trước khi thanh toán!";
                    header('location:' . $_SERVER['HTTP_REFERER']);
                    exit();
                }
                
            } else
             {
                $oldPrice = $getOrder_Product[0]['price'];
                $oldQuantity = $getOrder_Product[0]['quantity'];
                $totalPrice = $number_Quantity * $product['price'];
                $newTolalPrice = $oldPrice + $totalPrice;
                $newQuantity = $oldQuantity + $number_Quantity;
                $UpdateOrder = OrderDetail::updateCart($orderId, $id, $newQuantity, $newTolalPrice);
            // var_dump($UpdateOrder);

                echo "2";
            }
            
            header('location:' . $_SERVER['HTTP_REFERER']);
        }
        

    } else {
        $removeAll = OrderDetail::removeAll();
        header('location:' . $_SERVER['HTTP_REFERER']);
    }
} else {
    header('location:../public/login/login.php');
}
