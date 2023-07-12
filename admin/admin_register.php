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
    <?php include "../templates/header.php" ?>
    <?php include "./templates/admin_header.php" ?>

    <?php
        include "./services/admin_service.php";

        // Đăng ký thông tin admin mới
        if ($_POST["submit"]) {
            // Kiểm tra qua các trường trong form đăng ký
            
        }
    ?>

    <!--form đăng ký quản trị viên-->
    <div class="container">
        <h3 style="text-align: center;"><b>Đăng ký thông tin quản trị viên</b></h3><br>
        <form class="register-form">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Địa chỉ Email</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" name="email">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Tên người dùng</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="username" name="username">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="exampleFormControlInput1" name="password">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Xác nhận lại mật khẩu</label>
                <input type="password" class="form-control" id="exampleFormControlInput1" name="confirm-password"> 
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Họ tên</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="name"> 
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Số điện thoại</label>
                <input type="tel" class="form-control" id="exampleFormControlInput1" name="phone-number"> 
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Tự giới thiệu</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="self-intro"></textarea>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-success" name="submit">Đăng ký</button>
                <a href="/trochoiviet/admin/admin_index.php"><button type="button" class="btn btn-danger">Hủy</button></a>
            </div>
        </form>
    </div>

    <?php include "../templates/footer.php" ?>
</body>

</html>