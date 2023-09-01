<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Quản lý sản phẩm</title>
    <style>
        #header {
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .col a {
            text-decoration: none;
        }

        .card-footer form a {
            text-decoration: none;
        }

        .container {
            padding-bottom: 2cm;
        }
    </style>
</head>
<body>
    <div id="header">
        <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "/admin/templates/admin_header.php"; ?>

        <!--Điều hướng-->
        <nav id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
            <a class="btn btn-primary" href="/admin/admin_index.php"><i class="bi bi-arrow-left"></i> Trang quản trị</a>
            <ul class="nav nav-bills">
                <li class="nav-item">
                    <form method="post">
                        <a href="/admin/admin_create_product.php" class="btn btn-warning"><i class="bi bi-plus-lg"></i> Thêm sản phẩm mới</a>
                        <button class="btn btn-info" name="refresh"><i class="bi bi-arrow-counterclockwise"></i> Làm mới</button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/services/product_service.php"; //service ?>
    
    <?php
    // Lấy ra thông tin product của admin
    $product_array = array();
    if (isset($_SESSION["admin_email"])) {
        $product_array = ProductService\get_product_by_admin_email($_SESSION["admin_email"]);
    }
    ?>

    <?php
    // Xử lý xóa product
    for ($i = 0; $i < count($product_array); $i++) {
        // Nếu như có lệnh xóa bất kỳ product nào
        if (isset($_POST[$product_array[$i]->get_id()])) {
            \ProductService\delete_product($product_array[$i]->get_id());
            // Thông báo đã xóa
            echo(<<<END
                <div class="alert alert-danger" role="alert">
                    Đã xóa sản phẩm
                </div>
                END);
        }
    }
    ?>

    
    <div class="container">
        <h2><i class="bi bi-box"></i> <b>Sản phẩm của bạn</b></h2>
        <?php
        // Xử lý truy vấn thông tin cho trang
        if (isset($_SESSION["admin_email"])) {
            // Kiểm tra admin login
        ?>
        <?php
            if (count($product_array) > 0) {
            // Kiểm tra kết quả truy vấn
        ?>
            <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            for ($i = 0; $i < count($product_array); $i++) {
            ?>
                <!--Lần lượt hiển thị ra các product-->
                <div class="col">
                    <a href="/admin/admin_product_edit.php?product-id=<?= $product_array[$i]->get_id() ?>">
                        <div class="card h-100">
                            <img src="<?= $product_array[$i]->get_cover_image_link() ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><b><?= $product_array[$i]->get_name() ?></b></h5>
                                <h5 class="card-title">Đơn giá: <?= $product_array[$i]->get_retail_price() ?> VNĐ</h5>
                                <p class="card-text">Số lượng còn lại: <?= $product_array[$i]->get_remain_quantity() ?></p>
                            </div>
                            <div class="card-footer">
                                <form method="post">
                                    <button type="submit" class="btn btn-danger" id="<?= $product_array[$i]->get_id() ?>" name="<?= $product_array[$i]->get_id() ?>"><i class="bi bi-trash3-fill"></i> Xóa (Không thể phục hồi)</button>
                                </form>
                            </div>  
                        </div>
                    </a>
                </div>
            <?php
            }
            ?>
            </div>
        <?php
            } else {
        ?>
            <!--Thông báo không tìm thấy product nào-->
            <div class="alert alert-warning" role="alert">
                <i class="bi bi-info-circle-fill"></i> Bạn vẫn chưa có sản phẩm nào
            </div>
        <?php
            }
        ?>
        <?php
        } else {
            // Hiển thị thông báo chưa đăng nhập
        ?>
            <div class="alert alert-danger" role="alert">
                <i class="bi bi-info-circle-fill"></i> Bạn vẫn chưa đăng nhập
            </div>
        <?php
        }
        ?>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php"; ?>
</body>
</html>