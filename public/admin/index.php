<?php
require_once 'header.php' ?>
<!-- BEGIN CONTENT -->
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom current"><i class="icon-home"></i> Trang chính</a></div>
        <h1>Danh sách sản phẩm</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <!--start-top-serch-->
        <div id="searchProduct" style="float: left;">
            <form action="#" method="get">
                <input type="text" name="keyword" placeholder="Nhập để tìm...">
                <input type="submit" name="submit" value="Search" class="btn btn-success">
            </form>
        </div>
        <!--close-top-serch-->
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"><a href="./form.php?functionType=products"> <i class="icon-plus"></i>
                            </a></span>
                        <h5>Sản phẩm</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Tên</th>
                                    <th>Mẫu Sản Phẩm</th>
                                    <th>Loại sản phẩm</th>
                                    <th>Mô tả</th>
                                    <th>Giá (VND)</th>
                                    <th>Nổi Bật</th>
                                    <th>Receipt</th>
                                    <th>Tạo lúc</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $page = 1;
                                $resultsPerPage = 5;
                                // $totalLinks = ceil($totalResults/$resultsPerPage);
                                if (isset($_GET['page']) == TRUE) {
                                    $page = $_GET['page'];
                                }
                                $list_of_products = Product::getAllProducts_andCreatePagination($page, $resultsPerPage);
                                $totalResults = count(Product::getAllProducts());
                                if (isset($_GET['keyword'])) {
                                    $keyWord = $_GET['keyword'];
                                    if ($keyWord != ' ') {
                                        $list_of_products = Product::searchProduct_andCreatePagination($_GET['keyword'], $page, $resultsPerPage);
                                        $totalResults = count(Product::searchProduct($_GET['keyword']));
                                    }
                                }
                                // Output:
                                echo "<p style=\"text-align:center;\"><b>Tìm thấy $totalResults kết quả.</b></p>";
                                foreach ($list_of_products as $key => $value) {
                                ?>
                                    <tr class="">
                                        <td width=250>
                                            <img src="../img/cake-feature/<?= $value['pro_image']; ?>" alt="">
                                        </td>
                                        <td>
                                            <h5><?php echo $value['name']; ?></h5>
                                        </td>
                                        <td>
                                            <h5><?php echo Manufacturer::getBrand($value['manu_id']); ?></h5>
                                        </td>
                                        <td>
                                            <h5><?php echo Protype::getTypeName($value['type_id']); ?></h5>
                                        </td>
                                        <td>
                                            <h5><?php echo $value['description']; ?></h5>
                                        </td>
                                        <td>
                                            <h5><?php echo number_format($value['price']); ?></h5>
                                        </td>
                                        <td> <h5><?php echo $value['feature']; ?></h5></td>
                                        <td> <h5><?php echo $value['receipt']; ?></h5></td>
                                        <td> <h5><?php echo $value['created_at']; ?></h5></td>
                                        <td>
                                            <a href="form_update.php?functionType=products&id=<?php echo $value['id']; ?>" class="btn btn-success btn-mini">Edit</a>
                                            <a href="delete_product.php?id=<?php echo $value['id']; ?>" class="btn btn-danger btn-mini">Delete</a>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="text-align:center;">
        <?php
        if (isset($_GET['keyword']) == TRUE) {
            echo Product::paginate("index.php?keyword=" . $_GET['keyword'] . "&", $page, $totalResults, $resultsPerPage, 2);
        } else {
            echo Product::paginate("index.php?", $page, $totalResults, $resultsPerPage, 1);
        }
        ?>
    </div>
</div>
<!-- END CONTENT -->
<!--Footer-part-->
<div class="row-fluid">
    <div id="footer" class="span12"> 2024 &copy; TDC - Lập trình BackEnd</div>
</div>
<!--end-Footer-part-->
<script src="js/jquery.min.js"></script>
<script src="js/jquery.ui.custom.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.uniform.js"></script>
<script src="js/select2.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/matrix.js"></script>
<script src="js/matrix.tables.js"></script>
</body>

</html>