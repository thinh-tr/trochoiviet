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
    // Nhận request param từ trang post_comment.php
    $post = null;
    if (isset($_GET["post-id"])) {
        $post = \PostService\get_post_by_id($_GET["post-id"]);  // lấy ra thông tin của post
    }
    ?>

    <?php
    // Xử lý thêm comment
    // Nếu có lệnh thêm comment từ template
    if (isset($_POST["comment-submit"])) {
        // Kiểm tra login
        if (isset($_SESSION["user_phone_number"])) {
            // Kiểm tra thông tin từ form
            if (strlen($_POST["comment-content"]) >= 2 && strlen($_POST["comment-content"]) <= 8000 && isset($post)) {
                // comment phải chứa tối thiểu 2 ký tự và không nhiều hơn 8000 ký tự
                // Tạo obj chứa nội dung comment
                $new_comment = new \Entities\PostComment();
                $new_comment->set_id(uniqid()); // gán id
                $new_comment->set_created_date(time()); // gán created_date
                $new_comment->set_content($_POST["comment-content"]);   // gán nội dung comment
                $new_comment->set_user_phone_number($_SESSION["user_phone_number"]);    // gán user
                $new_comment->set_post_id($post->get_id()); // gán post id
                $new_comment->set_approval(0);  // gán approval cho comment
                // Thêm comment
                if (\PostService\add_new_comment($new_comment)) {
                    echo(<<<END
                        <div class="alert alert-success" role="alert">
                            <i class="bi bi-check-circle-fill"></i> Đã đăng tải bình luận của bạn
                        </div>
                        END);
                } else {
                    echo(<<<END
                        <div class="alert alert-danger" role="alert">
                            <i class="bi bi-exclamation-triangle-fill"></i> Không thể đăng tải bình luận (Lỗi xử lý)
                        </div>
                        END);
                }
            } else {
                echo("<script>window.alert('Nội dung bình luận không hợp lệ, vui lòng kiểm tra lại');</script>");
            }
        } else {
            // trường hợp không có login -> xuất ra thông báo
            echo(<<<END
                <div class="alert alert-warning" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i> Bạn vẫn chưa đăng nhập
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
        <h3>Đăng tải bình luận cho bài viết: <?php if (isset($post)) {echo($post->get_name());}?> </h3>
        <div class="container">
            <form method="post">
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Nội dung bình luận của bạn</label>
                    <textarea class="form-control" id="comment-content" name="comment-content" rows="3" placeholder="Từ 2 ký tự trở lên và không vượt quá 8000 ký tự"></textarea>
                </div>
                <button class="btn btn-primary" id="comment-submit" name="comment-submit"><i class="bi bi-box-arrow-up"></i> Đăng tải</button>
                <a class="btn btn-danger" href="/post/post_comment.php?post-id=<?php if (isset($post)) {echo($post->get_id());} ?>"><i class="bi bi-x-circle"></i> Hủy</a>
            </form>
        </div>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php"; ?> <!--footer-->
</body>
</html>