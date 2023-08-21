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
    <title>Chi tiết đơn hàng</title>
</head>
<body>
    <?php
    include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php";
    include $_SERVER["DOCUMENT_ROOT"] . "/user/templates/user_header.php";
    ?>
    <!--OrderService-->
    <?php
    include $_SERVER["DOCUMENT_ROOT"] . "/services/order_service.php";
    include $_SERVER["DOCUMENT_ROOT"] . "/services/product_service.php";
    include $_SERVER["DOCUMENT_ROOT"] . "/services/admin_service.php";
    include $_SERVER["DOCUMENT_ROOT"] . "/entities/order_state.php";
    ?>


    <?php
    // Lấy ra thông tin của đơn hàng được chỉ định
    $order = null;
    $order_detail_array = array();
    $admin_qr_code = null;
    $payment_check_value = 0;
    if (isset($_GET["order-id"])) {
        $order = OrderService\get_order_by_order_id($_GET["order-id"]);
        $order_detail_array = OrderService\get_order_details_by_order_id($_GET["order-id"]);
        $admin_qr_code = AdminServices\get_qr_code_by_admin_email($order->get_admin_email());
    }
    ?>

    <?php
    if (isset($_POST["payment-check"])) {
        $payment_check_value = intval($_POST["payment-check"]);
    }
    ?>

    <?php
    // Xử lý xác nhận order
    if (isset($_POST["order-submit"])) {
        // Nếu có lệnh xác nhận order
        // Kiểm tra trạng thái order
        if ($order->get_state() == OrderState\not_confirm) {
            // Chỉ có thể xác nhận đơn hàng nếu đang ở trạng thái not_confirm
            // Kiểm tra địa chỉ giao hàng
            if (strlen($_POST["order-delivery-address"]) >= 10) {
                // // Tiến hàng xác nhận order

                // Cập nhật trạng thái order sang 'is_waitting'
                OrderService\update_order_state($order->get_id(), OrderState\waiting);

                // Cập nhật delivery_address
                OrderService\update_order_delivery_address($order->get_id(), $_POST["order-delivery-address"]);

                // Cập nhật trạng thái thanh toán
                // Kiểm tra tùy chọn thanh toán
                OrderService\update_order_payment_state($order->get_id(), $payment_check_value);

                // Thông báo xác nhận order thành công
                echo(<<<END
                    <div class="alert alert-success" role="alert">
                    Đã xác nhận đơn hàng thành công
                    </div>              
                    END);
            } else {
                // Thông báo address chưa chính xác
                echo("<script>window.alert('Vui lòng kiểm tra lại địa chỉ giao hàng của bạn')</script>");
            }
        } else {
            echo("<script>window.alert('Hiện tại không thể xác nhận đơn hàng này')</script>");
        }
    }
    ?>

    <?php
    // Xử lý hủy order (Chuyển trạng thái của order sang "is_canceled")
    if (isset($_POST["order-cancel"])) {
        // Kiểm tra trạng thái order (Chỉ có thể hủy nếu order ở trạng thái "not_confirm", "is_waiting", "is_received")
        if ($order->get_state() == OrderState\not_confirm || $order->get_state() == OrderState\waiting || $order->get_state() == OrderState\received) {
            OrderService\update_order_state($order->get_id(), OrderState\canceled); // Chuyển trạng thái order sang canceled
            echo("<script>window.alert('Đã hủy đơn hàng')</script>");
        } else {
            echo("<script>window.alert('Không thể hủy đơn hàng này')</script>");
        }
    }
    ?>

    <nav id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
        <a class="btn btn-primary" href="/user/user_order_list.php"><i class="bi bi-arrow-left"></i> Danh sách đơn hàng</a>
    </nav>
    <div class="container" style="margin-bottom: 2cm;">
        <div class="container">
            <div class="alert alert-warning" role="alert">
                <i class="bi bi-info-circle-fill"></i> Lưu ý, đơn hàng của bạn có thể sẽ bị hủy nếu người bán không thể xác định được địa chỉ giao hàng mà bạn cung cấp
            </div>
            <form method="post">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"><i class="bi bi-box2"></i> <b>Thông tin đơn hàng: <?= $order->get_id() ?></b></h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="order-id" class="form-label"><i class="bi bi-upc-scan"></i> <b>Mã đơn hàng</b></label>
                            <input type="text" class="form-control" id="order-id" name="order-id" value="<?= $order->get_id() ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="order-state" class="form-label"><i class="bi bi-info-circle-fill"></i> <b>Trạng thái đơn hàng</b></label>
                            <input type="text" class="form-control" id="order-state" name="order-state" value="<?php
                                if ($order->get_state() == OrderState\not_confirm) {
                                    echo("Chưa xác nhận");
                                } else if ($order->get_state() == OrderState\waiting) {
                                    echo("Đang chờ xử lý");
                                } else if ($order->get_state() == OrderState\received) {
                                    echo("Đã xác nhận");
                                } else if ($order->get_state() == OrderState\shipping) {
                                    echo("Đang vận chuyển");
                                } else if ($order->get_state() == OrderState\finished) {
                                    echo("Đã hoàn tất");
                                } else if ($order->get_state() == OrderState\canceled) {
                                    echo("Đã hủy");
                                }
                            ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="order-payment-state" class="form-label"><i class="bi bi-cash-coin"></i> <b>Trạng thái thanh toán</b></label>
                            <input type="text" class="form-control" id="order-payment-state" name="order-payment-state" value="<?php if ($order->get_payment_state() == 1) {echo("Đã thanh toán");} else {echo("Chưa thanh toán");} ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="order-order-date" class="form-label"><i class="bi bi-calendar"></i> <b>Ngày đặt hàng</b></label>
                            <input type="text" class="form-control" id="order-order-date" name="order-order-date" value="<?= date("d-m-Y", $order->get_order_date()) ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="order-delivery-date" class="form-label"><i class="bi bi-calendar"></i> <b>Ngày giao hàng</b></label>
                            <input type="text" class="form-control" id="order-delivery-date" name="order-delivery-date" value="<?php
                                if ($order->get_delivery_date() != 0) {
                                    echo(date("d-m-Y", $order->get_delivery_date()));
                                } else {
                                    echo("Chưa xác định");
                                }                                    
                            ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="order-delivery-address" class="form-label"><i class="bi bi-house"></i> <b>Địa chỉ giao hàng</b> (giữ nguyên trường này nếu như địa chỉ đã chính xác)</label>
                            <input type="text" class="form-control" id="order-delivery-address" name="order-delivery-address" placeholder="Từ 10 ký tự trở lên" value="<?= $order->get_delivery_address() ?>">
                        </div>
                        <div class="mb-3">
                            <label for="order-user-phone-number" class="form-label"><i class="bi bi-telephone-fill"></i> <b>Số điện thoại người nhận</b></label>
                            <input type="text" class="form-control" id="order-user-phone-number" name="order-user-phone-number" value="<?= $order->get_user_phone_number() ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="order-admin_email" class="form-label"><i class="bi bi-envelope-fill"></i> <b>Email người bán</b></label>
                            <input type="text" class="form-control" id="order-admin-email" name="order-admin-email" value="<?= $order->get_admin_email() ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <?php
                            $order_total_price = 0;
                            ?>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title"><i class="bi bi-info-circle"></i> <b>Chi tiết đơn hàng</b></h5>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <!--table hiển thị chi tiết các sản phẩm trong đơn hàng-->
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Mã sản phẩm</th>
                                                <th scope="col">Tên sản phẩm</th>
                                                <th scope="col">Đơn giá</th>
                                                <th scope="col">Số lượng</th>
                                                <th scope="col">Tổng giá</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            for ($i = 0; $i < count($order_detail_array); $i++) {
                                                $product = \ProductService\get_product_by_product_id($order_detail_array[$i]->get_product_id());
                                            ?>
                                            <tr>
                                                <th scope="row"><?= $i + 1 ?></th>
                                                <td><?= $order_detail_array[$i]->get_product_id() ?></td>
                                                <td><?= $product->get_name() ?></td>
                                                <td><?= $order_detail_array[$i]->get_retail_price() ?> VNĐ</td>
                                                <td><?= $order_detail_array[$i]->get_product_quantity() ?></td>
                                                <td><?= $order_detail_array[$i]->get_total_price() ?> VNĐ</td>
                                                <?php
                                                // Tính tổng giá trị đơn hàng
                                                $order_total_price += $order_detail_array[$i]->get_total_price();
                                                ?>
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer">
                                    <h5 class="card-text">Tổng giá trị đơn hàng: <b><?= $order_total_price ?> VNĐ</b></h5>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title"><i class="bi bi-cash-coin"></i> <b> Thanh toán</b></h5>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-info" role="alert">
                                        <i class="bi bi-info-circle-fill"></i> Thanh toán bằng ví điện tử thông qua mã QR hiển thị bên dưới
                                    </div>
                                    <div class="alert alert-danger" role="alert">
                                        <i class="bi bi-exclamation-triangle-fill"></i> Chỉ thực hiện thanh toán qua ví điện tử khi mã QR được hiển thị đầy đủ, nếu không hãy chọn cách thanh toán khác
                                    </div>
                                    <small><i class="bi bi-qr-code"></i> <b>Thanh toán bằng cách quét mã QR dưới đây thông qua ứng dụng ví điện tử tương ứng</b></small><br>
                                    <?php
                                    // Lấy ra thông tin admin
                                    if ($admin_qr_code != null) {
                                    ?>
                                    <img src="<?= $admin_qr_code->get_qr_code_link() ?>" class="img-thumbnail" alt="...">
                                    <?php
                                    } else {
                                    ?>
                                    <img src="#" class="img-thumbnail" alt="...">
                                    <?php
                                    }
                                    ?>
                                    <p class="card-text"><i class="bi bi-info-circle-fill"></i> Nội dung thanh toán: <b>Mã đơn hàng - Số điện thoại của bạn</b> (Số tiền thanh toán bằng với tổng giá trị đơn hàng được hiển thị bên trên)</p>
                                    <p class="card-text"><i class="bi bi-info-circle-fill"></i> Nếu bạn đã thực hiện thanh toán qua ví điện tử thì hãy click vào nút xác nhận bên dưới trước khi bấm xác nhận đơn hàng</p>
                                </div>
                                <div class="card-footer">
                                    <input type="radio" name="payment-check" value="1"> Đã thanh toán qua ví điện tử<br>
                                    <input type="radio" name="payment-check" value="0"> Thanh toán khi nhận hàng
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" id="order-submit" name="order-submit"><i class="bi bi-bag-check"></i> Xác nhận đơn hàng</button>
                        <button class="btn btn-warning" id="order-cancel" name="order-cancel"><i class="bi bi-x-circle"></i>  Hủy đơn hàng</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php"; ?>
</body>
</html>