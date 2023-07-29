<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <title>Thông tin người dùng</title>
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
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php" ?><!--header-->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/user/templates/user_header.php" ?> <!--user header-->

    <!--service-->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/services/user_service.php" ?>

    <?php
    // lấy ra thông tin user đang login
    $user_info = null;
    $user_password = "";
    // Kiểm tra trạng thái login
    if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION["user_phone_number"])) {
        $user_info = UserService\get_user_info($_SESSION["user_phone_number"]);
        $user_password = UserService\get_user_password($_SESSION["user_phone_number"]);
    }
    ?>

    <!--Đăng xuất-->
    <?php
    if (isset($_POST["btn-logout"])) {
        // Kiểm tra trạng thái login
        if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION["user_phone_number"])) {
            unset($_SESSION["user_phone_number"]);  // xóa biến user_phone_number tronf SESSION
            $user_password = "";    // xóa password
            $user_info = null;  // xóa trống form
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

    <!--Cập nhật thông tin-->
    <?php
    if (isset($_POST["submit"])) {
        // Kiểm tra trạng thái login
        if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION["user_phone_number"])) {
            // array kiểm tra thông tin trên form
            $update_info_array = array();

            // Kiểm tra qua các trường cần update

            // email (luôn luôn được gán giá trị)
            if ($_POST["email"] != "" && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) != false) {
                // kiểm tra tính hợp lệ của email
                $update_info_array["email"] = $_POST["email"];
            } else {
                $update_info_array["email"] = "";
            }

            // name
            if (strlen($_POST["name"]) >= 2) {
                $update_info_array["name"] = $_POST["name"];
            }

            // Kiểm tra lại update_info_array
            $is_valid_array = true;
            if (!array_key_exists("name", $update_info_array)) {
                $is_valid_array = false;
            }

            // Tiến hành update nếu thông tin đã hợp lệ
            if ($is_valid_array) {
                \UserService\update_user_info($_SESSION["user_phone_number"], $update_info_array["email"], $update_info_array["name"]);
                // Cập nhật lại thông tin lên form
                echo(<<<END
                    <div class="alert alert-success" role="alert">
                        <h5>Đã cập nhật thông tin người dùng "{$_SESSION["user_phone_number"]}"</h5>
                    </div>              
                    END);
            } else {
                echo("<script>window.alert('Vui lòng kiểm tra lại thông tin của bạn');</script>");
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

    <!--form thông tin quản trị viên-->
    <div class="container">
        <h3 style="text-align: center;"><b>Thông tin người dùng</b></h3><br>
        <form class="register-form" method="post">
            <div class="mb-3">
                <label for="phone-number" class="form-label">Số điện thoại *</label>
                <input type="tel" class="form-control" id="phone-number" name="phone-number" disabled value="<?php if ($user_info != null) {
                                                                                                        echo ($user_info->get_phone_number());
                                                                                                    } ?>">

            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Địa chỉ email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php if ($user_info != null) {
                                                                                                        echo ($user_info->get_email());
                                                                                                    } ?>">
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Họ tên *</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="không ít hơn 2 ký tự" value="<?php if ($user_info != null) {
                                                                                                                            echo ($user_info->get_name());
                                                                                                                        } ?>">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password" disabled value="<?php if ($user_password != "") {
                                                                                                                echo ($user_password);
                                                                                                            } ?>">
            </div>

            <div class="mb-3">
                <a class="btn btn-info" href="/user/user_update_password.php"><i class="bi bi-file-earmark-lock2-fill"></i> Cập nhật mật khẩu</a>
            </div>

            <div class="mb-3">
                <label for="join-date" class="form-label">Ngày tham gia *</label>
                <input type="tel" class="form-control" id="join-date" name="join-date" disabled value="<?php if ($user_info != null) {
                                                                                                            echo (date("d-m-y", $user_info->get_join_date()));
                                                                                                        } ?>">
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary" name="submit" value="submit"><i class="bi bi-save-fill"></i> Lưu thay đổi</button>
                <button type="submit" class="btn btn-secondary"><i class="bi bi-arrow-clockwise"></i> Làm mới</button>
                <button type="submit" class="btn btn-warning" name="btn-logout" value="submit"><i class="bi bi-box-arrow-right"></i> Đăng xuất</button>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-danger"><i class="bi bi-x-square-fill"></i> Yêu cầu đóng tài khoản</button>
            </div>
        </form>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php" ?> <!--footer-->

</body>

</html>