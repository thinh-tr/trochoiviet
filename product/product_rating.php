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

    <?php
    // Xử lý chọn số sao cho đánh giá
    $rating_star = 0;
    if (isset($_POST["rating-star"])) {
        $rating_star = intval($_POST["rating-star"]);
    }

    // Xử lý thêm Đáng giá mới
    if (isset($_POST["rating-submit"])) {
        // Kiểm tra lại thông tin trong form
        $rating_info_array = array();

        // Kiểm tra số star được chọn
        if ($rating_star != 0) {
            $rating_info_array["rating_star"] = $rating_star;
        }

        // Kiểm tra phone_number
        if (is_numeric($_POST["phone-number"]) && strlen($_POST["phone-number"]) <= 12 && UserService\is_user_info_exists($_POST["phone-number"])) {
            $rating_info_array["phone_number"] = $_POST["phone-number"];
        }

        // Kiểm tra rating_content
        if (strlen($_POST["rating-content"]) <= 8000) {
            $rating_info_array["rating_content"] = $_POST["rating-content"];
        }

        // Kiểm tra lại array
        $is_valid_array = true;
        if (!array_key_exists("rating_star", $rating_info_array)) {
            $is_valid_array = false;
        } else if (!array_key_exists("phone_number", $rating_info_array)) {
            $is_valid_array = false;
        } else if (!array_key_exists("rating_content", $rating_info_array)) {
            $is_valid_array = false;
        }

        // Nếu array hợp lệ thì tiến hành thêm rating
        if ($is_valid_array) {
            // Kiểm tra trạng thái mua hàng của phone_number thông qua thông tin đơn hàng
            // Lấy ra id của các đơn hàng đã hoàn tất của phone_number
            $phone_number_order_id_array = OrderService\get_order_ids_at_the_same_state_by_user_phone_number(OrderState\finished, $rating_info_array["phone_number"]);
            // Lấy ra OrderDetail của từng order_id tìm được, sau đó tìm ra product_id trùng khớp với sản phảm cần xét
            $is_found = false;  // Biến trạng thái xác nhận tìm thấy product_id trùng khớp
            if (count($phone_number_order_id_array) > 0) {
                foreach ($phone_number_order_id_array as $order_id) {
                    $order_detail_array = OrderService\get_order_details_by_order_id($order_id);    // Lấy ra danh sách order_detail của order_id tương ứng
                    // Duyệt qua từng order_detail để tìm product_id trùng khớp
                    foreach ($order_detail_array as $order_detail) {
                        // So sánh
                        if ($order_detail->get_product_id() == $product->get_id()) {
                            $is_found = true;   // Xác nhận đã tìm thấy sản phẩm trong danh sách order
                        }
                        // thoát khỏi vòng lặp nếu đã tìm thấy product
                        if ($is_found) {
                            break;
                        }
                    }
                    // Thoát khỏi vòng lặp nếu đã tìm thấy product
                    if ($is_found) {
                        break;
                    }
                }

                // Nếu như đã xác nhận sản phẩm đã từng được phone_number đang xét mua
                if ($is_found) {
                    // Thêm rating
                    $new_rating = new \Entities\ProductRating();
                    $new_rating->set_id(uniqid());
                    $new_rating->set_rating_star($rating_info_array["rating_star"]);
                    $new_rating->set_content($rating_info_array["rating_content"]);
                    $new_rating->set_product_id($product->get_id());
                    $new_rating->set_user_phone_number($rating_info_array["phone_number"]);
                    // Xóa các rating cũ
                    ProductService\delete_product_rating_of_user_to_product($rating_info_array["phone_number"], $product->get_id());
                    // Ghi vào database
                    ProductService\create_product_rating($new_rating);
                    echo("<script>window.alert('Đã thêm đánh giá')</script>");
                } else {
                    // Chưa được mua
                    echo("<script>window.alert('Có thể bạn vẫn chưa mua sản phẩm này')</script>");
                }
            } else {
                // Thông báo có thể phone_number vẫn chưa mua sản phẩm này
                echo("<script>window.alert('Có thể bạn vẫn chưa mua sản phẩm này')</script>");
            }
        } else {
            // Thông báo kiểm tra lại đánh giá của bạn
            echo("<script>window.alert('Vui lòng kiểm tra lại đánh giá của bạn')</script>");
        }
    }
    ?>

    <div id="header">
        <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>

        <!--Điều hướng-->
        <nav id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
            <div class="container-fluid">
                <a class="btn btn-primary" href="/product/product_detail.php?product-id=<?= $product->get_id() ?>"><i class="bi bi-arrow-left"></i> Trang chi tiết sản phẩm</a>
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

    <div class="container" style="margin-bottom: 3cm;">
        <h4>Đánh giá cho sản phẩm: <b><?= $product->get_name() ?></b></h4>
        <h5>Đánh giá trung bình: <b><i class="bi bi-star-half"></i> <?= ProductService\get_avg_of_product_rating_by_product_id($product->get_id()) ?></b></h5>

        <div class="container" style="margin-bottom: 1cm;">
            <!--Form thêm rating mới (mỗi phone_number chỉ có thể có tốt đa một rating / product)-->
            <form method="post">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title"><i class="bi bi-star-half"></i> <b>Thêm đánh giá mới</b></span>
                    </div>
                    <div class="card-body">
                        <b>Mức độ hài lòng: (theo số sao)</b><br>
                        <input type="radio" name="rating-star" value="1"> <i class="bi bi-star-fill"></i><br>
                        <input type="radio" name="rating-star" value="2"> <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><br>
                        <input type="radio" name="rating-star" value="3"> <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><br>
                        <input type="radio" name="rating-star" value="4"> <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><br>
                        <input type="radio" name="rating-star" value="5"> <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><br>
                        <br>
                        <div class="mb-3">
                            <label for="phone-number" class="form-label"><b>Số điện thoại</b></label>
                            <input type="tel" class="form-control" id="phone-number" name="phone-number" value="<?php if (isset($_SESSION["user_phone_number"])) {echo($_SESSION["user_phone_number"]);} ?>">
                        </div>
                        <div class="mb-3">
                            <label for="rating-content" class="form-label"><b>Nội dung đánh giá</b></label>
                            <textarea class="form-control" id="rating-content" name="rating-content" placeholder="Không quá 8000 ký tự"></textarea>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" id="rating-submit" name="rating-submit"><i class="bi bi-box-arrow-up"></i> Thêm đánh giá</button>
                    </div>
                </div>
            </form>   
        </div>

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