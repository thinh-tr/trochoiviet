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
            <h5><i class="bi bi-hourglass"></i> <b>Đơn hàng chưa xử lý</b></h5>
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
                        <p class="card-text"><i class="bi bi-cash-coin"></i> <b>Trạng thái thanh toán:</b> <?php if ($order->get_payment_state == 1) {echo("Đã thanh toán");} else {echo("Chưa thanh toán");} ?></p>
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
            <h5><i class="bi bi-hourglass-top"></i> <b>Đơn hàng chờ xử lý</b></h5>
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
                        <p class="card-text"><i class="bi bi-cash-coin"></i> <b>Trạng thái thanh toán:</b> <?php if ($order->get_payment_state == 1) {echo("Đã thanh toán");} else {echo("Chưa thanh toán");} ?></p>
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
            <h5><i class="bi bi-hourglass-split"></i> <b>Đơn hàng đang xử lý</b></h5>
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
                        <p class="card-text"><i class="bi bi-cash-coin"></i> <b>Trạng thái thanh toán:</b> <?php if ($order->get_payment_state == 1) {echo("Đã thanh toán");} else {echo("Chưa thanh toán");} ?></p>
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
            <h5><i class="bi bi-check2-circle"></i> <b>Đơn hàng đã hoàn tất</b></h5>
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
                        <p class="card-text"><i class="bi bi-cash-coin"></i> <b>Trạng thái thanh toán:</b> <?php if ($order->get_payment_state == 1) {echo("Đã thanh toán");} else {echo("Chưa thanh toán");} ?></p>
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
            <h5><i class="bi bi-x-circle"></i> <b>Đơn hàng đã bị hủy</b></h5>
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
                        <p class="card-text"><i class="bi bi-cash-coin"></i> <b>Trạng thái thanh toán:</b> <?php if ($order->get_payment_state == 1) {echo("Đã thanh toán");} else {echo("Chưa thanh toán");} ?></p>
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