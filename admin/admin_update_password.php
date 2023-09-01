<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <title>Cập nhật mật khẩu quản trị viên</title>
    <style>
        #header {
            position: sticky;
            top: 0;
            z-index: 999;
        }

        #change-pass-body.container {
            padding-left: 20%;
            padding-right: 20%;
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div id="header">
        <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php" ?> <!--Header-->
        <?php include $_SERVER["DOCUMENT_ROOT"] . "/admin/templates/admin_header.php" ?> <!--admin header-->

        <!--Điều hướng-->
        <nav id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
            <a class="btn btn-primary" href="/admin/admin_info.php"><i class="bi bi-arrow-left"></i> Trang thông tin quản trị viên</a>
        </nav>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/services/admin_service.php" ?>

    <?php
    // Cập nhật password mới
    if (isset($_POST["submit"])) {  // Nếu như có lệnh update
        // Kiểm tra session và trạng thái login
        if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION["admin_email"])) {
            // Đang có login
            // Kiểm tra qua thông tin trên form trước
            $update_password_array = array();
            
            // current password (check )
            if ($_POST["current-password"] != "") {
                $update_password_array["current_password"] = $_POST["current-password"];
            }

            // new password
            if (strlen($_POST["new-password"]) >= 5 && strpos($_POST["new-password"], " ") == false) {
                $update_password_array["new_password"] = $_POST["new-password"];
            }

            // confirm new password
            if ($_POST["confirm-new-password"] == $_POST["new-password"]) {
                $update_password_array["confirm_new_password"] = $_POST["confirm-new-password"];
            }

            // Kiểm tra lại array
            $is_valid_array = true;
            if (!array_key_exists("current_password", $update_password_array)) {
                $is_valid_array = false;
            } else if (!array_key_exists("new_password", $update_password_array)) {
                $is_valid_array = false;
            } else if (!array_key_exists("confirm_new_password", $update_password_array)) {
                $is_valid_array = false;
            }

            if ($is_valid_array) {
                // cập nhật password
                if (AdminServices\update_password($_SESSION["admin_email"], $update_password_array["current_password"], $update_password_array["new_password"])) {
                    echo(<<<END
                        <div class="alert alert-success" role="alert">
                            <h5>Đã cập nhật mật khẩu</h5>
                            Hãy đăng nhập lại bằng mật khẩu mới
                        </div>                  
                        END);
                } else {
                    echo(<<<END
                        <div class="alert alert-warning" role="alert">
                            <h5>Hãy kiểm tra lại mật khẩu của bạn</h5>
                        </div>
                    END);    
                }
            } else {
                echo("<script>window.alert('Vui lòng kiểm tra lại thông tin của bạn');</script>");
            }

        } else {
            // Không có login -> xuất ra thông báo
            echo(<<<END
                <div class="alert alert-warning" role="alert">
                    <h5>Bạn vẫn chưa đăng nhập</h5>
                </div>
            END);
        }
    }
    ?>

    
    <div id="change-pass-body" class="container">
        <h3 style="text-align: center;"><b>Cập nhật mật khẩu quản trị viên</b></h3><br>
        <form method="post">
            <div class="mb-3">
                <label for="current-password" class="form-label"><i class="bi bi-key-fill"></i> <b>Mật khẩu hiện tại *</b></label>
                <input type="password" class="form-control" id="current-password" name="current-password">
            </div>
            <div class="mb-3">
                <label for="new-password" class="form-label"><i class="bi bi-key"></i> <b>Mật khẩu mới *</b></label>
                <input type="password" class="form-control" id="new-password" name="new-password">
            </div>
            <div class="mb-3">
                <label for="confirm-new-password" class="form-label"><i class="bi bi-key"></i> <b>Xác nhận lại mật khẩu mới *</b></label>
                <input type="password" class="form-control" id="confirm-new-password" name="confirm-new-password">
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary" id="submit" name="submit"><i class="bi bi-box-arrow-up"></i> Lưu mật khẩu mới</button>
                <a class="btn btn-danger" href="/admin/admin_info.php"><i class="bi bi-x-circle"></i> Hủy</a>
            </div>
        </form>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php" ?>
</body>
</html>