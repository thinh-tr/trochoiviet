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
    <title>Thêm bình luận mới</title>
    <style>
    </style>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?> <!--header-->

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/services/post_service.php"; ?>   <!--Service-->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/entities/post_entity.php"; ?>

    <?php
    // Nhận request param từ trang post_detail.php
    $post = null;
    if (isset($_GET["post-id"])) {
        $post = \PostService\get_post_by_id($_GET["post-id"]);  // lấy ra thông tin của post
    }
    ?>

    <div class="container">
        <h3>Bình luận cho bài viết: <?php if (isset($post)) {echo($post->get_name());}?> </h3>
        <div class="container">
            <form method="post">
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Nội dung bình luận</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                <button class="btn btn-primary" id="comment-submit" name="comment-submit"><i class="bi bi-box-arrow-up"></i> Đăng tải</button>
                <a class="btn btn-danger" href="/post/post_detail.php?post-id=<?php if (isset($post)) {echo($post->get_id());} ?>"><i class="bi bi-x-circle"></i> Hủy</a>
            </form>
        </div>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php"; ?> <!--footer-->
</body>
</html>