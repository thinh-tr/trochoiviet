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
    <title>Thêm sản phẩm mới</title>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/admin/templates/admin_header.php"; ?>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/services/product_service.php"; ?>

    <?php
    // Xử lý lệnh tạo sản phẩm mới
    if (isset($_POST["product-submit"])) {
        // Kiểm tra login
        if (isset($_SESSION["admin_email"])) {
            // Kiểm tra lại thông tin trong form
            $product_info_array = array();
            
            // Kiểm tra tên sản phẩm
            if (strlen($_POST["product-name"]) >= 2) {
                $product_info_array["product_name"] = $_POST["product-name"];
            }

            // Kiểm tra link ảnh bìa
            if (strlen($_POST["product-image"]) >= 2) {
                $product_info_array["product_image"] = $_POST["product-image"];
            }

            // Mô tả
            $product_info_array["product_description"] = $_POST["product-description"];

            // Kiểm tra giá bán lẻ
            if (intval($_POST["product-price"]) >= 0) {
                $product_info_array["product_price"] = $_POST["product-price"];
            }

            // Kiểm tra số lượng hàng
            if (intval($_POST["product-quantity"]) >= 1) {
                $product_info_array["product_quantity"] = $_POST["product-quantity"];
            }

            // Kiểm tra lại array
            $is_valid_array = true;

            if (!array_key_exists("product_name", $product_info_array)) {
                $is_valid_array = false;
            } else if (!array_key_exists("product_image", $product_info_array)) {
                $is_valid_array = false;
            } else if (!array_key_exists("product_price", $product_info_array)) {
                $is_valid_array = false;
            } else if (!array_key_exists("product_quantity", $product_info_array)) {
                $is_valid_array = false;
            }

            if ($is_valid_array) {
                // Khởi tạo obj
                $new_product = new \Entities\Product();
                $new_product->set_id(uniqid()); // gán id
                $new_product->set_name($product_info_array["product_name"]);    // gán name
                $new_product->set_cover_image_link($product_info_array["product_image"]);   // image
                $new_product->set_description($product_info_array["product_description"]);  // description
                $new_product->set_retail_price($product_info_array["product_price"]);   // giá bán
                $new_product->set_remain_quantity($product_info_array["product_quantity"]); // số lượng
                $new_product->set_admin_email($_SESSION["admin_email"]);    // gán admin_email
                \ProductService\create_product($new_product);
                echo(<<<END
                    <div class="alert alert-success" role="alert">
                        Đã thêm sản phẩm thành công
                    </div>          
                    END);

            } else {
                echo("<script>window.alert('Thông tin sản phẩm chưa hợp lệ, vui lòng kiểm tra lại')</script>");
            }
        } else {
            // Hiển thịn thông báo
            echo(<<<END
                <div class="alert alert-warning" role="alert">
                    Bạn vẫn chưa đăng nhập
                </div>
                END);
        }
    }
    ?>

    <!--Điều hướng-->
    <nav id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
        <a class="btn btn-primary" href="/admin/admin_product_manager_index.php"><i class="bi bi-arrow-left"></i> Tranh quản lý cửa hàng</a>
    </nav>
    <div class="container">
        <h3><i class="bi bi-info-circle"></i> <b>Thêm thông tin cho sản phẩm</b></h3>
        <form method="post" class="border border-primary" style="border-radius: 5px;">
            <div class="container">
                <div class="mb-3">
                    <label for="product-name" class="form-label"><b>Tên sản phẩm *</b></label>
                    <input type="text" class="form-control" id="product-name" name="product-name" placeholder="Tên sản phẩm (từ 2 ký tự trở lên)">
                </div>
                <div class="mb-3">
                    <label for="product-image" class="form-label"><b>Link ảnh bìa</b></label>
                    <input type="text" class="form-control" id="product-image" name="product-image" placeholder="Link ảnh bìa sản phẩm (từ 2 ký tự trở lên)">
                </div>
                <div class="mb-3">
                    <label for="product-description" class="form-label"><b>Mô tả</b></label>
                    <textarea class="form-control" id="product-description" name="product-description" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="product-price" class="form-label"><b>Giá bán lẻ *</b></label>
                    <input type="number" class="form-control" id="product-price" name="product-price" placeholder="Giá bán lẻ (từ 0 trở lên)">
                </div>
                <div class="mb-3">
                    <label for="product-quantity" class="form-label"><b>Số lượng hàng *</b></label>
                    <input type="number" class="form-control" id="product-quantity" name="product-quantity" placeholder="Số lượng hàng (từ 1 trở lên) ">
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary" id="product-submit" name="product-submit"><i class="bi bi-box-arrow-up"></i> Tạo sản phẩm</button>
                    <a href="/admin/admin_product_manager_index.php" class="btn btn-danger"><i class="bi bi-trash3-fill"></i> Hủy</a>
                </div>
            </div>
        </form>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php"; ?>
</body>
</html>