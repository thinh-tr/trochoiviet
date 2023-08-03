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
    <title>Xác nhận xóa bình luận</title>
    <style>
        .card {
            margin-bottom: 3cm;
        }
    </style>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php" ?> <!--header-->

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/services/post_service.php"; ?> <!--post service-->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/entities/post_entity.php"; ?> <!--post entities-->


    <!--Nhận thông tin từ request param-->
    <?php
    $post = null;
    $comment = null;
    if (isset($_GET["post-id"]) && isset($_GET["comment-id"])) {
        // Lấy ra thông tin của post và comment
        $post = \PostService\get_post_by_id($_GET["post-id"]);
        $comment = \PostService\get_comment($_GET["comment-id"]);
    }
    ?>

    <?php
    // Xử lý thêm comment
    // Nếu có lệnh thêm comment từ template
    if (isset($_POST["comment-submit"])) {
        // Kiểm tra thông tin từ form
        if (strlen($_POST["comment-content"]) >= 2 && strlen($_POST["comment-content"]) <= 8000 && isset($post)) {
            // comment không ít hơn 2 và nhiều hơn 8000 ký tự
            // Cập nhật comment
            \PostService\update_comment_content($comment->get_id(), $_POST["comment-content"]);
            echo(<<<END
                <div class="alert alert-success" role="alert">
                    <i class="bi bi-check-circle-fill"></i> Đã cập nhật bình luận của bạn
                </div>
                END);
        }
    }
    ?>

    <!--nav quay lại trang bình luận-->
    <nav id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
        <a class="btn btn-primary" href="/post/post_comment.php?post-id=<?php if (isset($post)) {echo($post->get_id());} ?>"><i class="bi bi-arrow-left"></i> <?= $post->get_name() ?></a>
    </nav>
    <div class="container">
        <h3>Cập nhật bình luận cho bài viết: <?php if (isset($post)) {echo($post->get_name());}?> </h3>
        <div class="container">
            <form method="post">
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Nội dung bình luận của bạn</label>
                    <textarea class="form-control" id="comment-content" name="comment-content" rows="3"><?php if (isset($comment)) {echo($comment->get_content());} ?></textarea>
                </div>
                <button class="btn btn-warning" id="comment-submit" name="comment-submit"><i class="bi bi-box-arrow-up"></i> Cập nhật</button>
                <a class="btn btn-danger" href="/post/post_comment.php?post-id=<?php if (isset($post)) {echo($post->get_id());} ?>"><i class="bi bi-x-circle"></i> Hủy</a>
            </form>
        </div>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php" ?> <!--footer-->
</body>
</html>