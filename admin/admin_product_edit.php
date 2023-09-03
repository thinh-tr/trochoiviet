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
    <title>Cập nhật thông tin sản phẩm</title>
    <style>
        #header {
            position: sticky;
            top: 0;
            z-index: 999;
        }
    </style>
</head>
<body>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/services/product_service.php"; ?>

    <?php
    // Lấy ra thông tin product cần chỉnh sửa
    if (isset($_GET["product-id"])) {
        $product = \ProductService\get_product_by_product_id($_GET["product-id"]);
        $product_image_array = \ProductService\get_product_image_by_product_id($_GET["product-id"]);
        $product_external_link_array = \ProductService\get_external_links_by_product_id($product->get_id());
    }
    ?>

    <?php
    // Xử lý cập nhật thông tin product
    if (isset($_POST["product-submit"])) {
        // Kiểm tra lại thông tin trên form
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
            // Nếu thông tin hợp lệ thì tiến hành cập nhật
            \ProductService\update_product($product->get_id(), $product_info_array["product_name"], $product_info_array["product_image"], $product_info_array["product_description"], $product_info_array["product_price"], $product_info_array["product_quantity"]);
            echo(<<<END
                <div class="alert alert-success" role="alert">
                    Đã cập nhật thông tin sản phẩm
                </div>          
                END);
        } else {
            echo("<script>window.alert('Thông tin sản phẩm chưa hợp lệ, vui lòng kiểm tra lại')</script>");
        }
    }
    ?>

    <?php
    // Xử lý thêm product_image mới
    if (isset($_POST["illutration-image-submit"])) {
        // Kiểm tra đường dẫn trước khi thêm
        if (strlen($_POST["product-illutration-image"]) >= 2) {
            // Lưu hình ảnh mới
            $product_image = new \Entities\ProductImage();
            $product_image->set_id(uniqid());
            $product_image->set_image_link($_POST["product-illutration-image"]);
            $product_image->set_product_id($product->get_id());
            \ProductService\create_product_image($product_image);
            echo(<<<END
                <div class="alert alert-success" role="alert">
                    Đã thêm hình ảnh
                </div>          
                END);
        } else {
            // Thông báo kiểm tra lại đường dẫn
            echo("<script>window.alert('Đường dẫn hình ảnh không hợp lệ, vui lòng kiểm tra lại')</script>");
        }
    }
    ?>

    <?php
    // Xử lý xóa product image được chọn
    for ($i = 0; $i < count($product_image_array); $i++) {
        if (isset($_POST[$product_image_array[$i]->get_id()])) {
            // xóa image
            \ProductService\delete_product_image($product_image_array[$i]->get_id());
            echo(<<<END
                <div class="alert alert-danger" role="alert">
                    Đã xóa link ảnh
                </div>          
                END);
        }
    }
    ?>

    <div id="header">
        <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "/admin/templates/admin_header.php"; ?>

        <!--Điều hướng-->
        <nav id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
            <a class="btn btn-primary" href="/admin/admin_product_manager_index.php"><i class="bi bi-arrow-left"></i> Trang quản lý cửa hàng</a>
            <div class="nav nav-pills">
                <li class="nav-item">
                    <a href="/admin/admin_product_rating.php?product-id=<?= $product->get_id() ?>" class="nav-link"><i class="bi bi-star"></i> Đánh giá về sản phẩm</a>
                </li>
                <li class="nav-item">
                    <form method="post">
                        <button class="btn btn-info" id="refresh" name="refresh"><i class="bi bi-arrow-counterclockwise"></i> Làm mới</button>
                    </form>
                </li>
            </div>
        </nav>
    </div>
    
    <div class="container">
        <div class="alert alert-info" role="alert">
            <i class="bi bi-info-circle"></i> Sau khi thay đổi thông tin hãy bấn nút lưu để đảm bảo thông tin mới được cập nhật
        </div>
        <h3><i class="bi bi-info-circle"></i> <b>Cập nhật thông tin cho sản phẩm: <?= $product->get_name() ?></b></h3>
        <form method="post" class="border border-primary" style="border-radius: 5px;">
            <div class="container">
                <div class="mb-3">
                    <label for="product-name" class="form-label"><b>Tên sản phẩm *</b></label>
                    <input type="text" class="form-control" id="product-name" name="product-name" placeholder="Tên sản phẩm (từ 2 ký tự trở lên)" value="<?= $product->get_name() ?>">
                </div>
                <div class="mb-3">
                    <label for="product-image" class="form-label"><b>Link ảnh bìa</b></label>
                    <input type="text" class="form-control" id="product-image" name="product-image" placeholder="Link ảnh bìa sản phẩm (từ 2 ký tự trở lên)" value="<?= $product->get_cover_image_link() ?>"><br>
                    <img src="<?= $product->get_cover_image_link() ?>" class="img-thumbnail" alt="..." style="width: 50%;">
                </div>
                <div class="mb-3">
                    <label for="product-description" class="form-label"><b>Mô tả</b></label>
                    <textarea class="form-control" id="product-description" name="product-description" rows="3"><?= $product->get_description() ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="product-price" class="form-label"><b>Giá bán lẻ *</b></label>
                    <input type="number" style="width: 50%;" class="form-control" id="product-price" name="product-price" placeholder="Giá bán lẻ (từ 0 trở lên)" value="<?= $product->get_retail_price() ?>">
                </div>
                <div class="mb-3">
                    <label for="product-quantity" class="form-label"><b>Số lượng hàng *</b></label>
                    <input type="number" style="width: 50%;" class="form-control" id="product-quantity" name="product-quantity" placeholder="Số lượng hàng (từ 1 trở lên)" value="<?= $product->get_remain_quantity() ?>">
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary" id="product-submit" name="product-submit"><i class="bi bi-box-arrow-up"></i> Lưu</button>
                    <a href="/admin/admin_product_manager_index.php" class="btn btn-danger"><i class="bi bi-x-circle-fill"></i> Hủy</a>
                </div>
            </div>
        </form><br>

        <h3><i class="bi bi-card-image"></i> <b>Hình ảnh minh họa cho sản phẩm</b></h3>
        <h5><i class="bi bi-plus-lg"></i> <b>Thêm ảnh minh họa</b></h5>
        <form method="post" class="border border-primary" style="border-radius: 5px;">
            <div class="container">
                <div class="mb-3">
                    <label for="product-illutration-image" class="form-label"><b>Link ảnh minh họa sản phẩm *</b></label>
                    <input type="text" class="form-control" id="product-illutration-image" name="product-illutration-image" placeholder="Link ảnh minh họa cho sản phẩm (từ 2 ký tự trở lên)">
                </div>
                <div calss="mb-3">
                    <button class="btn btn-primary" id="illutration-image-submit" name="illutration-image-submit"><i class="bi bi-box-arrow-up"></i> Lưu</button>
                    <button class="btn btn-danger" id="illutration-cancel" name="illutration-cancel"><i class="bi bi-x-circle-fill"></i> Hủy</button>
                </div>
            </div>
        </form><br>

        <h5><i class="bi bi-images"></i> <b>Các hình ảnh minh họa hiện có</b></h5>
        <?php
        // Lấy ra các ảnh minh họa hiện có
        if (count($product_image_array) > 0) {
        ?>
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <?php
            for ($i = 0; $i < count($product_image_array); $i++) {
            ?>
            <div class="col">
                <div class="card h-100">
                    <img src="<?= $product_image_array[$i]->get_image_link() ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text"><?= $product_image_array[$i]->get_image_link() ?></p>
                    </div>
                    <div class="card-footer">
                        <form method="post">
                            <button class="btn btn-danger" id="<?= $product_image_array[$i]->get_id() ?>" name="<?= $product_image_array[$i]->get_id() ?>"><i class="bi bi-trash3-fill"></i> Xóa</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </div><br>
        <?php
        } else {
        ?>
        <div class="alert alert-warning" role="alert">
            <i class="bi bi-info-circle-fill"></i> Sản phẩm này chưa có hình ảnh minh họa
        </div><br>
        <?php
        }
        ?>

        <h3><i class="bi bi-bag"></i> <b>Đường dẫn mua sắm của sản phẩm</b></h3>
        <h5><i class="bi bi-plus-lg"></i> <b>Thêm đường dẫn mua sắm mới</b></h5>
        <form method="post" class="border border-primary" style="border-radius: 5px;">
            <div class="container">
                <div class="mb-3">
                    <label for="shop-link-name" class="form-label"><b>Tên link *</b></label>
                    <input type="text" class="form-control" id="shop-link-name" name="shop-link-name" placeholder="Tên đường dẫn (từ 2 ký tự trở lên)">
                </div>
                <div class="mb-3">
                    <label for="shop-link" class="form-label"><b>Link mua sắm sản phẩm *</b></label>
                    <input type="text" class="form-control" id="shop-link" name="shop-link" placeholder="Đường dẫn đến cửa hàng sản phẩm (từ 2 ký tự trở lên)">
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary" id="shop-link-submit" name="shop-link-submit"><i class="bi bi-box-arrow-up"></i> Lưu</button>
                    <button class="btn btn-danger" id="shop-link-cancel" name="shop-link-cancel"><i class="bi bi-x-circle-fill"></i> Hủy</button>
                </div>
            </div>
        </form><br>

        <h5><i class="bi bi-bag"></i> <b>Các dường dẫn mua sắm hiện có</b></h5>
        <?php
        // Lấy ra các external_link hiện có
        if (count($product_external_link_array) > 0) {
        ?>
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <?php
            for ($i = 0; $i < count($product_external_link_array); $i++) {
            ?>
            <div class="col">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title"><i class="bi bi-box-arrow-up-right"></i> <b><?= $product_external_link_array[$i]->get_name() ?></b></h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            <a href="<?= $product_external_link_array[$i]->get_link() ?>"><?= $product_external_link_array[$i]->get_link() ?></a>
                        </p>
                    </div>
                    <div class="card-footer">
                        <form method="post">
                            <button class="btn btn-danger" id="<?= $product_external_link_array[$i]->get_id() ?>" name="<?= $product_external_link_array[$i]->get_id() ?>"><i class="bi bi-trash3-fill"></i> Xóa</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </div><br>
        <?php
        } else {
        ?>
        <div class="alert alert-warning" role="alert">
            <i class="bi bi-info-circle-fill"></i> Sản phẩm này chưa có đường dẫn mua sắm nào
        </div><br>
        <?php
        }
        ?>

    </div>


    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php"; ?>
</body>
</html>

<?php
// Xử lý thêm link mua sắm mới cho product
if (isset($_POST["shop-link-submit"])) {
    // Kiểm tra thông tin trên form
    $external_link_info = array();    // array chứa thông tin external_link sau khi đã được kiểm tra

    // Kiểm tra name
    if (strlen($_POST["shop-link-name"]) >= 2) {
        $external_link_info["name"] = $_POST["shop-link-name"];
    }

    // Kiểm tra link
    if (filter_var($_POST["shop-link"], FILTER_VALIDATE_URL)) {
        $external_link_info["link"] = $_POST["shop-link"];
    }

    // Kiểm tra lại array
    $is_valid_array = true;
    if (!array_key_exists("name", $external_link_info)) {
        $is_valid_array = false;
    } else if (!array_key_exists("link", $external_link_info)) {
        $is_valid_array = false;
    }

    // Nếu array hợp lệ thì tiến hành thêm link
    if ($is_valid_array) {
        $new_external_link = new Entities\ProductExternalLink();
        $new_external_link->set_id(uniqid());   // Tạo id
        $new_external_link->set_name($external_link_info["name"]);  // gán name
        $new_external_link->set_link($external_link_info["link"]);  // gán link
        $new_external_link->set_product_id($product->get_id()); // gán product_id

        // Thêm vào database
        ProductService\create_product_external_link($new_external_link);
        // Xuất ra thông báo
        echo("<script>window.alert('Đã thêm đường dẫn mới cho sản phẩm này')</script>");
    } else {
        echo("<script>window.alert('Vui lòng kiểm tra lại thông tin của bạn')</script>");
    }
}
?>

<?php
// Xử lý xóa external_link được chỉ định
for ($i = 0; $i < count($product_external_link_array); $i++) {
    // Nếu có lệnh xóa
    if (isset($_POST[$product_external_link_array[$i]->get_id()])) {
        ProductService\delete_external_link_by_id($product_external_link_array[$i]->get_id());
        // Xuất ra thông báo đã xóa
        echo("<script>window.alert('Đã xóa đường dẫn')</script>");
    }
}
?>