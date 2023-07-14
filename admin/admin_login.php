<?php
// chạy session
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <title>Đăng nhập quản trị viên</title>
    <style>
        #login-body.container {
            padding-left: 20%;
            padding-right: 20%;
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <?php include "../templates/header.php" ?><!--header-->
    <?php include "./templates/admin_header.php" ?><!--admin header-->

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/trochoiviet/services/admin_service.php" ?>

    <?php
    // Code đăng nhập
    if (isset($_POST["submit"])) {   // Nếu như có lệnh login từ phía admin
        // array chứa login info
        $login_info = array();

        // Kiểm tra các trường trong form login

        // email
        if ($_POST["admin-email"] != null && filter_var($_POST["admin-email"], FILTER_VALIDATE_EMAIL)) {
            $login_info["admin-email"] = $_POST["admin-email"];  // Thêm trường email vào array
        }

        // password
        if ($_POST["admin-password"] != null && strlen($_POST["admin-password"]) > 0) {
            $login_info["admin-password"] = $_POST["admin-password"];
        }

        // Kiểm tra lại array
        $is_valid_array = true;
        if (!array_key_exists("admin-email", $login_info)) {
            $is_valid_array = false;
        } else if (!array_key_exists("admin-password", $login_info)) {
            $is_valid_array = false;
        }

        if ($is_valid_array) {
            // Tiến hành truy vấn thông tin đăng nhập
            if (\Services\login($login_info["admin-email"], $login_info["admin-password"])) {
                // Thêm admin email vào biến session
                $_SESSION["admin-email"] = $login_info["admin-email"];
                // Hiển thị thông báo đã login thành công
                echo(
                    <<<END
                        <div style="background-color: rgb(102, 242, 106); width: 100%; height: 15%; text-align: center; color: white; padding: 10px;">
                            <h5>Đăng nhập thành công tài khoản quản trị "{$_SESSION["admin-email"]}"</h5><br>
                            Truy cập trang thông tin tài khoản để xem chi tiết
                        </div>
                    END
                );
            } else {
                echo ("<script>window.alert('Thông tin đăng nhập chưa chính xác')</script>");
            }
        } else {
            // Thông tin login chưa đầy đủ -> xuất ra thông báo
            echo ("<script>window.alert('Vui lòng kiểm tra lại thông tin đăng nhập của bạn');</script>");
        }
    }
    ?>

    <div id="login-body" class="container">
        <form method="post">
            <div class="mb-3">
                <label for="admin-email" class="form-label">Email</label>
                <input type="email" class="form-control" id="admin-email" name="admin-email" aria-describedby="emailHelp" bind:value={email}>
            </div>
            <div class="mb-3">
                <label for="admin-password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="admin-password" name="admin-password" bind:value={password}>
            </div>
            <div class="mb-3 form-check">
            </div>
            <button type="submit" class="btn btn-primary" id="submit" name="submit">Đăng nhập</button><br><br>
            <a id="register-link" href="/trochoiviet/admin/admin_register.php">Đăng ký trở thành quản trị viên</a>
        </form>
    </div>


    <?php include "../templates/footer.php" ?><!--footer-->
</body>

</html>