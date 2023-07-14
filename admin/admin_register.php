<?php
// Chạy session
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
    <title>Đăng ký quản trị viên</title>
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
    <?php include "../templates/header.php"; ?>
    <?php include "./templates/admin_header.php"; ?>

    <!--file admin_service-->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/trochoiviet/services/admin_service.php"; ?>

    <?php
        // Đăng ký thông tin admin mới
        if (isset($_POST["submit"])) {
            // Array chứa thông tin sẽ được ghi vào database
            $register_infos = array();
            
            // Kiểm tra qua các trường trong form đăng ký -> trường hợp lệ sẽ được thêm vào array

            // email
            if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) != false) {
                $register_infos["email"] = $_POST["email"]; // thêm email vào array
            }

            // password
            if ($_POST["password"] != null && strlen($_POST["password"]) >= 5) {
                // Kiểm tra trùng khớp password
                if ($_POST["password"] === $_POST["confirm-password"]) {
                    $register_infos["password"] = $_POST["password"];
                }
            }

            // name
            if ($_POST["name"] != null && strlen($_POST["name"]) >= 2) {
                $register_infos["name"] = $_POST["name"];
            }

            // phone_number
            $register_infos["phone_number"] = $_POST["phone-number"] ?? "";

            // join_date
            $register_infos["join_date"] = time();  // tự động set thời gian đăng ký

            // self_introduction
            $register_infos["self_intro"] = $_POST["self-intro"] ?? "";


            // Kiểm tra lại array
            $is_valid_array = true;
            if (!array_key_exists("email", $register_infos)) {
                $is_valid_array = false;    // email ko hợp lệ
            } else if (!array_key_exists("password", $register_infos)) {
                $is_valid_array = false;    // password không hợp lệ
            } else if (!array_key_exists("name", $register_infos)) {
                $is_valid_array = false;    // name không hợp lệ
            }

            if ($is_valid_array) {
                // tiến hành thêm admin mới
                $new_admin = new Entities\AdminInfo(
                    $register_infos["email"],
                    $register_infos["password"],
                    $register_infos["name"],
                    $register_infos["phone_number"],
                    $register_infos["join_date"],
                    $register_infos["self_intro"]
                );
                if (Services\register_new_admin($new_admin)) {
                    //echo("Đăng ký thành công");
                    echo(
                        <<<END
                            <div style="background-color: rgb(102, 242, 106); width: 100%; height: 15%; text-align: center; color: white; padding: 10px;">
                                <h5>Đăng ký thành công quản trị viên "{$new_admin->get_email()} - {$new_admin->get_name()}"</h5><br>
                                Hãy đăng nhập để sử dụng các chức năng dành cho quản trị viên
                            </div>
                        END
                    );    
                } else {
                    // Lỗi xử lý data
                    echo("<script>window.alert('Đã có lỗi xảy ra trong quá trình xử lý')</script>");
                }
            } else {
                echo("<script>window.alert('Vui lòng kiểm tra lại thông tin của bạn')</script>");
            }
        }
    ?>

    <!--form đăng ký quản trị viên-->
    <div class="container">
        <h3 style="text-align: center;"><b>Đăng ký thông tin quản trị viên</b></h3><br>
        <form class="register-form" method="post">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Địa chỉ Email</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" name="email">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="exampleFormControlInput1" placeholder="Tối thiểu 5 ký tự" name="password">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Xác nhận lại mật khẩu</label>
                <input type="password" class="form-control" id="exampleFormControlInput1" name="confirm-password"> 
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Họ tên</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Tối thiểu 2 ký tự" name="name"> 
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Số điện thoại</label>
                <input type="tel" class="form-control" id="exampleFormControlInput1" name="phone-number"> 
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Tự giới thiệu</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Viết vài dòng giới thiệu về bản thân bạn" name="self-intro"></textarea>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-success" name="submit" value="submit">Đăng ký</button>
                <a href="/trochoiviet/admin/admin_index.php"><button type="button" class="btn btn-danger">Hủy</button></a>
            </div>
        </form>
    </div>

    <?php include "../templates/footer.php" ?>
</body>

</html>