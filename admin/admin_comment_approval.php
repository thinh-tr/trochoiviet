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
    <title>Kiểm tra và phê duyệt bình luận</title>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/admin/templates/admin_header.php"; ?>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/services/post_service.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/entities/post_entity.php"; ?>

    <?php
    // Xử lý tải thông tin cho trang
    if (isset($_GET["post-id"])) {
        $post = \PostService\get_post_by_id($_GET["post-id"]);  // thông tin post
        $unapproval_comments = \PostService\get_post_comment_with_no_approval($_GET["post-id"]);    // unapproval comments
        $approval_comments = \PostService\get_post_comment_with_approval($_GET["post-id"]); // approval comments
    }
    ?>

    <?php
    // Xử lý phê duyệt comment
    for ($i = 0; $i < count($unapproval_comments); $i++) {
        if (isset($_POST[$unapproval_comments[$i]->get_id()])) {
            \PostService\approve_post_comment($unapproval_comments[$i]->get_id());  // phê duyệt comment
            echo(<<<END
                <div class="alert alert-success" role="alert">
                    Đã duyệt bình luận
                </div>
                END);
        }
    }
    ?>

    <?php
    // Xử lý hủy phê duyệt bình luận
    for ($i = 0; $i < count($approval_comments); $i++) {
        if (isset($_POST[$approval_comments[$i]->get_id()])) {
            \PostService\disapprove_post_comment($approval_comments[$i]->get_id());
            echo(<<<END
                <div class="alert alert-danger" role="alert">
                    Đã hủy phê duyệt bình luận
                </div>
                END);
        }
    }
    ?>

    <?php
    // Xử lý xóa bình luận chưa được duyệt
    for ($i = 0; $i < count($unapproval_comments); $i++) {
        if (isset($_POST["delete-" . $unapproval_comments[$i]->get_id()])) {
            \PostService\delete_comment($unapproval_comments[$i]->get_id());
            echo(<<<END
                <div class="alert alert-danger" role="alert">
                    Đã xóa bình luận
                </div>
                END);
        }
    }
    ?>


    <?php
        // Xử lý xóa bình luận đã được duyệt
        for ($i = 0; $i < count($approval_comments); $i++) {
            if (isset($_POST["delete-" . $approval_comments[$i]->get_id()])) {
                \PostService\delete_comment($approval_comments[$i]->get_id());
                echo(<<<END
                    <div class="alert alert-danger" role="alert">
                        Đã xóa bình luận
                    </div>
                    END);
            }
        }
    ?>



    <!--Điều hướng-->
    <nav id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
        <a class="btn btn-primary" href="/admin/admin_post_edit.php?post-id=<?= $post->get_id() ?>"><i class="bi bi-arrow-left"></i> Thông tin bài viết: <?= $post->get_name() ?></a>
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a href="#list-item-1" class="nav-link"><i class="bi bi-x-circle-fill"></i> Bình luận chưa được duyệt</a>
            </li>
            <li class="nav-item">
                <a href="#list-item-2" class="nav-link">Bình luận đã được duyệt</a>
            </li>
            <form method="post">
                <button class="btn btn-info" id="refresh" name="refresh"><i class="bi bi-arrow-counterclockwise"></i> Làm mới</button>
            </form>
        </ul>
    </nav>

    <div class="container">
        <h2><i class="bi bi-chat"></i> <b>Các bình luận cho bài viết: <?= $post->get_name() ?></b></h2>
        <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example bg-body-tertiary p-3 rounded-2" tabindex="0">
            <h4 id="list-item-1"><i class="bi bi-x-circle-fill"></i> <b>Bình luận chưa được duyệt</b></h4>
            <div class="container">
                    <?php
                    if (count($unapproval_comments) > 0) {
                        for ($i = 0; $i < count($unapproval_comments); $i++) {
                    ?>
                        <!--card chứa nội dung comment-->
                        <div class="card border-danger w-75 mb-3">
                            <div class="card-header">
                                <small class="text-body-secondary">Bình luận của: <b><?= $unapproval_comments[$i]->get_user_phone_number() ?></b></small>,
                                <small class="text-body-secondary">Ngày đăng: <b><?= date("d-m-Y", $unapproval_comments[$i]->get_created_date()) ?></b></small>
                            </div>
                            <div class="card-body">
                                <p class="card-text"><?= $unapproval_comments[$i]->get_content() ?></p>
                            </div>
                            <div class="card-footer">
                                <form method="post">
                                    <button class="btn btn-success" id="<?= $unapproval_comments[$i]->get_id() ?>" name="<?= $unapproval_comments[$i]->get_id() ?>"><i class="bi bi-check-lg"></i> Phê duyệt</button>
                                    <button class="btn btn-danger" id="delete-<?= $unapproval_comments[$i]->get_id() ?>" name="delete-<?= $unapproval_comments[$i]->get_id() ?>"><i class="bi bi-trash3-fill"></i> Xóa</button>
                                </form>
                            </div>
                        </div>
                    <?php
                        }
                    } else {
                    ?>
                    <!--Nếu không có bình luận nào chưa được duyệt thì hiển thị thông báo-->
                    <div class="alert alert-warning" role="alert">
                        <i class="bi bi-info-circle"></i> Hiện tại không có bình luận chưa được phê duyệt
                    </div>
                    <?php
                    }
                    ?>
            </div><br>

            <h4 id="list-item-2"><i class="bi bi-check-circle-fill"></i> <b>Bình luận đã được duyệt</b></h4>
            <div class="container">
                <?php
                if (count($approval_comments) > 0) {
                    for ($i = 0; $i < count($approval_comments); $i++) {
                ?>
                    <!--card chứa nội dung comment-->
                    <div class="card border-info w-75 mb-3">
                        <div class="card-header">
                            <small class="text-body-secondary">Bình luận của: <b><?= $approval_comments[$i]->get_user_phone_number() ?></b></small>,
                            <small class="text-body-secondary">Ngày đăng: <b><?= date("d-m-Y", $approval_comments[$i]->get_created_date()) ?></b></small>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><?= $approval_comments[$i]->get_content() ?></p>
                        </div>
                        <div class="card-footer">
                            <form method="post">
                                <button class="btn btn-warning" id="<?= $approval_comments[$i]->get_id() ?>" name="<?= $approval_comments[$i]->get_id() ?>"><i class="bi bi-x-lg"></i> Hủy phê duyệt</button>
                                <button class="btn btn-danger" id="delete-<?= $approval_comments[$i]->get_id() ?>" name="delete-<?= $approval_comments[$i]->get_id() ?>"><i class="bi bi-trash3-fill"></i> Xóa</button>
                            </form>
                        </div>
                    </div>
                <?php
                    }
                } else {
                ?>
                <!--Nếu không có bình luận nào chưa được duyệt thì hiển thị thông báo-->
                <div class="alert alert-warning" role="alert">
                    <i class="bi bi-info-circle"></i> Hiện tại không có bình luận được phê duyệt
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php"; ?>
</body>
</html>