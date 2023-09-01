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
    <title>Đánh giá sản phẩm</title>
    <style>
        #header {
            position: sticky;
            top: 0;
            z-index: 999;
        }
    </style>
</head>
<body>

    <?php
    include $_SERVER["DOCUMENT_ROOT"] . "/services/product_service.php";
    include $_SERVER["DOCUMENT_ROOT"] . "/services/user_service.php";
    include $_SERVER["DOCUMENT_ROOT"] . "/services/order_service.php";
    include $_SERVER["DOCUMENT_ROOT"] . "/entities/order_state.php";
    ?>

    <?php
    // Lấy ra thông tin của product cần đánh giá
    $product = null;
    $product_rating_array = array();
    if (isset($_GET["product-id"])) {
        $product = ProductService\get_product_by_product_id($_GET["product-id"]);
        $product_rating_array = ProductService\get_product_ratings_by_product_id($_GET["product-id"]);
    }
    ?>

    <div id="header">
        <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "/admin/templates/admin_header.php"; ?>

        <!--Điều hướng-->
        <nav id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
            <div class="container-fluid">
                <a class="btn btn-primary" href="/admin/admin_product_edit.php?product-id=<?= $product->get_id() ?>"><i class="bi bi-arrow-left"></i> Trang cập nhật thông tin sản phẩm</a>
                <ul class="nav nav-bills">
                    <li class="nav-item">
                        <form method="post">
                            <button class="btn btn-info" name="refresh"><i class="bi bi-arrow-counterclockwise"></i> Làm mới</button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <div class="container" style="margin-bottom: 2cm;">
        <h4>Đánh giá cho sản phẩm: <b><?= $product->get_name() ?></b></h4>
        <h5>Đánh giá trung bình: <b><i class="bi bi-star-half"></i> <?= ProductService\get_avg_of_product_rating_by_product_id($product->get_id()) ?></b></h5><br>

        <h4><i class="bi bi-star-half"></i> <b>Các đánh giá về sản phẩm này</h4>
        <div class="container">
        <?php
        if (count($product_rating_array) > 0) {
            foreach ($product_rating_array as $rating) {
        ?>
            <div class="card border-primary mb-3" style="width: 70%;">
                <div class="card-header">
                    <small><i class="bi bi-person-circle"></i> Người dùng: <b><?= $rating->get_user_phone_number() ?></b></small>
                </div>
                <div class="card-body">
                    <p class="card-text">Đánh giá: <i class="bi bi-star-fill"></i> <?= $rating->get_rating_star() ?></p>
                    <p class="card-text"><?= $rating->get_content() ?></p>
                </div>
            </div>
        <?php
            }
        } else {
        ?>
        <div class="alert alert-warning" role="alert">
            <i class="bi bi-info-circle-fill"></i> Sản phẩm này hiện chưa có đánh giá nào
        </div>
        <?php
        }
        ?>
        </div>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php"; ?>
</body>
</html>