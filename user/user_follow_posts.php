<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Bài viết đã thích</title>
    <style>
        h2 {
            font-weight: bold;
        }

        .card h5 {
            font-weight: bold;
        }

        div.col-4 {
            width: 20%;
        }

        .col a {
            text-decoration: none;
        }
    </style>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>    <!--header-->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/user/templates/user_header.php"; ?> <!--user header-->

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/services/post_service.php"; ?>  <!--service-->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/entities/post_entity.php"; ?>   <!--entity-->

    <?php
    // Lấy ra các post mà người dùng đã thích
    $user_follow_posts = array();
    // Kiểm tra login
    if (isset($_SESSION["user_phone_number"])) {
        $user_follow_posts = \PostService\get_follow_posts($_SESSION["user_phone_number"]);
    }
    ?>

    <?php
    // Xử lý xóa post khỏi danh sách theo dõi
    for ($i = 0; $i < count($user_follow_posts); $i++) {
        if (isset($_POST[$user_follow_posts[$i]->get_id()])) {
            // xóa post khỏi danh sách yêu thích
            \PostService\unfollow_post($_SESSION["user_phone_number"], $user_follow_posts[$i]->get_id());
            echo(<<<END
            <div class="alert alert-danger" role="alert">
                Đã bỏ theo dõi bài viết
            </div>
            END);
        }
    }
    ?>

    <!--Điều hướng-->
    <nav id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
        <a class="btn btn-primary" href="/user/user_index.php"><i class="bi bi-arrow-left"></i> Trung tâm người dùng</a>
        <ul class="nav nav-bills">
            <li class="nav-item">
                <form method="post">
                    <button class="btn btn-info" name="refresh"><i class="bi bi-arrow-counterclockwise"></i> Làm mới</button>
                </form>
            </li>
        </ul>
    </nav>
    <div class="container">
        <div class="container">
            <!--Hiển thị các post mà user đã thích-->
            <h2><i class="bi bi-bookmarks"></i> Bài viết bạn đang theo dõi</h2>
            <?php
            if (count($user_follow_posts) > 0) {
            ?>
                <!--Trường hợp có tìm thấy post đã thích-->
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php
                    for ($i = 0; $i < count($user_follow_posts); $i++) {
                        // Lần lượt hiển thị ra các post
                    ?>
                        <div class="col">
                            <a href="/post/post_detail.php?post-id=<?= $user_follow_posts[$i]->get_id() ?>">
                                <div class="card h-100">
                                    <img src="<?= $user_follow_posts[$i]->get_cover_image_link() ?>" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $user_follow_posts[$i]->get_name() ?></h5>
                                        <p class="card-text"><?= $user_follow_posts[$i]->get_description() ?></p>
                                    </div>
                                <div class="card-footer">
                                    <small class="text-body-secondary"><b>Đăng ngày:</b> <?= date("d-m-y" ,$user_follow_posts[$i]->get_created_date()) ?> <br> <b>Tác giả:</b> <?= $user_follow_posts[$i]->get_admin_email() ?></small><br>
                                    <form method="post">
                                        <button type="submit" class="btn btn-danger" id="<?= $user_follow_posts[$i]->get_id() ?>" name="<?= $user_follow_posts[$i]->get_id() ?>"><i class="bi bi-trash3-fill"></i> Xóa</button>
                                    </form>
                                </div>
                                </div>
                            </a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            <?php
            } else {
            ?>
            <!--Xuất ra thông báo không có post đã thích nào (cả trong trường hợp chưa login)-->
            <div class="alert alert-warning" role="alert">
                <i class="bi bi-info-circle-fill"></i> Bạn vẫn chưa theo dõi bài viết nào
            </div>
            <?php
            }
            ?>
        </div>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php"; ?>
</body>
</html>