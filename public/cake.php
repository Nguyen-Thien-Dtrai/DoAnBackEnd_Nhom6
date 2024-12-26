
    <!--================Main Header Area =================-->
    <?php 
    require_once "navbar_header.php";
    
    ?>
    <!--================End Main Header Area =================-->

    <!--================End Main Header Area =================-->
    <section class="banner_area">
        <div class="container">
            <div class="banner_text">
                <h3>Bánh của chúng tôi</h3>
                <ul>
                    <li><a href="index.php">Trang chủ</a></li>
                </ul>
            </div>
        </div>  
    </section>
    <!--================End Main Header Area =================-->

    

    <!--================Blog Main Area =================-->
    <section class="our_cakes_area p_100">
        <div class="container">
            <div class="main_title">
                <h2>Tất cả bánh</h2>
                <h5>Chúng tôi cam kết mang đến cho bạn những chiếc bánh chất lượng cao, được làm mới mỗi ngày từ những nguyên liệu tươi ngon nhất.
                     Với quy trình chế biến tỉ mỉ và sự tận tâm trong từng công đoạn, mỗi chiếc bánh không chỉ thơm ngon mà còn đảm bảo an toàn và giàu dinh dưỡng. 
                     Hãy đến và cảm nhận sự khác biệt từ hương vị tươi mới và đậm đà mà chúng tôi tự hào mang lại!</h5>
            </div>
            <div class="cake_feature_row row">
            <?php
                    $page = 1;
                    if(isset($_GET['page'])==TRUE) {
                        $page = $_GET['page'];
                    }
                    $resultsPerPage = 4;
                    $list_of_products = Product::getAllProducts_andCreatePagination($page, $resultsPerPage);
                    $totalResults = count(Product::getAllProducts());
                    if (isset($_GET['keyword'])) {
                        $list_of_products = Product::searchProduct_andCreatePagination($_GET['keyword'], $page, $resultsPerPage);
                        $totalResults = count(Product::searchProduct($_GET['keyword']));
                    } 
                    if (isset($_GET['manu_id'])) {
                        $list_of_products = Product::getProducts_ByManuIdAndCreatePagination($_GET['manu_id'], $page, $resultsPerPage);
                        $totalResults = count(Product::getProducts_ByManuID($_GET['manu_id']));
                    } 
                    if (isset($_GET['type_id'])) {
                        $list_of_products = Product::getProducts_ByTypeID_andCreatePagination($_GET['type_id'], $page, $resultsPerPage);
                        $totalResults = count(Product::getProducts_ByTypeID($_GET['type_id']));
                    } 

                    // Output:
                  
                    foreach($list_of_products as $key => $value) {
                ?>

                <div class="col-lg-3 col-md-4 col-6">
                    <div class="cake_feature_item">
                        <div class="cake_img">
                            <img src="img/cake-feature/<?php echo $value['pro_image'];?>" alt="" width="270px" height="224px">
                        </div>
                        <div class="cake_text">
                            <h4><?php echo $value['price'];?></h4>
                            <h3><a href="product-details.php?id=<?php echo $value['id']; ?>"><?php echo $value['name']; ?></a></h3>
                            <a class="pest_btn" href="product-details.php?id=<?php echo $value['id'];?>">Chi tiết sản phẩm</a>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
        </div>
        <div style="text-align:center;">
        <?php
        $paginate = Product::paginate("cake.php?", $page, $totalResults, $resultsPerPage, 1);
        if (isset($_GET['keyword'])) {
            $paginate = Product::paginate("cake.php?keyword=" . $_GET['keyword'] . "&", $page, $totalResults, $resultsPerPage, 2);
        }
        if (isset($_GET['manu_id'])) {
            $paginate = Product::paginate("cake.php?manu_id=" . $_GET['manu_id'] . "&", $page, $totalResults, $resultsPerPage, 2);
        }
        if (isset($_GET['type_id'])) {
            $paginate = Product::paginate("cake.php?type_id=" . $_GET['type_id'] . "&", $page, $totalResults, $resultsPerPage, 2);
        }
        echo $paginate;
        ?>
    </div>
    </section>
    <!--================End Blog Main Area =================-->

   

    <?php require_once 'contact.php'?>