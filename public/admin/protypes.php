<?php require_once 'header.php' ?>
<!-- BEGIN CONTENT -->
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom current"><i class="icon-home"></i> Home</a></div>
        <h1>Quản lý mẫu sản phầm </h1>
    </div>
    <div class="container-fluid">
        <hr>
        <!--start-top-serch-->
        <div id="searchProtype" style="float: left;">
            <form action="#" method="get">
                <input type="text" name="keyword" placeholder="Nhập để tìm...">
                <input type="submit" name="submit" value="Search" class="btn btn-success">
            </form>
        </div>
        <!--close-top-serch-->
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"><a href="form.php?functionType=protypes"> <i class="icon-plus"></i>
                            </a></span>
                        <h5>Mẫu</h5>
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
                                if (isset($_GET['page']) == TRUE) {
                                    $page = $_GET['page'];
                                }
                                if (isset($_GET['keyword'])) {
                                    $list_of_protypes = Protype::searchProtype_andCreatePagination($_GET['keyword'], $page, $resultsPerPage);
                                    $totalResults = count(Protype::searchProtype($_GET['keyword']));
                                } else {
                                    $list_of_protypes = Protype::getAllProtypes_andCreatePagination($page, $resultsPerPage);
                                    $totalResults = count(Protype::getAllProtypes());
                                }
                                // Output:
                                echo "<p style=\"text-align:center;\"><b>Tìm thấy $totalResults kết quả.</b></p>";
                                foreach ($list_of_protypes as $key => $value) {
                                ?>
                                    <tr class="">
                                        <td>
                                            <h5><?php echo $value['type_name']; ?></h5>
                                        </td>

                                        <td>
                                            <a href="form_update.php?functionType=protypes&type_id=<?php echo $value['type_id']; ?>" class="btn btn-success btn-mini">Edit</a>
                                            <a href="delete_protype.php?type_id=<?php echo $value['type_id']; ?>" class="btn btn-danger btn-mini">Xóa</a>
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
            echo Protype::paginate("protypes.php?keyword=" . $_GET['keyword'] . "&", $page, $totalResults, $resultsPerPage, 2);
        } else {
            echo Protype::paginate("protypes.php?", $page, $totalResults, $resultsPerPage, 1);
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
        echo "<script type='text/javascript'>alert('Deleted successfully!');</script>";
    } elseif ($_GET['deleteResult'] == 0) {
        echo "<script type='text/javascript'>alert('Unable to delete! Because there is the existence of products that belong to this product type.');</script>";
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