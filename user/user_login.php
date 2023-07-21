<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <title>Đăng nhập người dùng</title>
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
    <?php include "./templates/user_header.php" ?> <!--user header-->

    <!--user service-->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/trochoiviet/services/user_service.php" ?>

    <?php
    // Xử lý đăng nhập
    if (isset($_POST["submit"])) {
        if (!isset($_SESSION["user_phone_number"])) {
            // tiến hành đăng nhập
            $user_login_array = array();

            // Kiểm tra lại thông tin trên form
            if (!empty($_POST["user-phone-number"])) {  // phone number
                // Nếu không rỗng thì thêm vào
                $user_login_array["user_phone_number"] = $_POST["user-phone-number"];
            }

            if (!empty($_POST["user-password"])) {  // password
                // Nếu không rổng thì thêm vào
                $user_login_array["user_password"] = $_POST["user-password"];
            }

            // Kiểm tra lại array
            $is_valid_array = true;
            if (!array_key_exists("user_phone_number", $user_login_array)) {
                $is_valid_array = false;
            } else if (!array_key_exists("user_password", $user_login_array)) {
                $is_valid_array = false;
            }

            // Nếu thông tin hợp lệ thì gửi yêu cầu login
            if ($is_valid_array) {
                if (\UserService\login($user_login_array["user_phone_number"], $user_login_array["user_password"])) {
                    // Thêm biến user_phone_number vào SESSION
                    $_SESSION["user_phone_number"] = $user_login_array["user_phone_number"];
                    echo(<<<END
                        <div style="background-color: rgb(102, 242, 106); width: 100%; height: 15%; text-align: center; color: white; padding: 10px;">
                            <h5>Đăng nhập thành công tài khoản người dùng "{$_SESSION["user_phone_number"]}"</h5><br>
                            Truy cập trang thông tin tài khoản để xem chi tiết
                        </div>
                        END);
                }
            } else {
                // Nếu không thì yêu cầu kiểm tra lại thông tin
                echo ("<script>window.alert('Vui lòng kiểm tra lại thông tin đăng nhập của bạn');</script>");
            }
        } else {
            // user khác vẫn đang còn trong phiên đăng nhập -> xuất ra thông báo yêu cầu đăng xuất
            echo(<<<END
                <div style="background-color: rgb(247, 94, 94); width: 100%; height: 15%; text-align: center; color: white; padding: 10px;">
                <h5>Người dùng "{$_SESSION["user_phone_number"]}" hiện đang trong phiên làm việc</h5><br>
                Vui lòng truy cập trang thông tin tài khoản để đăng xuất trước khi mở phiên đăng nhập mới
            </div>
        END);

        }
    }
    ?>

    <!--form đăng nhập-->
    <div id="login-body" class="container">
        <h3 style="text-align: center;"><b>Đăng nhập người dùng</b></h3><br>
        <form method="post">
            <div class="mb-3">
                <label for="user-phone-number" class="form-label"><i class="bi bi-telephone-fill"></i> Số điện thoại</label>
                <input type="tel" class="form-control" id="user-phone-number" name="user-phone-number">
            </div>
            <div class="mb-3">
                <label for="user-password" class="form-label"><i class="bi bi-key-fill"></i> Mật khẩu</label>
                <input type="password" class="form-control" id="user-password" name="user-password">
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary" id="submit" name="submit">Đăng nhập</button><br><br>
            </div>
        </form>
    </div>

    <?php include "../templates/footer.php" ?><!--footer-->
</body>

</html>