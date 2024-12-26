<!DOCTYPE html>
<html lang="en">
<?php
require_once "config.php";
require_once "models/db.php";
require_once "models/product.php";
require_once "models/protype.php";
require_once "models/manufacturer.php";
$product = new Product;
$manufacturer = new Manufacturer;
$protype = new Protype;
?>

<head>
    <title>Mobile Admin</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="image/logo.png" type="image/icon type">
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="css/uniform.css" />
    <link rel="stylesheet" href="css/select2.css" />
    <link rel="stylesheet" href="css/matrix-style.css" />
    <link rel="stylesheet" href="css/matrix-media.css" />
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
    <style type="text/css">
        ul.pagination {
            list-style: none;
            float: right;
        }

        ul.pagination li.active {
            font-weight: bold
        }

        ul.pagination li {
            float: left;
            display: inline-block;
            padding: 10px
        }
    </style>
</head>

<body>
    <!--Header-part-->
    <div id="header">
        <h1><a href="index.php"><img src="../img/logo.png" alt=""></a></h1>
    </div>
    <!--close-Header-part-->
    <!--top-Header-menu-->
    <div id="user-nav" class="navbar navbar-inverse">
        <ul class="nav">       
   
          
            <li class=""><a title="" href="#"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
        </ul>
    </div>
    <!--start-top-serch-->
    <div id="search">
        <input type="text" placeholder="Search here..." />
        <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
    </div>
    <!--close-top-serch-->
    <!--sidebar-menu-->
    <div id="sidebar"> <a href="#" class="visible-phone"><i class="icon icon-th"></i>Tables</a>
        <ul>
            <li><a href="index.php"><i class="icon icon-home"></i> <span>Danh sách sản phẩm</span></a> </li>
            <li> <a href="manufactures.php"><i class="icon icon-th-list"></i> <span>Mẫu Sản Phẩm</span></a></li>
            <li> <a href="protypes.php"><i class="icon icon-th-list"></i> <span>Loại Sản Phẩm</span></a></li>
            <li> <a href="users.php"><i class="icon icon-th-list"></i> <span>Users</span></a></li>

        </ul>
    </div><!-- BEGIN CONTENT -->
    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom current"><i class="icon-home"></i>
                    Home</a></div>
            <h1>Thêm dữ liệu mới</h1>
        </div>
        <div class="container-fluid">
            <hr>
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                            <h5></h5>
                        </div>
                        <div class="widget-content nopadding">


                            <!-- ____________________________________________________________________________________________________ -->
                            <!-- FUNCTION: Insert products. -->
                            <?php
                            if (isset($_GET['functionType']) == TRUE && $_GET['functionType'] == "products") {
                            ?>
                                <!-- BEGIN USER FORM -->
                                <form action="./insert_product.php" method="post" class="form-horizontal" enctype="multipart/form-data">
                                    <div class="control-group">
                                        <label class="control-label">Tên :</label>
                                        <div class="controls">
                                            <input type="text" class="span11" placeholder="Product name" name="name" required /> *
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Chọn mẫu sản phẩm:</label>
                                        <div class="controls">
                                            <?php
                                            $list_of_manufacturers = Manufacturer::getAllManufacturers();
                                            ?>
                                            <select name="manu_id" id="cate">
                                                <?php
                                                foreach ($list_of_manufacturers as $key => $value) {
                                                ?>
                                                    <option value="<?php echo $value['manu_id']; ?>"><?php echo $value['manu_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select> *
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Chọn loại sản phẩm:</label>
                                        <div class="controls">
                                            <?php
                                            $list_of_protypes = Protype::getAllProtypes();
                                            ?>
                                            <select name="type_id" id="subcate">
                                                <?php
                                                foreach ($list_of_protypes as $key => $value) {
                                                ?>
                                                    <option value="<?php echo $value['type_id']; ?>"><?php echo $value['type_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select> *
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Chọn hình :</label>
                                            <div class="controls">
                                                <input type="file" name="fileUpload" id="fileUpload" required>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Mô tả</label>
                                            <div class="controls">
                                                <textarea class="span11" placeholder="Description" name="description"></textarea>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Giá :</label>
                                                <div class="controls">
                                                    <input type="text" class="span11" placeholder="price" name="price" required /> *
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Receipt :</label>
                                                <div class="controls">
                                                    <input type="number" size="4" class="input-text qty text" title="Qty" value="100" name="receipt" min="1" step="1">
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Nổi bật :</label>
                                                <div class="controls">
                                                    <input type="number" class="span11" name="feature" min="0" max="1"  value = "1" required /> *
                                                </div>
                                            </div>
                                            <div class="form-actions" style="text-align:center;">
                                                <button type="submit" name="submit" class="btn btn-success" style="padding:5px 50px;">Thêm</button>
                                            </div>
                                        </div>
                                </form>
                                <!-- INSERT RESULT: -->
                                <div style="padding:30px 0;text-align:center;font-weight:bold;font-size:15px;">
                                    <?php
                                    echo "<div style=\"text-decoration:underline;\">Kết quả:</div>";
                                    if (isset($_GET['insertResult']) == TRUE) {
                                        if ($_GET['insertResult'] > 0) {
                                            echo "<span style=\"color:green;\">" . "Dữ liệu mới đã được thêm." . "</span>";
                                        } else {
                                            echo "<span style=\"color:red;\">" . "Không thể thêm dữ liệu mới!" . "</span>";
                                        }
                                    }
                                    ?>
                                </div>
                                <!-- END USER FORM -->
                            <?php
                            }
                            ?>



                            <!-- ____________________________________________________________________________________________________ -->
                            <!-- FUNCTION: Insert manufacturers. -->
                            <?php
                            if (isset($_GET['functionType']) == TRUE && $_GET['functionType'] == "manufacturers") {
                            ?>
                                <!-- BEGIN USER FORM -->
                                <form action="insert_manufacturer.php" method="get" class="form-horizontal" enctype="multipart/form-data">
                                    <div class="control-group">
                                        <label class="control-label">Tên mẫu:</label>
                                        <div class="controls">
                                            <input type="text" class="span11" placeholder="Manufacturer name" name="manu_name" required /> *
                                        </div>
                                        <div class="form-actions" style="text-align:center;">
                                            <button type="submit" name="submit" class="btn btn-success" style="padding:5px 50px;">Thêm</button>
                                        </div>
                                    </div>
                                </form>
                                <!-- INSERT RESULT: -->
                                <div style="padding:30px 0;text-align:center;font-weight:bold;font-size:15px;">
                                    <?php
                                    echo "<div style=\"text-decoration:underline;\">Kết quả:</div>";
                                    if (isset($_GET['insertResult']) == TRUE) {
                                        if ($_GET['insertResult'] > 0) {
                                            echo "<span style=\"color:green;\">" . "Dữ liệu mới đã được thêm" . "</span>";
                                        } else {
                                            echo "<span style=\"color:red;\">" . "Không thể thêm dữ liệu mới!" . "</span>";
                                        }
                                    }
                                    ?>
                                </div>
                                <!-- END USER FORM -->
                            <?php
                            }
                            ?>



                            <!-- ____________________________________________________________________________________________________ -->
                            <!-- FUNCTION: Insert product types. -->
                            <?php
                            if (isset($_GET['functionType']) == TRUE && $_GET['functionType'] == "protypes") {
                            ?>
                                <!-- BEGIN USER FORM -->
                                <form action="insert_protype.php" method="get" class="form-horizontal" enctype="multipart/form-data">
                                    <div class="control-group">
                                        <label class="control-label">Loại sản phẩm:</label>
                                        <div class="controls">
                                            <input type="text" class="span11" placeholder="Product type" name="type_name" required /> *
                                        </div>
                                        <div class="form-actions" style="text-align:center;">
                                            <button type="submit" name="submit" class="btn btn-success" style="padding:5px 50px;">Thêm</button>
                                        </div>
                                    </div>
                                </form>
                                <!-- INSERT RESULT: -->
                                <div style="padding:30px 0;text-align:center;font-weight:bold;font-size:15px;">
                                    <?php
                                    echo "<div style=\"text-decoration:underline;\">RESULT:</div>";
                                    if (isset($_GET['insertResult']) == TRUE) {
                                        if ($_GET['insertResult'] > 0) {
                                            echo "<span style=\"color:green;\">" . "Dữ liệu mới đã được thêm" . "</span>";
                                        } else {
                                            echo "<span style=\"color:red;\">" . "Không thể thêm dữ liệu mới!" . "</span>";
                                        }
                                    }
                                    ?>
                                </div>
                                <!-- END USER FORM -->
                            <?php
                            }
                            ?>

                            <!-- ____________________________________________________________________________________________________ -->
                            <!-- FUNCTION: Insert users. -->
                            <?php
                            if (isset($_GET['functionType']) == TRUE && $_GET['functionType'] == "users") {
                            ?>
                                <!-- BEGIN USER FORM -->
                                <form action="insert_user.php" method="get" class="form-horizontal" enctype="multipart/form-data">
                                    <div class="control-group">
                                        <label class="control-label">Username:</label>
                                        <div class="controls">
                                            <input type="text" class="span11" placeholder="Username..." name="username" required /> *
                                        </div>
                                        <label class="control-label">Password:</label>
                                        <div class="controls">
                                            <input type="password" class="span11" placeholder="Password..." name="password" required /> *
                                        </div>
                                        <label class="control-label">Confirm Password:</label>
                                        <div class="controls">
                                            <input type="password" class="span11" placeholder="Confirm Password..." name="password2" required /> *
                                        </div>
                                        <label class="control-label">Role:</label>
                                        <div class="controls">
                                            <select name="permission" id="permission">
                                                <option value="User">User</option>
                                                <option value="Admin">Admin</option>
                                            </select> *
                                        </div>

                                        <div class="form-actions" style="text-align:center;">
                                            <button type="submit" name="submit" class="btn btn-success" style="padding:5px 50px;">Thêm</button>
                                        </div>
                                    </div>
                                </form>
                                <!-- INSERT RESULT: -->
                                <div style="padding:30px 0;text-align:center;font-weight:bold;font-size:15px;">
                                    <?php
                                    echo "<div style=\"text-decoration:underline;\">RESULT:</div>";
                                    if (isset($_GET['insertResult']) == TRUE) {
                                        if ($_GET['insertResult'] > 0) {
                                            echo "<span style=\"color:green;\">" . "User mới đã được thêm" . "</span>";
                                        } else {
                                            echo "<span style=\"color:red;\">" . "Không thể thêm User mới!" . "</span>";
                                        }
                                    }
                                    ?>
                                </div>
                                <!-- END USER FORM -->
                            <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
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