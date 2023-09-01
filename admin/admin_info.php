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
    <title>Trang thông tin quản trị viên</title>
    <style>
        #header {
            position: sticky;
            top: 0;
            z-index: 999;
        }

        div.container {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .register-form {
            margin-left: 20%;
            margin-right: 20%;
        }

        .mb-3 button {
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <div id="header">
        <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php" ?> <!--Header-->
        <?php include $_SERVER["DOCUMENT_ROOT"] . "/admin/templates/admin_header.php" ?> <!--admin header-->

        <!--Điều hướng-->
        <nav id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
            <a class="btn btn-primary" href="/admin/admin_index.php"><i class="bi bi-arrow-left"></i> Trang quản trị</a>
        </nav>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/services/admin_service.php"; //Nhập vào file admin service 
    ?>

    <?php
    // Lấy ra thông tin admin đang login
    $admin = null;
    $qr_code = null;
    // Kiểm tra trạng thái đăng nhập
    if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION["admin_email"])) {
        // Có tồn tại tài khoản login và tiến hành truy vấn thông tin tài khoản từ database
        $admin = AdminServices\get_admin_info_by_email($_SESSION["admin_email"]);
        $qr_code = AdminServices\get_qr_code_by_admin_email($_SESSION["admin_email"]);
    }
    ?>

    <!--Cập nhật thông tin-->
    <?php
    if (isset($_POST["submit"])) {
        // Kiểm tra trạng thái đăng nhập
        if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION["admin_email"])) {
            // Có tài khoản đăng nhập, tiến hành update thông tin
            $update_info_array = array();

            // Kiểm tra qua các trường cần update -> hợp lệ sẽ được thêm vào array

            // name
            if (strlen($_POST["name"]) >= 2) {
                $update_info_array["name"] = $_POST["name"];
            }

            // phone_number
            if ($_POST["phone-number"] != "") { // Nếu phone_number không rỗng
                if (is_numeric($_POST["phone-number"]) && strlen($_POST["phone-number"]) <= 12) {
                    $update_info_array["phone_number"] = $_POST["phone-number"];
                }
            } else {
                $update_info_array["phone_number"] = "";
            }

            // selt_intro
            $update_info_array["self_intro"] = $_POST["self-intro"] ?? "";

            // Kiểm tra lại array
            $is_valid_array = true;
            if (!array_key_exists("name", $update_info_array)) {
                $is_valid_array = false;
            } else if (!array_key_exists("phone_number", $update_info_array)) {
                $is_valid_array = false;
            }

            // Update khi array hợp lệ
            if ($is_valid_array) {
                // tiến hành update khi thông tin đã hợp lệ
                AdminServices\update_admin_info($_SESSION["admin_email"], $update_info_array["name"], $update_info_array["phone_number"], $update_info_array["self_intro"]);
                // Cập nhật lại thông tin lên form
                $admin = AdminServices\get_admin_info_by_email($_SESSION["admin_email"]);
                echo(<<<END
                    <div class="alert alert-success" role="alert">
                        <h5>Đã cập nhật thông tin quản trị viên "{$_SESSION["admin_email"]}"</h5>
                    </div>
                    END);
            } else {
                // Yêu cầu kiểm tra lại thông tin
                echo ("<script>window.alert('Vui lòng kiểm tra lại thông tin của bạn');</script>");
            }
        } else {
            echo(<<<END
                <div class="alert alert-warning" role="alert">
                    <h5>Bạn vẫn chưa đăng nhập</h5>
                </div>          
                END);
        }
    }
    ?>

    <!--Đăng xuất-->
    <?php
    // Đăng xuất tài khoản
    if (isset($_POST["btn-logout"])) {
        // Kiểm tra trạng thái login
        if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION["admin_email"])) {
            // Xóa biến admin_email trong session và hủy session
            unset($_SESSION["admin_email"]);
            // xóa trống form
            $admin = null;
            echo(<<<END
                <div class="alert alert-primary" role="alert">
                    <h5>Đã đăng xuất</h5>
                </div>
                END);
        } else {
            echo(<<<END
                <div class="alert alert-warning" role="alert">
                    <h5>Bạn vẫn chưa đăng nhập</h5>
                </div>
                END);
        }
    }
    ?>

    <?php
    // Xử lý thêm QR Code
    if (isset($_POST["qr-code-submit"])) {
        // Kiểm tra login
        if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION["admin_email"])) {
            // Xóa các qr code của admin này nếu chúng tồn tại
            AdminServices\delete_qr_code_by_admin_email($_SESSION["admin_email"]);
            // Tiến hành thêm
            $new_qr_code = new \Entities\QRCode();
            $new_qr_code->set_id(uniqid());
            $new_qr_code->set_admin_email($_SESSION["admin_email"]);
            $new_qr_code->set_qr_code_link($_POST["qr-code-link"]);
            AdminServices\create_qr_code_link($new_qr_code);
            //Thông báo thêm thành công
            echo(<<<END
                <div class="alert alert-success" role="alert">
                    Đã tạo thành công QR code của bạn
                </div>              
                END);
        } else {
            echo("<script>window.alert('Vui lòng đăng nhập vào tài khoản quản trị để thêm QR code')</script>");
        }
    }
    ?>

    
    <!--form thông tin quản trị viên-->
    <div class="container">
        <h3 style="text-align: center;"><b>Thông tin quản trị viên</b></h3><br>
        <form class="register-form" method="post">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label"><i class="bi bi-envelope-fill"></i> <b>Địa chỉ email *</b></label>
                <input type="email" class="form-control" id="email" name="email" disabled value="<?php if ($admin != null) {
                                                                                                        echo ($admin->get_email());
                                                                                                    } ?>">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label"><i class="bi bi-key-fill"></i> <b>Mật khẩu *</b></label>
                <input type="password" class="form-control" id="password" name="password" disabled value="<?php if ($admin != null) {
                                                                                                                echo ($admin->get_password());
                                                                                                            } ?>">
            </div>
            <div class="mb-3">
                <a class="btn btn-info" href="/admin/admin_update_password.php"><i class="bi bi-file-earmark-lock2-fill"></i> Đổi mật khẩu</a>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label"><i class="bi bi-info-circle-fill"></i> <b>Họ tên *</b></label>
                <input type="text" class="form-control" id="name" name="name" placeholder="không it hơn 2 ký tự" value="<?php if ($admin != null) {
                                                                                                                            echo ($admin->get_name());
                                                                                                                        } ?>">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label"><i class="bi bi-telephone-fill"></i> <b>Số điện thoại</b></label>
                <input type="tel" class="form-control" id="phone-number" name="phone-number" value="<?php if ($admin != null) {
                                                                                                        echo ($admin->get_phone_number());
                                                                                                    } ?>">


            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label"><i class="bi bi-calendar-check-fill"></i> <b>Ngày tham gia *</b></label>
                <input type="tel" class="form-control" id="join-date" name="join-date" disabled value="<?php if ($admin != null) {
                                                                                                            echo (date("d-m-y", $admin->get_join_date()));
                                                                                                        } ?>">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label"><i class="bi bi-info-circle-fill"></i> <b>Tự giới thiệu</b></label>
                <textarea class="form-control" id="self-intro" rows="3" name="self-intro" placeholder="Viết vài dòng giới thiệu về bản thân bạn" name="self-intro"><?php if ($admin != null) {
                                                                                                                                                                        echo ($admin->get_self_intro());
                                                                                                                                                                    } ?></textarea>
            </div>
            <div class="mb-3">
                <div class="card">
                    <div class="card-header">
                        <small><i class="bi bi-info-circle-fill"></i> Thêm QR code của bạn tại đây (Hình ảnh QR CODE sẽ được hiển thị bên dưới nến đường dẫn là chính xác)</small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="qr-code-link" class="form-label"><i class="bi bi-qr-code"></i> <b>QR code cho thanh toán qua ví điện tử</b></label>
                            <input type="text" class="form-control" id="qr-code-link" name="qr-code-link" placeholder="Link QR code">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" id="qr-code-submit" name="qr-code-submit"><i class="bi bi-box-arrow-up"></i> Thêm QR code</button>
                    </div>
                </div>
            </div>                                                                                                                                                        
            <div class="mb-3">
                <div class="alert alert-info" role="alert">
                    <i class="bi bi-info-circle-fill"></i> Chỉ có thể sử dụng duy nhất 1 QR code tại cùng thời điểm
                </div>
                <div class="card">
                    <div class="card-header">
                        <small><i class="bi bi-info-circle-fill"></i> QR code của bạn</small>
                    </div>
                    <div class="card-body">
                        <?php
                        if ($qr_code != null) {
                        ?>
                        <img src="<?= $qr_code->get_qr_code_link() ?>" class="img-thumbnail" alt="..." style="width: 40%;">
                        <?php
                        } else {
                        ?>
                        <div class="alert alert-warning" role="alert">
                            <i class="bi bi-info-circle-fill"></i> Hiện tại không có thông tin về QR code
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary" name="submit" value="submit"><i class="bi bi-save-fill"></i> Lưu thay đổi</button>
                <button type="submit" class="btn btn-secondary"><i class="bi bi-arrow-clockwise"></i> Làm mới</button>
                <button type="submit" class="btn btn-warning" name="btn-logout" value="submit"><i class="bi bi-box-arrow-right"></i> Đăng xuất</button>
            </div>
        </form>
    </div>


    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php" ?>
</body>

</html>