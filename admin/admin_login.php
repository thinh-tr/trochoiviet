<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <div id="login-body" class="container">
        <form>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" bind:value={email}>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="exampleInputPassword1" bind:value={password}>
            </div>
            <div class="mb-3 form-check">
            </div>
            <button type="submit" class="btn btn-primary">Đăng nhập</button><br><br>
            <a id="register-link" href="/trochoiviet_php/admin/admin_register.php">Đăng ký trở thành quản trị viên</a>
        </form>
    </div>


    <?php include "../templates/footer.php" ?><!--footer-->
</body>

</html>