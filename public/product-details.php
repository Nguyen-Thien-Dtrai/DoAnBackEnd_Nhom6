<?php
session_start();   
 // Tạo mảng recentView lưu vào cookie
 $recentView = [];
 if (isset($_COOKIE['recentView'])) {
    $id = $_GET['id'];
     $recentView = json_decode($_COOKIE['recentView']);
     if (!in_array($id, $recentView, true)) {
         if (count($recentView) == 5) {
             array_shift($recentView);
         }
         array_push($recentView, $id);
     }
 }
 else {
     array_push($recentView, $id);
 }
 print_r($recentView);
 setcookie('recentView', json_encode($recentView), time() + 3600*24);

 
if (!isset($_SESSION['isLogin']['User'])) {
    header('location:./login/login.php');
}
if (!isset($_GET['id'])) {
    header('location:' . $_SERVER['HTTP_REFERER']);
}

require_once "navbar_header.php";

?>
<!--================End Main Header Area =================-->

<!--================End Main Header Area =================-->
<section class="banner_area">
    <div class="container">
        <div class="banner_text">
            <h3>Chi tiết sản phẩm</h3>
            <ul>
                <li><a href="index.html">Trang chủ</a></li>
                <li><a href="product-details.html">Chi tiết sản phẩm</a></li>
            </ul>
        </div>
    </div>
</section>
<!--================End Main Header Area =================-->

<!--================Product Details Area =================-->
<section class="product_details_area p_100">
    <?php
    $product_detail = Product::getProduct_ByID($_GET['id']);
    $type = Protype::getTypeName($product_detail['type_id']);
    // $manufacturer = Manufacturer::getBrand($product_detail['manu_id']);
    ?>
    <div class="container">
        <div class="row product_d_price">

            <div class="col-lg-6">
                <div class="product_img"><img class="img-fluid" src="img/cake-feature/<?php echo $product_detail['pro_image']; ?>" alt="" style="width: 100%; height: auto;"></div>
            </div>

            <div class="col-lg-6">
                <div class="product_details_text">
                    <h4><?php echo $product_detail['name']; ?></h4>
                    <p> <?php echo $product_detail['description']; ?></p>
                    <h5>Giá : <?php echo number_format($product_detail['price']); ?> VND</h5>
                    <form action="add-cart.php" class="cart" method="get">
                        <div class="quantity_box" style="display:inline-block;">
                            <label for="quantity">Số lượng :</label>
                            <input type="number" size="4" class="input-text qty text" title="Qty" value="1" name="quantity" min="1" step="1">
                            <input type="text" name="id" value="<?php echo $_GET['id']; ?>" readonly style="display:none;">
                            <br>
                            <button type="submit" class="pest_btn mt-3" style="border: none;">Thêm vào giỏ hàng</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Reviews: -->
    <?php
    $idUser = $_SESSION['isLogin']['User'];
    $reviewPage = 1;
    $reviewsPerPage = 3;
    $totalReviews = count(Review::getReviews_ByProID($_GET['id']));
    if (isset($_GET['page']) == TRUE) {
        $reviewPage = $_GET['page'];
    }
    $list_of_reviews = Review::getReviews_ByProID_andCreatePagination($_GET['id'], $reviewPage, $reviewsPerPage);
    ?>
    <div class="container">
        <div class="product_tab_area" role="tabpanel">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">REVIEWS (<?php echo $totalReviews; ?>)</a>
                    <a class="nav-item nav-link active" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="true">ADD REVIEW</a>
                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="reviews">
                        <div class="review">
                            <div class="container pt-2 text-dark">
                                <?php
                                foreach ($list_of_reviews as $key => $value) {
                                ?>
                                    <h5 style="color: #797979;">Tên: <?= $value['reviewer_name'] ?></h5>
                                    <p><?= $value['content'] ?></p>
                                    <span>
                                        <p>
                                            Laters:
                                            <?php $time = strtotime($value['created_at']);
                                            echo $mysqldate = date('F j, Y g:i a', $time); ?>
                                        </p>
                                    </span>
                                    <hr>
                                <?php
                                }
                                ?>
                            </div>

                        </div>
                        <div style="text-align:center;">
                            <?php echo Review::paginate("product-details.php?id=" . $_GET['id'] . "&", $reviewPage, $totalReviews, $reviewsPerPage, 1); ?>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade show active" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <h2>Đánh giá</h2>
                    <form action="insert_review.php" method="POST">
                        <div class="submit-review">
                            <input type="text" name="product_id" value="<?php echo $_GET['id']; ?>" readonly style="display:none;">
                            <label for="product_id">Tên</label>
                            <br>
                            <input name="reviewer_name" type="text" value=<?= User::getUserName($idUser)['username'] ?> size="30" readonly>
                            <br>
                            <label for="reviewer_email">Email</label>
                            <br>
                            <input name="reviewer_email" type="email" placeholder="ex: <?= User::getUserName($idUser)['username'] ?>@gmail.com" size="30">
                            <br>
                            <label for="content">Đánh giá của bạn</label>
                            <br>
                            <textarea name="content" id="" cols="31" rows="5" required placeholder="..."></textarea>
                            <br>
                            <input type="submit" value="Gửi" class="pest_btn mt-2" style="border: none;">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>

<!--================End Product Details Area =================-->


<?php require_once 'contact.php' ?>