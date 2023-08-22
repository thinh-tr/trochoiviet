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
    <title>Quản lý đơn hàng</title>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/admin/templates/admin_header.php"; ?>

    <?php
    include $_SERVER["DOCUMENT_ROOT"] . "/services/order_service.php";
    include $_SERVER["DOCUMENT_ROOT"] . "/entities/order_state.php";
    ?>

    <?php
    // Truy vấn các danh mục đơn hàng của user_phone_number trên thanh search bar
    $admin_is_waiting_order_array = array();
    $admin_is_received_order_array = array();
    $admin_is_shipping_order_array = array();
    $admin_is_finished_order_array = array();
    $admin_is_canceled_order_array = array();

    if (isset($_SESSION["admin_email"])) {
        $admin_is_waiting_order_array = OrderService\get_orders_by_admin_email_and_state($_SESSION["admin_email"], OrderState\waiting);
        $admin_is_received_order_array = OrderService\get_orders_by_admin_email_and_state($_SESSION["admin_email"], OrderState\received);
        $admin_is_shipping_order_array = OrderService\get_orders_by_admin_email_and_state($_SESSION["admin_email"], OrderState\shipping);
        $admin_is_finished_order_array = OrderService\get_orders_by_admin_email_and_state($_SESSION["admin_email"], OrderState\finished);
        $admin_is_canceled_order_array = OrderService\get_orders_by_admin_email_and_state($_SESSION["admin_email"], OrderState\canceled);
    }
    ?>

    <?php
    // Xử lý xóa các đơn hàng đã hoàn tất
    if (isset($_POST["delete-finished"])) {
        $order_id_array = OrderService\get_order_ids_at_the_same_state_by_admin_email(OrderState\finished, $_SESSION["admin_email"]);
        if (count($order_id_array) > 0) {
            // Nếu như tồn tại order với state được chỉ định
            foreach ($order_id_array as $order_id) {
                OrderService\delete_order_detail_with_order_id($order_id);  // xóa order_details
                OrderService\delete_order_with_order_id($order_id); // xóa order
            }
            echo("<script>window.alert('Đã xóa các đơn hàng thành công')</script>");
        } else {
            echo("<script>window.alert('Không có đơn hàng nào ở trạng thái cần xóa')</script>");
        }
    }
    ?>

    <?php
    // Xử lý xóa các đơn hàng đã hủy
    if (isset($_POST["delete-canceled"])) {
        $order_id_array = OrderService\get_order_ids_at_the_same_state_by_admin_email(OrderState\canceled, $_SESSION["admin_email"]);
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
    }
    ?>

    <!--Điều hướng-->
    <nav id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
        <div class="container-fluid">
            <a class="btn btn-primary" href="/admin/admin_index.php"><i class="bi bi-arrow-left"></i> Trang quản trị</a>
            <ul class="nav nav-bills">
                <li class="nav-item">
                    <form method="post">
                        <button class="btn btn-info" name="refresh"><i class="bi bi-arrow-counterclockwise"></i> Làm mới</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin-bottom: 2cm;">
        <h3><i class="bi bi-box2"></i> <b>Quản lý đơn hàng</b></h3>
        <!--Kiểm tra login trước khi hiển thị-->
        <?php
        if (isset($_SESSION["admin_email"])) {
            // Nếu có login -> lần lượt hiển thị các đơn hàng theo danh mục
        ?>
        <div class="container" style="margin-bottom: 10px;">
            <nav class="navbar bg-body-tertiary" style="margin-bottom: 5px;">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h5"><i class="bi bi-hourglass-top"></i> <b>Đơn hàng chờ xử lý</b></span>
                </div>
            </nav>
            <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php
            if (count($admin_is_waiting_order_array) > 0) {
                foreach ($admin_is_waiting_order_array as $order) {
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
                        <a href="/admin/admin_order_detail.php?order-id=<?= $order->get_id() ?>" class="btn btn-primary">Chi tiết</a>
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
                    <span class="navbar-brand mb-0 h5"><i class="bi bi-check2-circle"></i> <b>Đơn hàng đã xác nhận</b></span>
                </div>
            </nav>
            <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php
            if (count($admin_is_received_order_array) > 0) {
                foreach ($admin_is_received_order_array as $order) {
            ?>
            <div class="col">
                <div class="card h-100" style="margin-bottom: 10px;">
                    <div class="card-header">
                        <i class="bi bi-box2-fill"></i> <small><b>Mã đơn hàng:</b> <?= $order->get_id() ?></small>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><i class="bi bi-people"></i> <b>Khách hàng:</b> <?= $order->get_user_phone_number() ?></p>
                        <p class="card-text"><i class="bi bi-person-workspace"></i> <b>Người bán:</b> <?= $order->get_admin_email() ?></p>
                        <p class="card-text"><i class="bi bi-info-square-fill"></i> <b>Tình trạng:</b> <?= "Đã xác nhận" ?></p>
                        <p class="card-text"><i class="bi bi-cash-coin"></i> <b>Trạng thái thanh toán:</b> <?php if ($order->get_payment_state() == 1) {echo("Đã thanh toán");} else {echo("Chưa thanh toán");} ?></p>
                    </div>
                    <div class="card-footer">
                        <a href="/admin/admin_order_detail.php?order-id=<?= $order->get_id() ?>" class="btn btn-primary">Chi tiết</a>
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
                    <span class="navbar-brand mb-0 h5"><i class="bi bi-truck"></i> <b>Đơn hàng đang vận chuyển</b></span>
                </div>
            </nav>
            <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php
            if (count($admin_is_shipping_order_array) > 0) {
                foreach ($admin_is_shipping_order_array as $order) {
            ?>
            <div class="col">
                <div class="card h-100" style="margin-bottom: 10px;">
                    <div class="card-header">
                        <i class="bi bi-box2-fill"></i> <small><b>Mã đơn hàng:</b> <?= $order->get_id() ?></small>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><i class="bi bi-people"></i> <b>Khách hàng:</b> <?= $order->get_user_phone_number() ?></p>
                        <p class="card-text"><i class="bi bi-person-workspace"></i> <b>Người bán:</b> <?= $order->get_admin_email() ?></p>
                        <p class="card-text"><i class="bi bi-info-square-fill"></i> <b>Tình trạng:</b> <?= "Đang vận chuyển" ?></p>
                        <p class="card-text"><i class="bi bi-cash-coin"></i> <b>Trạng thái thanh toán:</b> <?php if ($order->get_payment_state() == 1) {echo("Đã thanh toán");} else {echo("Chưa thanh toán");} ?></p>
                    </div>
                    <div class="card-footer">
                        <a href="/admin/admin_order_detail.php?order-id=<?= $order->get_id() ?>" class="btn btn-primary">Chi tiết</a>
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
                    <span class="navbar-brand mb-0 h5"><i class="bi bi-check2-square"></i> <b>Đơn hàng đã hoàn tất</b></span>
                    <form class="d-flex" method="post">
                        <button class="btn btn-outline-danger" type="submit" id="delete-finished" name="delete-finished"><i class="bi bi-trash3-fill"></i> Xóa các đơn hàng đã hoàn tất</button>
                    </form>
                </div>
            </nav>
            <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php
            if (count($admin_is_finished_order_array) > 0) {
                foreach ($admin_is_finished_order_array as $order) {
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
                        <a href="/admin/admin_order_detail.php?order-id=<?= $order->get_id() ?>" class="btn btn-primary">Chi tiết</a>
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
                    <span class="navbar-brand mb-0 h5"><i class="bi bi-x-circle"></i> <b>Đơn hàng đã hủy</b></span>
                    <form class="d-flex" method="post">
                        <button class="btn btn-outline-danger" type="submit" id="delete-canceled" name="delete-canceled"><i class="bi bi-trash3-fill"></i> Xóa các đơn hàng đã hủy</button>
                    </form>
                </div>
            </nav>
            <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php
            if (count($admin_is_canceled_order_array) > 0) {
                foreach ($admin_is_canceled_order_array as $order) {
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
                        <a href="/admin/admin_order_detail.php?order-id=<?= $order->get_id() ?>" class="btn btn-primary">Chi tiết</a>
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

        <?php
        } else {
            // Nếu không có login
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