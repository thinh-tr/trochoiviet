<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <title>Đăng ký mật khẩu người dùng</title>
    <style>
        #change-pass-body.container {
            padding-left: 20%;
            padding-right: 20%;
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php" ?> <!--Header-->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/user/templates/user_header.php" ?> <!--admin header-->

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/services/user_service.php" ?>

    <!--Tạo mật khẩu cho người dùng-->
    <?php
    if (isset($_POST["submit"])) {
        // Không cần login
        // Kiểm tra tính hợp lệ của thông tin trên form
        $register_password_array = array();

        // phone_number
        if ($_POST["phone-number"] != "") {
            $register_password_array["phone_number"] = $_POST["phone-number"];
        }

        // password
        if (strlen($_POST["password"]) >= 5 && strpos($_POST["password"], " ") == false) {
            $register_password_array["password"] = $_POST["password"];
        }

        // confirm password
        if ($_POST["confirm-password"] == $_POST["password"]) {
            $register_password_array["confirm_password"] = $_POST["confirm-password"];
        }

        // Kiểm tra lại array
        $is_valid_array = true;
        if (!array_key_exists("phone_number", $register_password_array)) {
            $is_valid_array = false;
        } else if (!array_key_exists("password", $register_password_array)) {
            $is_valid_array = false;
        } else if (!array_key_exists("confirm_password", $register_password_array)) {
            $is_valid_array = false;
        }

        // Bắt đầu kiểm tra và thêm mới
        if ($is_valid_array) {
            // Kiểm tra tồn tại UserInfo
            if (\UserService\is_user_info_exists($register_password_array["phone_number"]) && !\UserService\is_user_login_info_exists($register_password_array["phone_number"])) {
                // Nếu UserInfo có tồn tại và nó chưa được đăng ký password
                $user_login_info = new \Entities\UserLoginInfo();
                $user_login_info->set_id(uniqid()); // set id
                $user_login_info->set_phone_number($register_password_array["phone_number"]);
                $user_login_info->set_password($register_password_array["password"]);

                if(\UserService\create_user_password($user_login_info)) {
                    echo(<<<END
                            <div style="background-color: rgb(102, 242, 106); width: 100%; height: 15%; text-align: center; color: white; padding: 10px;">
                                <h5>Đã tạo thành công nhật mật khẩu cho người dùng {$register_password_array["phone_number"]}</h5>
                                Hãy đăng nhập để sử dụng tài khoản của bạn
                            </div>
                            END);
                } else {
                    // Đã xảy ra lỗi không thể tạo password
                    echo("<script>window.alert('Đã xảy ra lỗi trorng quá trình xử lý')</script>");
                }
            } else {
                // Nếu UserInfo vẫn chưa tồn tại thì xuất ra cảnh báo
                echo(<<<END
                <div style="background-color: rgb(255, 219, 59); width: 100%; height: 15%; text-align: center; color: white; padding: 10px;">
                    <h5>Thông tin người dùng của bạn vẫn chưa được hệ thống lưu trữ hoặc đã được đăng ký mật khẩu từ trước, vui lòng sử dụng trang đăng ký tài khoản để đăng ký hoặc đăng nhập trực tiếp</h5>
                </div>
                END);        
            }
        } else {
            echo("<script>window.alert('Vui lòng kiểm tra lại thông tin của bạn')</script>");
        }
    }
    ?>

    <div id="change-pass-body" class="container">
        <h3 style="text-align: center;"><b>Đăng ký mật khẩu người dùng</b></h3>
        <p>(Chỉ dành cho người dùng đã có thông tin trên hệ thống nhưng chưa đăng ký mật khẩu)</p>
        <form method="post">
            <div class="mb-3">
                <label for="phone-number" class="form-label">Số điện thoại của bạn *</label>
                <input type="tel" class="form-control" id="phone_number" name="phone-number">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu muốn tạo *</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="confirm-password" class="form-label">Xác nhận lại mật khẩu *</label>
                <input type="password" class="form-control" id="confirm-password" name="confirm-password">
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary" id="submit" name="submit">Đăng ký mật khẩu</button>
                <a class="btn btn-danger" href="/user/user_index.php">Hủy</a>
            </div>
        </form>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php" ?>
</body>
</html>