<!--================Main Header Area =================-->
<?php
session_start();
require_once "navbar_header.php";
$productModel = new Product();
// Lấy danh sách sản phẩm vừa xem
$recentProducts = []; // Khởi tạo mảng trống
if (isset($_COOKIE['recentView'])) {
    $recentProducts = json_decode($_COOKIE['recentView'], true);
    //var_dump($recentView); // In mảng recentView để kiểm tra
}

?>
<!--================End Main Header Area =================-->

<!--================End Main Header Area =================-->
<section class="banner_area">
    <div class="container">
        <div class="banner_text">
            <h3>Cart</h3>
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
                <li><a href="cart.php">Giỏ hàng</a></li>
            </ul>

        </div>
    </div>
</section>

<div class="card" style="width: 18rem;">
    <div class="card-body">
        <h5 class="card-title">Sản phẩm vừa xem</h5>
        <ul>
            <?php
            if (!is_null($recentProducts)) {
                foreach ($recentProducts as $orderid => $prodID) {
                    if(!is_null($prodID)){
                    ?>
                    <li>
                        <?php
                            // Hiển thị thông tin sản phẩm, ví dụ:
                            echo '<p>' . Product::getProduct_ByID($prodID)['name'] . '</p>';
                        ?>
                    </li>
                    <?php
                    }
                }
            }
            ?>
        </ul>
    </div>
</div>
<!--================End Main Header Area =================-->

<!--================Cart Table Area =================-->
<section class="cart_table_area p_100">
    <?php
    if (isset($_GET['confirm'])) {
        $confirm = $_GET['confirm'];
        if ($confirm == "pay") {

            echo "<script type='text/javascript'>alert('Thanh toán thành công !');</script>";

        } else {
            echo "<script type='text/javascript'>alert('Xóa giỏ hàng thành công !');</script>";
        }
    }
    if (isset($_SESSION['isLogin']['User'])) {
        $totalPrice = 0;
        $idUserLogin = $_SESSION['isLogin']['User'];
        $idOrder = Order::getOrder_ByCustomerId($idUserLogin);
        $orderDetail = OrderDetail::getOrder_ByOrderId($idOrder);

        ?>
        <div class="container">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Đánh giá</th>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Tổng</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="table-cart">
                        <?php
                        if (count($orderDetail) != 0) {
                            foreach ($orderDetail as $item) {
                                $product = Product::getProduct_ByID($item['productid']);
                                if ($product['receipt'] < $item['quantity']) {
                                    ?>
                                    <tr style="background: #ef5353;">
                                        <td class="product-thumbnail">
                                            <a href="product-details.php?id=<?php echo $product['id']; ?>"><img
                                                    style="width:100%;height:auto;" alt="poster_1_up" class="shop_thumbnail"
                                                    src="img/cake-feature/<?php echo $product['pro_image']; ?>"></a>
                                        </td>
                                        <td class="product-name">
                                            <a href="product-details.php?id=<?php echo $product['id']; ?>">
                                                <?php echo $product['name']; ?>
                                            </a>
                                        </td>
                                        <td class="product-price">
                                            <span class="amount">
                                                <?php echo number_format($product['price']); ?>
                                                đ
                                            </span>
                                        </td>
                                        <td class="product-quantity text-center">
                                            <div class="quantity buttons_added">
                                                <a href="add-cart.php?id=m<?= $item['productid'] ?>" class="btn btn-outline-info"
                                                    style="float: left; display: none">-</a>
                                                <span class="product-quantity">
                                                    <?php $totalPrice += $item['price'];
                                                    echo $item['quantity'] ?>
                                                </span>
                                                <a href="add-cart.php?id=p<?= $item['productid'] ?>" class="btn btn-outline-info"
                                                    style="float: right; display: none">+</a>
                                            </div>
                                        </td>
                                        <td class="product-subtotal">
                                            <span class="amount">
                                                <?php echo $item['price'] ?> VND
                                            </span>
                                        </td>
                                        <td class="product-remove">
                                            <a title="Remove this item" class="remove"
                                                href="add-cart.php?id=r<?php echo $item['productid']; ?>">X</a>
                                        </td>
                                    </tr>
                                <?php } else { ?>
                                    <tr>
                                        <td class="product-thumbnail">
                                            <a href="product-details.php?id=<?php echo $product['id']; ?>"><img
                                                    style="width:100%;height:auto;" alt="poster_1_up" class="shop_thumbnail"
                                                    src="img/cake-feature/<?php echo $product['pro_image']; ?>"></a>
                                        </td>
                                        <td class="product-name">
                                            <a href="product-details.php?id=<?php echo $product['id']; ?>">
                                                <?php echo $product['name']; ?>
                                            </a>
                                        </td>
                                        <td class="product-price">
                                            <span class="amount">
                                                <?php echo number_format($product['price']); ?>
                                                đ
                                            </span>
                                        </td>
                                        <td class="product-quantity text-center">
                                            <div class="quantity buttons_added">
                                                <a href="add-cart.php?id=m<?= $item['productid'] ?>" class="btn btn-outline-info"
                                                    style="float: left">-</a>
                                                <span class="product-quantity">
                                                    <?php $totalPrice += $item['price'];
                                                    echo $item['quantity'] ?>
                                                </span>
                                                <a href="add-cart.php?id=p<?= $item['productid'] ?>" class="btn btn-outline-info"
                                                    style="float: right">+</a>
                                            </div>
                                        </td>
                                        <td class="product-subtotal">
                                            <span class="amount">
                                                <?php echo $item['price'] ?> VND
                                            </span>
                                        </td>
                                        <td class="product-remove">
                                            <a title="Remove this item" class="remove"
                                                href="add-cart.php?id=r<?php echo $item['productid']; ?>">X</a>
                                        </td>
                                    </tr>


                                    <?php
                                }
                            }
                        } else {
                            echo "<h2 style='text-align: center;'><i>
                                <a href='./cake.php'>SHOPPING NOW !!!</a>
                                </i></h2>";
                        }
                        ?>

                    </tbody>
                </table>
            </div>
            <div class="row cart_total_inner">
                <div class="col-lg-7"></div>
                <div class="col-lg-5">
                    <div class="cart_total_text">
                        <div class="cart_head">
                            Cart Total
                        </div>
                        <div class="total">
                            <h4>Total <strong><span class="amount">
                                        <?= number_format($totalPrice);
                                        ?>
                                        VND
                                    </span></strong></h4>
                        </div>
                        <div class="cart_footer">
                            <a class="pest_btn"
                                href="removeall.php?id=p<?php echo Order::getOrder_ByCustomerId($_SESSION['isLogin']['User'])[0]['id']; ?>">Payment</a>
                            <a class="pest_btn" href="./cake.php">Shopping</a>
                            <a class="pest_btn"
                                href="removeall.php?id=r<?php echo Order::getOrder_ByCustomerId($_SESSION['isLogin']['User'])[0]['id']; ?>">Remove
                                All</a>
                        </div>

                    </div>
                </div>
            </div>
        <?php } else {
        echo "<h2 style='text-align: center;'><i>
                  <a href='./login/login.php'>Pls Login First !!!</a>
                  </i></h2>";
    } ?>
    </div>
</section>
<!--================End Cart Table Area =================-->

<?php require_once 'contact.php' ?>