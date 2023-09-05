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
    <title>Tạo bài viết mới</title>
    <style>
        #header {
            position: sticky;
            top: 0;
            z-index: 999;
        }
    </style>
</head>
<body>
    <div id="header">
        <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "/admin/templates/admin_header.php"; ?>

        <!--Điều hướng-->
        <nav id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
            <a class="btn btn-primary" href="/admin/admin_post_manager_index.php"><i class="bi bi-arrow-left"></i> Trang quản lý bài viết</a>
        </nav>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/services/post_service.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/entities/post_entity.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/entities/post_categories.php"; ?>

    <?php
    // Lựa chọn category cho bài viết sắp tạo
    $new_post_category = PostCategory\unclassified;

    // Xác nhận nếu có lựa chọn category
    if (isset($_POST["post-category"])) {
        // Lấy giá trị category vừa chọn gán cho biến category
        $new_post_category = strval($_POST["post-category"]);
    }
    ?>

    <?php
    // Xử lý thêm bài viết mới
    if (isset($_POST["post-submit"])) {
        // Kiểm tra login
        if (isset($_SESSION["admin_email"])) {
            // Kiểm tra lại thông tin trên form
            $post_info_array = array();

            // Kiểm tra tên bài viết
            if (strlen($_POST["post-name"]) >= 2) {
                // thêm name vào array
                $post_info_array["post_name"] = $_POST["post-name"];
            }

            // link ảnh bìa
            $post_info_array["cover_image"] = $_POST["cover-image"];
            // mô tả
            $post_info_array["post_description"] = $_POST["post-description"];

            // Kiểm tra lại array
            $is_valid_array = true;
            if (!array_key_exists("post_name", $post_info_array)) {
                $is_valid_array = false;
            }

            // Tạo post nếu thông tin hợp lệ
            if ($is_valid_array) {
                // tạo post cần thêm
                $new_post = new \Entities\Post();
                //  gán thông tin cho post
                $new_post->set_id(uniqid());
                $new_post->set_name($post_info_array["post_name"]);
                $new_post->set_description($post_info_array["post_description"]);
                $new_post->set_cover_image_link($post_info_array["cover_image"]);
                $new_post->set_created_date(time());
                $new_post->set_modified_date(time());
                $new_post->set_views(0);
                $new_post->set_admin_email($_SESSION["admin_email"]);
                $new_post->set_category($new_post_category);    // gán category cho bài viết

                \PostService\add_post($new_post);   // Tạo post
                echo(<<<END
                    <div class="alert alert-success" role="alert">
                        Đã tạo thành công bài viết mới
                    </div>              
                    END);
            } else {
                echo("<script>window.alert('Vui lòng kiểm tra lại thông tin bài viết')</script>");
            }
        } else {
            echo("<script>window.alert('Vui lòng đăng nhập tài khoản quản trị để tạo bài viết')</script>");
        }
    }
    ?>

    
    <div class="container">
        <h3><i class="bi bi-info-circle"></i> <b>Thêm thông tin cho bài viết mới</b></h3>
        <form method="post" class="border border-primary" style="border-radius: 5px;">
            <div class="container">
                <div class="mb-3">
                    <label for="post-name" class="form-label"><b>Tên bài viết *</b></label>
                    <input type="text" class="form-control" id="post-name" name="post-name" placeholder="Tên bài viết (từ 2 ký tự trở lên)">
                </div>
                <div class="mb-3">
                    <label for="post-name" class="form-label"><b>Link ảnh bìa</b></label>
                    <input type="text" class="form-control" id="cover-image" name="cover-image" placeholder="Link ảnh bìa">
                </div>
                <div class="mb-3">
                    <label for="post-description" class="form-label"><b>Mô tả</b></label>
                    <textarea class="form-control" id="post-description" name="post-description" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="post-category" class="form-label"><i class="bi bi-tags-fill"></i> <b>Danh mục cho bài viết này</b></label><br>
                    <input type="radio" name="post-category" value="<?= PostCategory\unclassified ?>"> <b>Chưa phân loại</b><br>
                    <input type="radio" name="post-category" value="<?= PostCategory\general ?>"> <b>Thông tin chung</b><br>
                    <input type="radio" name="post-category" value="<?= PostCategory\guide ?>"> <b>Hướng dẫn</b><br>
                    <input type="radio" name="post-category" value="<?= PostCategory\news ?>"> <b>Tin tức</b><br>
                    <input type="radio" name="post-category" value="<?= PostCategory\memorable ?>"> <b>Kỷ niệm</b><br>
                </div>
                <div class="mb-3">
                    <form method="post">
                        <button class="btn btn-primary" id="post-submit" name="post-submit"><i class="bi bi-box-arrow-up"></i> Tạo bài viết</button>
                        <button class="btn btn-danger" id="cancel" name="cancel"><i class="bi bi-trash3-fill"></i> Hủy</button>
                    </form>
                </div>
            </div>
        </form>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php"; ?>
</body>
</html>