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
    <?php include "../templates/header.php" ?><!--header-->
    <?php include "./templates/user_header.php" ?> <!--user header-->

    <!--service-->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/trochoiviet/services/user_service.php" ?>

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
                <a class="btn btn-info" href="#"><i class="bi bi-file-earmark-lock2-fill"></i> Cập nhật mật khẩu</a>
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
                <button type="submit" class="btn btn-danger"><i class="bi bi-x-square-fill"></i> Yêu cầu hủy tài khoản</button>
            </div>
        </form>
    </div>

    <?php include "../templates/footer.php" ?> <!--footer-->

</body>

</html>