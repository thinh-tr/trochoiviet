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
    <title>Chi tiết sản phẩm</title>
    <style>
        #header {
            position: sticky;
            top: 0;
            z-index: 999;
        }
    </style>
</head>

<body>
    <div id="header">
        <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>

        <!--Điều hướng-->
        <nav id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
            <a class="btn btn-primary" href="/product/product_index.php"><i class="bi bi-arrow-left"></i> Trang cửa hàng</a>
        </nav>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/services/product_service.php"; ?>

    <?php
    // Truy vấn thông tin về product
    if (isset($_GET["product-id"])) {
        $product = \ProductService\get_product_by_product_id($_GET["product-id"]);
        $product_image_array = \ProductService\get_product_image_by_product_id($_GET["product-id"]);
    }
    ?>

    <?php
    // Xử lý thêm product vào giỏ hàng
    if (isset($_POST["add-product-to-cart"])) {
        // Nếu có tồn tại biến giỏ hàng
        if (isset($_SESSION["shopping_cart"])) {
            // Nếu như đã tồn tại biến giỏ hàng
            $cart_item = array("product_id" => $product->get_id(), "quantity" => intval($_POST["item-quantity"]), "admin_email" => $product->get_admin_email());  // tạo item cần thêm
            // Kiểm tra xem đã tồn tại mã sản phẩm này trong cart hay chưa
            $is_item_exists = false;
            $index_of_product = -1; // Biến chứa vị trí index mà product được chứa trong cart
            for ($i = 0; $i < count($_SESSION["shopping_cart"]); $i++) {
                if ($_SESSION["shopping_cart"][$i]["product_id"] == $cart_item["product_id"]) {
                    $is_item_exists = true;
                    $index_of_product = $i;
                    break;
                }
            }

            if ($is_item_exists) {
                // Nếu như sản phẩm này đã có trong giỏ hàng -> chỉ cần tăng thêm số lượng và kiểm tra lại số lượng mới trước khi thêm
                $new_quantity = $_SESSION["shopping_cart"][$index_of_product]["quantity"] + $cart_item["quantity"];
                // Kiểm tra số lượng trước khi thêm
                if ($new_quantity >= 1 && $new_quantity <= $product->get_remain_quantity()) {
                    // Cập nhật lại quantity
                    $_SESSION["shopping_cart"][$index_of_product]["quantity"] = $new_quantity;
                    echo("<script>window.alert('Đã thêm sản phẩm vào giỏ hàng')</script>");
                } else {
                    echo("<script>window.alert('Vui lòng kiểm tra lại số lượng sản phẩm')</script>");
                }
            } else {
                // Nếu sản phẩm chưa tồn tại trong cart thì thêm như bình tường
                if ($cart_item["quantity"] >= 1 && $cart_item["quantity"] <= $product->get_remain_quantity()) {
                    array_push($_SESSION["shopping_cart"], $cart_item);
                    echo("<script>window.alert('Đã thêm sản phẩm vào giỏ hàng')</script>");
                } else {
                    echo("<script>window.alert('Vui lòng kiểm tra lại số lượng sản phẩm')</script>");
                }                
            }
        } else {
            // Nếu chưa tồn tại biến giỏ hàng
            $_SESSION["shopping_cart"] = array();   // tạo biến giỏ hàng
            $cart_item = array("product_id" => $product->get_id(), "quantity" => intval($_POST["item-quantity"]), "admin_email" => $product->get_admin_email());  // tạo item cần thêm
            // Kiểm tra số lượng trước khi thêm
            if ($cart_item["quantity"] >= 1 && $cart_item["quantity"] <= $product->get_remain_quantity()) {
                array_push($_SESSION["shopping_cart"], $cart_item);
                echo("<script>window.alert('Đã thêm sản phẩm vào giỏ hàng')</script>");
            } else {
                echo("<script>window.alert('Vui lòng kiểm tra lại số lượng sản phẩm')</script>");
            }
        }
    }
    ?>


    <div class="container">

        <!--Thẻ hiển thị thông tin sản phẩm-->
        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="<?= $product->get_cover_image_link() ?>" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h3 class="card-title"><b><?= $product->get_name() ?></b></h3>
                        <p class="card-text">Người đăng: <b><?= $product->get_admin_email() ?></b></p>
                        <h5 class="card-text">Đơn giá: <b><?= $product->get_retail_price() ?> VNĐ</b></h5>
                        <h5 class="card-text">Đánh giá: <i class="bi bi-star-half"></i> <?= ProductService\get_avg_of_product_rating_by_product_id($product->get_id()) ?></h5>
                        <p class="card-text">Số lượng còn: <b><?= $product->get_remain_quantity() ?></b></p>
                        <!--Thêm vào giỏ hàng-->
                        <div class="card">
                            <p class="card-header"><small><i class="bi bi-bag"></i> <b>Chọn mua</b></small></p>
                            <div class="card-body">
                                <form method="post">
                                    <label for="item-quantity" class="form-label">Số lượng:</label>
                                    <input type="number" class="form-control" style="width: 50%;" id="item-quantity" name="item-quantity" placeholder="Số lượng sản phẩm" value="1"><br>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-outline-primary btn-lg" id="add-product-to-cart" name="add-product-to-cart"><i class="bi bi-cart-plus-fill"></i> THÊM VÀO GIỎ HÀNG</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Thanh chức năng-->
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <form class="container-fluid justify-content-start" method="post">
                    <a href="/product/product_rating.php?product-id=<?= $product->get_id() ?>" class="btn btn-outline-warning"><i class="bi bi-star-half"></i> Đánh giá sản phẩm</a>
                    <a class="btn btn-secondary" href="https://www.facebook.com/sharer/sharer.php?u=<?= $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>"><i class="bi bi-arrow-right-short"></i> <i class="bi bi-facebook"></i></i></a>
                </form>
            </div>
        </nav><br>

        <!--Mô tả-->
        <div class="card">
            <h5 class="card-header"><i class="bi bi-info-circle"></i> <b>Mô tả sản phẩm</b></h5>
            <div class="card-body">
                <p class="card-text"><?= $product->get_description() ?></p>
            </div>
        </div><br>

        <!--Hình ảnh về sản phẩm-->
        <div class="card">
            <h5 class="card-header"><i class="bi bi-images"></i> <b>Hình ảnh sản phẩm</b></h5>
            <div class="card-body">
                <?php
                if (count($product_image_array) > 0) {
                ?>
                <!--Hiển thị carousel hình ảnh-->
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php
                    foreach ($product_image_array as $image) {
                    ?>
                    <div class="col">
                        <img src="<?= $image->get_image_link() ?>" class="img-fluid" alt="...">
                    </div>
                    <?php
                    }
                    ?>
                </div>
                <?php
                } else {
                ?>
                    <!--Thông báo không tìm thấy hình ảnh nào-->
                    <div class="alert alert-warning" role="alert">
                     <i class="bi bi-info-circle-fill"></i> Không có hình ảnh
                    </div>
                <?php
                }
                ?>
            </div>
        </div>

    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php"; ?>
</body>

</html>