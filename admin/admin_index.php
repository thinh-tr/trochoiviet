<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <title>Trang quản trị</title>
    <style>
        .container {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .container a {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <?php include "../templates/header.php" ?> <!--Header-->
    <?php include "./templates/admin_header.php" ?> <!--admin header-->
    <!-- Thân trang -->
    <div class="container">
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <a href="#">
                <div class="col">
                    <div class="card">
                        <img src="../static/images/Social-Post.png" class="card-img-top" alt="..." />
                        <div class="card-body">
                            <h5 class="card-title"><b>Quản lý bài đăng</b></h5>
                            <p class="card-text">
                                Xem và cập nhật thông tin về các bài đăng của bạn
                                tại đây
                            </p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="#">
                <div class="col">
                    <div class="card">
                        <img src="../static/images/shop.jpg" class="card-img-top" alt="..." />
                        <div class="card-body">
                            <h5 class="card-title"><b>Quản lý cửa hàng</b></h5>
                            <p class="card-text">
                                Bạn có mặt hàng về các trò chơi dân gian? Hãy chia
                                sẽ tại đây nhé!
                            </p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="#">
                <div class="col">
                    <div class="card">
                        <img src="../static/images/order.jpg" class="card-img-top" alt="..." />
                        <div class="card-body">
                            <h5 class="card-title"><b>Quản lý đơn hàng</b></h5>
                            <p class="card-text">
                                Xem thông tin về các đơn hàng mà bạn có tại đây
                            </p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="#">
                <div class="col">
                    <div class="card">
                        <img src="../static/images/admin.jpg" class="card-img-top" alt="..." />
                        <div class="card-body">
                            <h5 class="card-title"><b>Tài khoản quản trị viên</b></h5>
                            <p class="card-text">
                                Trở thành quản trị viên để đóng góp nội dung cho
                                trang cộng đồng này
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <?php include "../templates/footer.php" ?>
</body>

</html>