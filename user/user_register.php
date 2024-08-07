<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <title>Đăng ký người dùng</title>
    <style>
        #header {
            position: sticky;
            top: 0;
            z-index: 999;
        }
    </style>
</head>
<body>
    <div id="header">
        <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php" ?>  <!--header-->
        <?php include $_SERVER["DOCUMENT_ROOT"] . "/user/templates/user_header.php" ?> <!--user header-->
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/services/user_service.php" ?>

    <?php
    // Tạo thông tin user mới
    if (isset($_POST["submit"])) {  // có lệnh submit từ form
        // tạo array kiểm tra thông tin đầu vào
        $user_info_array = array();

        // Lần lượt kiểm tra thông tin trên form sau đó push vào array nếu thông tin đó hợp lệ

        // phone_number
        if (is_numeric($_POST["phone-number"]) && strlen($_POST["phone-number"]) <= 12 && !\UserService\is_used_user_phone_number($_POST["phone-number"])) {
            $user_info_array["phone_number"] = $_POST["phone-number"];  // thêm vào phone_number
        }

        // email (nếu người dùng có nhập vào thì kiểm tra)
        if (!empty($_POST["email"])) {
            if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                $user_info_array["email"] = $_POST["email"];    // thêm vào email
            }
        } else {
            // Nếu không thì thêm vào chuỗi rỗng
            $user_info_array["email"] = "";
        }

        // name
        if (strlen($_POST["name"]) >= 2) {
            $user_info_array["name"] = $_POST["name"];
        }

        // address (không cần kiểm tra)
        $user_info_array["address"] = $_POST["address"];

        // join_date (tự tạo)
        $user_info_array["join_date"] = time();

        // Kiểm tra mật khẩu
        if (strlen($_POST["password"]) >= 5 && !str_contains($_POST["password"], " ")) {
            $user_info_array["password"] = $_POST["password"];  // thêm password vào
        }

        // xác nhận lại mật khẩu
        if ($_POST["confirm-password"] == $_POST["password"]) {
            $user_info_array["confirm_password"] = $_POST["confirm-password"];
        }

        // Kiểm tra lại array
        $is_valid_array = true;
        if (!array_key_exists("phone_number", $user_info_array)) {
            $is_valid_array = false;
        } else if (!array_key_exists("name", $user_info_array)) {
            $is_valid_array = false;
        } else if (!array_key_exists("password", $user_info_array)) {
            $is_valid_array = false;
        } else if (!array_key_exists("confirm_password", $user_info_array)) {
            $is_valid_array = false;
        }

        // Kiểm tra biến xác nhận hợp lệ
        if ($is_valid_array) {
            // thêm thông tin
            // Khởi tạo các obj chứa thông tin
            $user_info = new \Entities\UserInfo();  // user_info
            $user_info->set_phone_number($user_info_array["phone_number"]); // phone_number
            $user_info->set_email($user_info_array["email"]);   // email
            $user_info->set_name($user_info_array["name"]); // name
            $user_info->set_join_date($user_info_array["join_date"]);   // join_date

            $user_login_info = new \Entities\UserLoginInfo();   // login info
            $user_login_info->set_id(uniqid()); // id
            $user_login_info->set_phone_number($user_info_array["phone_number"]);
            $user_login_info->set_password($user_info_array["password"]);

            if (\UserService\create_full_user_info($user_info, $user_login_info)) {
                // Thông báo tạo thành công
                echo(<<<END
                    <div class="alert alert-success" role="alert">
                        <h5>Đăng ký thành công người dùng "{$user_info->get_phone_number()} - {$user_info->get_name()}"</h5>
                    </div>
                END);
            } else {
                // thông báo lỗi
                echo("<script>window.alert('Đã có lỗi xảy ra trong quá trình xử lý');</script>");
            }
        } else {
            // thông báo cần kiểm tra lại thông tin
            echo("<script>window.alert('Vui lòng kiểm tra lại thông tin của bạn. Có thể số điện thoại bạn nhập vào đã được sử dụng');</script>");
        }
    }
    ?>

    <!--Form đăng ký thông tin người dùng mới-->
    <div class="container">
        <h3 style="text-align: center;"><i class="bi bi-person-circle"></i> <b>Đăng ký thông tin người dùng</b></h3><br>
            <form class="register-form" method="post">
                <div class="mb-3">
                    <label for="phone-number" class="form-label"><i class="bi bi-telephone-fill"></i> <b>Số điện thoại *</b></label>
                    <input type="tel" class="form-control" id="phone-number" name="phone-number"> 
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label"><i class="bi bi-envelope-fill"></i> <b>Email</b></label>
                    <input type="email" class="form-control" id="email" placeholder="name@example.com" name="email">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label"><i class="bi bi-info-circle-fill"></i> <b>Tên *</b></label>
                    <input type="text" class="form-control" id="name" placeholder="Tối thiểu 2 ký tự" name="name"> 
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label"><i class="bi bi-key-fill"></i> <b>Mật khẩu *</b></label>
                    <input type="password" class="form-control" id="password" placeholder="Tối thiểu 5 ký tự" name="password">
                </div>
                <div class="mb-3">
                    <label for="confirm-password" class="form-label"><i class="bi bi-key-fill"></i> <b>Xác nhận lại mật khẩu *</b></label>
                    <input type="password" class="form-control" id="confirm-password" name="confirm-password"> 
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-success" name="submit" value="submit"><i class="bi bi-box-arrow-up"></i> Đăng ký</button>
                    <a href="/user/user_index.php"><button type="button" class="btn btn-danger"><i class="bi bi-x-circle"></i> Hủy</button></a>
                </div>
            </form>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php" ?>  <!--footer-->
</body>
</html>