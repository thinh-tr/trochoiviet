<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <title>Trang thông tin quản trị viên</title>
    <style>
        div.container {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .register-form {
            margin-left: 20%;
            margin-right: 20%;
        }
    </style>
</head>

<body>
    <?php include "../templates/header.php" ?> <!--Header-->
    <?php include "./templates/admin_header.php" ?> <!--admin header-->

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/trochoiviet/services/admin_service.php"; //Nhập vào file admin service ?>

    <?php
    // Lấy ra thông tin admin đang login
    $admin = null;
    // Kiểm tra trạng thái đăng nhập
    if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION["admin_email"])) {
        // Có tồn tại tài khoản login và tiến hành truy vấn thông tin tài khoản từ database
        $admin = \AdminServices\get_admin_info_by_email($_SESSION["admin_email"]);
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
                if (\AdminServices\update_admin_info($_SESSION["admin_email"], $update_info_array["name"], $update_info_array["phone_number"], $update_info_array["self_intro"])) {
                    echo( <<<END
                                <div style="background-color: rgb(102, 242, 106); width: 100%; height: 15%; text-align: center; color: white; padding: 10px;">
                                    <h5>Đã cập nhật thông tin quản trị viên "{$_SESSION["admin_email"]}"</h5>
                                </div>
                            END);
                }
            } else {
                // Yêu cầu kiểm tra lại thông tin
                echo("<script>window.alert('Vui lòng kiểm tra lại thông tin của bạn');</script>");
            }

        } else {
            echo (<<<END
                    <div style="background-color: rgb(255, 219, 59); width: 100%; height: 15%; text-align: center; color: white; padding: 10px;">
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
            session_destroy();  // hủy session
            // xóa trống form
            $admin = null;

            // Hiển thị thông báo đã logout
            echo (<<<END
                <div style="background-color: rgb(102, 242, 106); width: 100%; height: 15%; text-align: center; color: white; padding: 10px;">
                <h5>Đã đăng xuất</h5>
                </div>
                END
            );
        } else {
            // Trong trường hợp vẫn chưa có đăng nhập
            echo (<<<END
                <div style="background-color: rgb(255, 219, 59); width: 100%; height: 15%; text-align: center; color: white; padding: 10px;">
                <h5>Bạn vẫn chưa đăng nhập</h5>
                </div>
                END
            );
        }
    }
    ?>

    <!--form đăng ký quản trị viên-->
    <div class="container">
        <h3 style="text-align: center;"><b>Thông tin quản trị viên</b></h3><br>
        <form class="register-form" method="post">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Địa chỉ email *</label>
                <input type="email" class="form-control" id="email" name="email" disabled value="<?php if ($admin != null) {
                                                                                                        echo ($admin->get_email());
                                                                                                    } ?>">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Mật khẩu *</label>
                <input type="password" class="form-control" id="password" name="password" disabled value="<?php if ($admin != null) {
                                                                                                            echo ($admin->get_password());
                                                                                                        } ?>">
            </div>
            <div class="mb-3">
                <a class="btn btn-info" href="/trochoiviet/admin/admin_update_password.php">Đổi mật khẩu</a>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Họ tên *</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="không it hơn 2 ký tự" value="<?php if ($admin != null) {
                                                                                            echo ($admin->get_name());
                                                                                        } ?>">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Số điện thoại</label>
                <input type="tel" class="form-control" id="phone-number" name="phone-number" value="<?php if ($admin != null) {
                                                                                                        echo ($admin->get_phone_number());
                                                                                                    } ?>">

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Ngày tham gia *</label>
                <input type="tel" class="form-control" id="join-date" name="join-date" disabled value="<?php if ($admin != null) {
                                                                                                            echo (date("d-m-y", $admin->get_join_date()));
                                                                                                        } ?>">                                                                                 
            </div>

            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Tự giới thiệu</label>
                <textarea class="form-control" id="self-intro" rows="3" name="self-intro" placeholder="Viết vài dòng giới thiệu về bản thân bạn" name="self-intro"><?php if ($admin != null) {
                                                                                                                                                        echo ($admin->get_self_intro());
                                                                                                                                                    } ?></textarea>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary" name="submit" value="submit">Lưu thay đổi</button>
                <button type="submit" class="btn btn-secondary">Làm mới</button>
                <button type="submit" class="btn btn-warning" name="btn-logout" value="submit">Đăng xuất</button>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-danger">Yêu cầu hủy tài khoản</button>
            </div>
        </form>
    </div>


    <?php include "../templates/footer.php" ?>
</body>

</html>