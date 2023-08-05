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
    $post_content_array = array();  // array lưu thông tin của các content
    $post_video_array = array();    // array chứa thông tin các link video của post
    if (isset($_GET["post-id"])) {
        $post = \PostService\get_post_by_id($_GET["post-id"]);
        $post_content_array = \PostService\get_post_contents_by_post_id($_GET["post-id"]);
        $post_video_array = \PostService\get_post_video_by_post_id($_GET["post-id"]);
    }
    ?>

    <?php
    // Xử lý cập nhật thông tin post
    if (isset($_POST["post-save-submit"])) {
        // khi có lệnh cập nhật
        // Kiểm tra lại thông tin trên form
        $post_info_array = array(); // array chứa thông tin của post
        
        // Kiểm tra tên post
        if (strlen($_POST["post-name"]) >= 2) {
            $post_info_array["post_name"] = $_POST["post-name"];    // gán post_name vào array
        }

        // Description không cần kiểm tra
        $post_info_array["post_description"] = $_POST["post-description"];
        // cover_image_link không cần kiểm tra
        $post_info_array["post_cover"] = $_POST["post-cover"];

        // Ngày cập nhật
        $post_info_array["post_modified_date"] = time();
        
        // Kiểm tra lượt xem
        if (is_numeric($_POST["post-views"]) && intval($_POST["post-views"]) <= $post->get_views()) {
            // views phải là số và phải <= số views hiện có của post
            $post_info_array["post_views"] = intval($_POST["post-views"]);  // gán post_views vào array
        }

        // Kiểm tra lại array
        $is_valid_array = true;
        if (!array_key_exists("post_name", $post_info_array)) {
            $is_valid_array = false;
        } else if (!array_key_exists("post_views", $post_info_array)) {
            $is_valid_array = false;
        }

        if ($is_valid_array) {
            // tiến hành cập nhật
            \PostService\update_post_info($post->get_id(), $post_info_array["post_name"], $post_info_array["post_description"], $post_info_array["post_cover"], $post_info_array["post_modified_date"], $post_info_array["post_views"]);
            echo(<<<END
                <div class="alert alert-success" role="alert">
                    Đã cập nhật thông tin bài viết
                </div>          
                END);
        } else {
            // Xuất ra thông báo cần kiểm tra lại thông tin
            echo("<script>window.alert('Thông tin bài viết chưa hợp lệ, vui lòng kiểm tra lại')</script>");
        }
    }
    ?>

    <!--Điều hướng-->
    <nav id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
        <a class="btn btn-primary" href="/admin/admin_post_manager_index.php"><i class="bi bi-arrow-left"></i> Trang bài viết</a>
    </nav>

    <div class="container">
        <div class="container">
            <div class="alert alert-info" role="alert">
                <i class="bi bi-info-circle"></i> Sau khi thay đổi thông tin hãy bấn nút lưu để đảm bảo thông tin mới được cập nhật
            </div>
            <!--Thông tin tiêu đề bài viết-->
            <h3><i class="bi bi-info-circle"></i> <b>Thông tin bài viết</b></h3>
            <form method="post">
                <div class="mb-3">
                    <label for="post-name" class="form-label"><b>Tên bài viết *</b></label>
                    <input type="text" class="form-control" id="post-name" name="post-name" placeholder="Tên bài viết (từ 2 ký tự trở lên)" value="<?php if ($post != null) echo($post->get_name()); ?>">
                </div>
                <div class="mb-3">
                    <label for="post-description" class="form-label"><b>Mô tả</b></label>
                    <textarea class="form-control" id="post-description" name="post-description" placeholder="Phần mô tả bài viết" rows="3"><?php if ($post != null) echo($post->get_description()); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="post-cover" class="form-label"><b>Link ảnh bìa</b></label>
                    <input type="text" class="form-control" id="post-cover" name="post-cover" placeholder="link ảnh bìa của bài viết" value="<?php if ($post != null) echo($post->get_cover_image_link()); ?>"><br>
                    <!--Hiển thị ảnh bìa đang được sử dụng-->
                    <img src="<?php if ($post != null) echo($post->get_cover_image_link()); ?>" class="img-thumbnail" alt="...">
                </div>            
                <div class="mb-3">
                    <label for="post-created-date" class="form-label"><b>Ngày đăng tải</b></label>
                    <input style="width: 50%;" type="text" class="form-control" id="post-created-date" name="post-created-date" disabled value="<?php if ($post != null) echo(date("d-m-Y", $post->get_created_date())); ?>">
                </div>
                <div class="mb-3">
                    <label for="post-modified-date" class="form-label"><b>Ngày cập nhật</b></label>
                    <input style="width: 50%;" type="text" class="form-control" id="post-modified-date" name="post-modified-date" disabled value="<?php if ($post != null) echo(date("d-m-Y", $post->get_modified_date() ?? $post->get_created_date())); ?>">
                </div>
                <div class="mb-3">
                    <label for="post-views" class="form-label"><b>Lượt xem</b></label>
                    <input style="width: 50%;" type="number" class="form-control" id="post-views" name="post-views" value="<?php if ($post != null) echo($post->get_views()); ?>">
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary" id="post-save-submit" name="post-save-submit"><i class="bi bi-arrow-up-square-fill"></i> Lưu</button>
                    <button class="btn btn-danger" id="post-cancel" name="post-cancel"><i class="bi bi-x-square-fill"></i> Hủy</button>
                </div>
            </form>

            <!--Thông tin nội dung bài viết-->
            <h3><i class="bi bi-postcard"></i> <b>Nội dung bài viết</b></h3>
            <nav id="post-content-nav" class="navbar bg-body-tertiary px-3 mb-3">
                <a class="btn btn-warning" href="#"><i class="bi bi-plus-lg"></i> Thêm đoạn nội dung</a>
            </nav>
            <!--Hiển thị các đoạn nội dung mà post này có-->
            <?php
            if (count($post_content_array) > 0) {
                for ($i = 0; $i < count($post_content_array); $i++) {
            ?>
            <form method="post" style="border-style: solid; border-width: 2px; border-radius: 5px; margin-bottom: 5px;">
                <div class="container">
                    <div class="mb-3">
                        <label for="content-title-<?= $post_content_array[$i]->get_id() ?>" class="form-label"><b>Tiêu đề nội dung *</b></label>
                        <input type="text" class="form-control" id="content-title-<?= $post_content_array[$i]->get_id() ?>" name="content-title-<?= $post_content_array[$i]->get_id() ?>" placeholder="Tiêu đề đoạn nội dung (từ 2 ký tự trở lên)" value="<?= $post_content_array[$i]->get_title() ?>">
                    </div>
                    <div class="mb-3">
                        <label for="content-body-<?= $post_content_array[$i]->get_id() ?>" class="form-label"><b>Nội dung *</b></label>
                        <textarea class="form-control" id="content-body-<?= $post_content_array[$i]->get_id() ?>" name="content-body-<?= $post_content_array[$i]->get_id() ?>" rows="3"><?= $post_content_array[$i]->get_content() ?></textarea>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary" name="content-save-submit-<?= $post_content_array[$i]->get_id() ?>"><i class="bi bi-arrow-up-square-fill"></i> Lưu</button>
                        <button class="btn btn-danger" name="content-cancel"><i class="bi bi-x-square-fill"></i> Hủy</button>
                    </div>
                </div>
            </form>
            <?php
                }
            } else {
            ?>
            <!--Hiển thị thông báo không tìm thấy đoạn nội dung-->
            <div class="alert alert-warning" role="alert">
                <i class="bi bi-info-circle-fill"></i> Bài viết này chưa có đoạn nội dung nào
            </div>
            <?php
            }
            ?>
        </div>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php"; ?>
</body>

</html>