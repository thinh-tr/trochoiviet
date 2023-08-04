<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <title>Trung tâm người dùng</title>
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
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php" ?>  <!--header-->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/user/templates/user_header.php" ?> <!--user header-->

    <!-- Thân trang -->
    <div class="container">
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <a href="/user/user_like_posts.php">
                <div class="col">
                    <div class="card">
                        <img src="../static/images/liked_post.jpg" class="card-img-top" alt="..." />
                        <div class="card-body">
                            <h5 class="card-title"><b>Bài viết đã thích</b></h5>
                        </div>
                    </div>
                </div>
            </a>

            <a href="/user/user_follow_posts.php">
                <div class="col">
                    <div class="card">
                        <img src="../static/images/follow.jpg" class="card-img-top" alt="..." />
                        <div class="card-body">
                            <h5 class="card-title"><b>Bài viết đang theo dõi</b></h5>
                        </div>
                    </div>
                </div>
            </a>

            <a href="#">
                <div class="col">
                    <div class="card">
                        <img src="../static/images/Shopping-Cart.jpg" class="card-img-top" alt="..." />
                        <div class="card-body">
                            <h5 class="card-title"><b>Đơn hàng của bạn</b></h5>
                        </div>
                    </div>
                </div>
            </a>

            <a href="/user/user_info.php">
                <div class="col">
                    <div class="card">
                        <img src="../static/images/user_account.png" class="card-img-top" alt="..." />
                        <div class="card-body">
                            <h5 class="card-title"><b>Thông tin tài khoản</b></h5>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php" ?>  <!--footer-->
</body>

</html>