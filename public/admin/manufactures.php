<?php require_once 'header.php' ?>
<!-- BEGIN CONTENT -->
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom current"><i class="icon-home"></i> Home</a></div>
        <h1>Mẫu sản phẩm</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <!--start-top-serch-->
        <div id="searchManufacture" style="float: left;">
            <form action="#" method="get">
                <input type="text" name="keyword" placeholder="Nhập để tìm...">
                <input type="submit" name="submit" value="Search" class="btn btn-success">
            </form>
        </div>
        <!--close-top-serch-->
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"><a href="form.php?functionType=manufacturers"> <i class="icon-plus"></i>
                            </a></span>
                        <h5>Mẫu sản phẩm</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Tên mẫu</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $page = 1;
                                $resultsPerPage = 5;
                                // $totalLinks = ceil($totalResults/$resultsPerPage);
                                if (isset($_GET['page'])) {
                                    $page = $_GET['page'];
                                }
                                if (isset($_GET['keyword'])) {
                                    $list_of_manufacturers = Manufacturer::searchManufacture_andCreatePagination($_GET['keyword'], $page, $resultsPerPage);
                                    $totalResults = count(Manufacturer::searchManufacture($_GET['keyword']));
                                } else {
                                    $list_of_manufacturers = Manufacturer::getAllManufacturers_andCreatePagination($page, $resultsPerPage);
                                    $totalResults = count(Manufacturer::getAllManufacturers());
                                }
                                // Output:
                                echo "<p style=\"text-align:center;\"><b>There are $totalResults results.</b></p>";
                                foreach ($list_of_manufacturers as $key => $value) {
                                ?>
                                    <tr class="">
                                        <td><h5><?php echo $value['manu_name']; ?></h5></td>
                                        <td>
                                            <a href="form_update.php?functionType=manufacturers&manu_id=<?php echo $value['manu_id']; ?>" class="btn btn-success btn-mini">Sửa</a>
                                            <a href="delete-manufacture.php?manu_id=<?php echo $value['manu_id']; ?>&deleteResult=1" class="btn btn-danger btn-mini">Xóa</a>
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
    <div style="text-align: center;">
        <?php
        if (isset($_GET['keyword'])) {
            echo Manufacturer::paginate("manufactures.php?keyword=" . $_GET['keyword'] . "&", $page, $totalResults, $resultsPerPage, 2);
        } else {
            echo Manufacturer::paginate("manufactures.php?", $page, $totalResults, $resultsPerPage, 1);
        }
        ?>
    </div>
</div>
<!-- END CONTENT -->
<!--Footer-part-->
<div class="row-fluid">
    <div id="footer" class="span12"> 2024&copy; TDC - Lập trình BackEnd</div>
</div>
<?php
if (isset($_GET['deleteResult']) == TRUE) {
    if ($_GET['deleteResult'] == 1) {
        echo "<script type='text/javascript'>alert('Xóa thành công!');</script>";
    } elseif ($_GET['deleteResult'] == 0) {
        echo "<script type='text/javascript'>alert('Không thể xóa! Vì có sự tồn tại của sản phẩm thuộc mẫu này.');</script>";
    }
}
?>
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