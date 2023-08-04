<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật nội dung bài viết</title>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/admin/templates/admin_header.php"; ?>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/services/post_service.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/entities/post_entity.php"; ?>

    <?php
    // Truy vấn thông tin của post cần edit
    $post = null;   // biến lưu thông tin của post
    if (isset($_GET["post_id"])) {
        $post = \PostService\get_post_by_id($_GET["post_id"]);  // post cần chỉnh sửa
    }
    ?>

    

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php"; ?>
</body>
</html>