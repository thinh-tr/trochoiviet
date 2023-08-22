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
    <title>Danh sách đơn hàng</title>
</head>
<body>
    <?php
    include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php";
    include $_SERVER["DOCUMENT_ROOT"] . "/user/templates/user_header.php";
    ?>

    <!--OrderService-->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/services/order_service.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/entities/order_state.php"; ?>

    <?php
    // Truy vấn các danh mục đơn hàng của user_phone_number trên thanh search bar
    $not_confirm_order_array = array();
    $is_waiting_order_array = array();
    $is_processing_order_array = array();
    $is_finished_order_array = array();
    $is_canceled_order_array = array();

    if (isset($_POST["search-submit"])) {
        $not_confirm_order_array = \OrderService\get_not_confirm_order_by_user_phone_number($_POST["phone-number"]);
        $is_waiting_order_array = \OrderService\get_is_waiting_order_by_user_phone_number($_POST["phone-number"]);
        $is_processing_order_array = \OrderService\get_is_processing_order_by_user_phone_number($_POST["phone-number"]);
        $is_finished_order_array = \OrderService\get_is_finished_order_by_user_phone_number($_POST["phone-number"]);
        $is_canceled_order_array = \OrderService\get_is_canceled_order_by_user_phone_number($_POST["phone-number"]);
    }
    ?>

    <?php
    // Xử lý xóa các order chưa được confirm
    if (isset($_POST["delete-not-confirm"])) {
        // Kiểm tra login
        if (isset($_SESSION["user_phone_number"])) {
            $order_id_array = OrderService\get_order_ids_at_the_same_state_by_user_phone_number(OrderState\not_confirm, $_SESSION["user_phone_number"]);
            if (count($order_id_array) > 0) {
                // Nếu như tồn tại order với state được chỉ định
                foreach ($order_id_array as $order_id) {
                    OrderService\delete_order_detail_with_order_id($order_id);  // xóa order_details
                    OrderService\delete_order_with_order_id($order_id); // xóa order
                }
                echo("<script>window.alert('Đã xóa các đơn hàng chưa xác nhận')</script>");
            } else {
                echo("<script>window.alert('Không có đơn hàng nào ở trạng thái cần xóa')</script>");
            }
        } else {
            // Xuất ra thông báo yêu cầu login
            echo("<script>window.alert('Vui lòng đăng nhập để sử dụng chức năng này')</script>");
        }
    }
    ?>

    <?php
    // Xử lý xóa các đơn hàng đã bị hủy
    if (isset($_POST["delete-canceled"])) {
        if (isset($_SESSION["user_phone_number"])) {
            $order_id_array = OrderService\get_order_ids_at_the_same_state_by_user_phone_number(OrderState\canceled, $_SESSION["user_phone_number"]);
            if (count($order_id_array) > 0) {
                // Nếu như tồn tại order với state được chỉ định
                foreach ($order_id_array as $order_id) {
                    OrderService\delete_order_detail_with_order_id($order_id);  // xóa order_details
                    OrderService\delete_order_with_order_id($order_id); // xóa order
                }
                echo("<script>window.alert('Đã xóa các đơn hàng bị hủy')</script>");
            } else {
                echo("<script>window.alert('Không có đơn hàng nào ở trạng thái cần xóa')</script>");
            }
        } else {
            echo("<script>window.alert('Vui lòng đăng nhập để sử dụng chức năng này')</script>");
        }
    }
    ?>

    <!--Điều hướng-->
    <nav id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
        <div class="container-fluid">
            <a class="btn btn-primary" href="/user/user_index.php"><i class="bi bi-arrow-left"></i> Trung tâm người dùng</a>
            <form class="d-flex" role="search" method="post">
                <input class="form-control me-2" type="search" placeholder="Số điện thoại" aria-label="Search" id="phone-number" name="phone-number" value="<?php if (isset($_SESSION["user_phone_number"])) {echo($_SESSION["user_phone_number"]);} ?>">
                <button class="btn btn-outline-warning" type="submit" id="search-submit" name="search-submit"><i class="bi bi-search"></i></button>
            </form>
        </div>
    </nav>
    <div class="container" style="margin-bottom: 2cm;">
        <h3><i class="bi bi-box2"></i> <b>Danh sách đơn hàng của bạn</b></h3>

        <div class="container" style="margin-bottom: 10px;">
            <nav class="navbar bg-body-tertiary" style="margin-bottom: 5px;">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h5"><i class="bi bi-hourglass"></i> <b>Đơn hàng chưa xử lý</b></span>
                    <form class="d-flex" method="post">
                        <button class="btn btn-outline-danger" type="submit" id="delete-not-confirm" name="delete-not-confirm"><i class="bi bi-trash3-fill"></i> Xóa các đơn hàng chưa được xử lý</button>
                    </form>
                </div>
            </nav>
            <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php
            if (count($not_confirm_order_array) > 0) {
                foreach ($not_confirm_order_array as $order) {
            ?>
            <div class="col">
                <div class="card h-100" style="margin-bottom: 10px;">
                    <div class="card-header">
                        <i class="bi bi-box2-fill"></i> <small><b>Mã đơn hàng:</b> <?= $order->get_id() ?></small>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><i class="bi bi-people"></i> <b>Khách hàng:</b> <?= $order->get_user_phone_number() ?></p>
                        <p class="card-text"><i class="bi bi-person-workspace"></i> <b>Người bán:</b> <?= $order->get_admin_email() ?></p>
                        <p class="card-text"><i class="bi bi-calendar-minus"></i> <b>Ngày đặt hàng:</b> <?= date("d-m-Y", $order->get_order_date()); ?></p>
                        <p class="card-text"><i class="bi bi-info-square-fill"></i> <b>Tình trạng:</b> <?= "Chưa xử lý" ?></p>
                        <p class="card-text"><i class="bi bi-cash-coin"></i> <b>Trạng thái thanh toán:</b> <?php if ($order->get_payment_state() == 1) {echo("Đã thanh toán");} else {echo("Chưa thanh toán");} ?></p>
                    </div>
                    <div class="card-footer">
                        <a href="/user/user_order_detail.php?order-id=<?= $order->get_id() ?>" class="btn btn-primary">Chi tiết</a>
                    </div>
                </div>
            </div>
            <?php
                }
            } else {
            ?>
            <!--Thông báo không tìm thấy đơn hàng nào-->
            <div class="alert alert-warning" role="alert">
                <i class="bi bi-info-circle-fill"></i> Không tìm thấy đơn hàng nào
            </div>
            <?php
            }
            ?>
            </div>
        </div>

        <div class="container" style="margin-bottom: 10px;">
            <nav class="navbar bg-body-tertiary" style="margin-bottom: 5px;">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h5"><i class="bi bi-hourglass-top"></i> <b>Đơn hàng chờ xử lý</b></span>
                </div>
            </nav>
            <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php
            if (count($is_waiting_order_array) > 0) {
                foreach ($is_waiting_order_array as $order) {
            ?>
            <div class="col">
                <div class="card h-100" style="margin-bottom: 10px;">
                    <div class="card-header">
                        <i class="bi bi-box2-fill"></i> <small><b>Mã đơn hàng:</b> <?= $order->get_id() ?></small>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><i class="bi bi-people"></i> <b>Khách hàng:</b> <?= $order->get_user_phone_number() ?></p>
                        <p class="card-text"><i class="bi bi-person-workspace"></i> <b>Người bán:</b> <?= $order->get_admin_email() ?></p>
                        <p class="card-text"><i class="bi bi-info-square-fill"></i> <b>Tình trạng:</b> <?= "Đang chờ được xử lý" ?></p>
                        <p class="card-text"><i class="bi bi-cash-coin"></i> <b>Trạng thái thanh toán:</b> <?php if ($order->get_payment_state() == 1) {echo("Đã thanh toán");} else {echo("Chưa thanh toán");} ?></p>
                    </div>
                    <div class="card-footer">
                        <a href="/user/user_order_detail.php?order-id=<?= $order->get_id() ?>" class="btn btn-primary">Chi tiết</a>
                    </div>
                </div>
            </div>
            <?php
                }
            } else {
            ?>
            <!--Thông báo không tìm thấy đơn hàng nào-->
            <div class="alert alert-warning" role="alert">
                <i class="bi bi-info-circle-fill"></i> Không tìm thấy đơn hàng nào
            </div>
            <?php
            }
            ?>
            </div>
        </div>

        <div class="container" style="margin-bottom: 10px;">
            <nav class="navbar bg-body-tertiary" style="margin-bottom: 5px;">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h5"><i class="bi bi-hourglass-split"></i> <b>Đơn hàng đang xử lý</b></span>
                </div>
            </nav>
            <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php
            if (count($is_processing_order_array) > 0) {
                foreach ($is_processing_order_array as $order) {
            ?>
            <div class="col">
                <div class="card h-100" style="margin-bottom: 10px;">
                    <div class="card-header">
                        <i class="bi bi-box2-fill"></i> <small><b>Mã đơn hàng:</b> <?= $order->get_id() ?></small>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><i class="bi bi-people"></i> <b>Khách hàng:</b> <?= $order->get_user_phone_number() ?></p>
                        <p class="card-text"><i class="bi bi-person-workspace"></i> <b>Người bán:</b> <?= $order->get_admin_email() ?></p>
                        <p class="card-text"><i class="bi bi-info-square-fill"></i> <b>Tình trạng:</b> <?= "Đang được xử lý" ?></p>
                        <p class="card-text"><i class="bi bi-cash-coin"></i> <b>Trạng thái thanh toán:</b> <?php if ($order->get_payment_state() == 1) {echo("Đã thanh toán");} else {echo("Chưa thanh toán");} ?></p>
                    </div>
                    <div class="card-footer">
                        <a href="/user/user_order_detail.php?order-id=<?= $order->get_id() ?>" class="btn btn-primary">Chi tiết</a>
                    </div>
                </div>
            </div>
            <?php
                }
            } else {
            ?>
            <!--Thông báo không tìm thấy đơn hàng nào-->
            <div class="alert alert-warning" role="alert">
                <i class="bi bi-info-circle-fill"></i> Không tìm thấy đơn hàng nào
            </div>
            <?php
            }
            ?>
            </div>
        </div>

        <div class="container" style="margin-bottom: 10px;">
            <nav class="navbar bg-body-tertiary" style="margin-bottom: 5px;">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h5"><i class="bi bi-check2-circle"></i> <b>Đơn hàng đã hoàn tất</b></span>
                </div>
            </nav>
            <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php
            if (count($is_finished_order_array) > 0) {
                foreach ($is_finished_order_array as $order) {
            ?>
            <div class="col">
                <div class="card h-100" style="margin-bottom: 10px;">
                    <div class="card-header">
                        <i class="bi bi-box2-fill"></i> <small><b>Mã đơn hàng:</b> <?= $order->get_id() ?></small>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><i class="bi bi-people"></i> <b>Khách hàng:</b> <?= $order->get_user_phone_number() ?></p>
                        <p class="card-text"><i class="bi bi-person-workspace"></i> <b>Người bán:</b> <?= $order->get_admin_email() ?></p>
                        <p class="card-text"><i class="bi bi-info-square-fill"></i> <b>Tình trạng:</b> <?= "Đã hoàn tất" ?></p>
                        <p class="card-text"><i class="bi bi-cash-coin"></i> <b>Trạng thái thanh toán:</b> <?php if ($order->get_payment_state() == 1) {echo("Đã thanh toán");} else {echo("Chưa thanh toán");} ?></p>
                    </div>
                    <div class="card-footer">
                        <a href="/user/user_order_detail.php?order-id=<?= $order->get_id() ?>" class="btn btn-primary">Chi tiết</a>
                    </div>
                </div>
            </div>
            <?php
                }
            } else {
            ?>
            <!--Thông báo không tìm thấy đơn hàng nào-->
            <div class="alert alert-warning" role="alert">
                <i class="bi bi-info-circle-fill"></i> Không tìm thấy đơn hàng nào
            </div>
            <?php
            }
            ?>
            </div>
        </div>

        <div class="container" style="margin-bottom: 10px;">
            <nav class="navbar bg-body-tertiary" style="margin-bottom: 5px;">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h5"><i class="bi bi-x-circle"></i> <b>Đơn hàng đã bị hủy</b></span>
                    <form class="d-flex" method="post">
                        <button class="btn btn-outline-danger" type="submit" id="delete-canceled" name="delete-canceled"><i class="bi bi-trash3-fill"></i> Xóa các đơn hàng đã bị hủy</button>
                    </form>
                </div>
            </nav>
            <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php
            if (count($is_canceled_order_array) > 0) {
                foreach ($is_canceled_order_array as $order) {
            ?>
            <div class="col">
                <div class="card h-100" style="margin-bottom: 10px;">
                    <div class="card-header">
                        <i class="bi bi-box2-fill"></i> <small><b>Mã đơn hàng:</b> <?= $order->get_id() ?></small>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><i class="bi bi-people"></i> <b>Khách hàng:</b> <?= $order->get_user_phone_number() ?></p>
                        <p class="card-text"><i class="bi bi-person-workspace"></i> <b>Người bán:</b> <?= $order->get_admin_email() ?></p>
                        <p class="card-text"><i class="bi bi-info-square-fill"></i> <b>Tình trạng:</b> <?= "Đã hủy" ?></p>
                        <p class="card-text"><i class="bi bi-cash-coin"></i> <b>Trạng thái thanh toán:</b> <?php if ($order->get_payment_state() == 1) {echo("Đã thanh toán");} else {echo("Chưa thanh toán");} ?></p>
                    </div>
                    <div class="card-footer">
                        <a href="/user/user_order_detail.php?order-id=<?= $order->get_id() ?>" class="btn btn-primary">Chi tiết</a>
                    </div>
                </div>
            </div>
            <?php
                }
            } else {
            ?>
            <!--Thông báo không tìm thấy đơn hàng nào-->
            <div class="alert alert-warning" role="alert">
                <i class="bi bi-info-circle-fill"></i> Không tìm thấy đơn hàng nào
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