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
    $post = null;
    $post_content = null;
    $image_array = array();
    // Lấy ra thông tin của content cần chỉnh sửa
    if (isset($_GET["post-id"]) && isset($_GET["content-id"])) {
        $post = \PostService\get_post_by_id($_GET["post-id"]);
        $post_content = \PostService\get_post_content($_GET["content-id"]); // lấy ra post_content cần chỉnh sửa
        $image_array = \PostService\get_post_content_image_by_post_content_id($post_content->get_id());
    }
    ?>

    <?php
    // Xử lý cập nhật thông tin content
    if (isset($_POST["save-submit"])) {
        // Kiểm tra thông tin trên form
        $content_update_array = array();

        // Kiểm tra title
        if (strlen($_POST["content-title"]) >= 2) {
            $content_update_array["content_title"] = $_POST["content-title"];
        }

        // Kiểm tra nội dung content
        if (strlen($_POST["content-body"]) >= 20) {
            $content_update_array["content_body"] = $_POST["content-body"];
        }

        // Kiểm tra lại array
        $is_valid_array = true;
        if (!array_key_exists("content_title", $content_update_array)) {
            $is_valid_array = false;
        } else if (!array_key_exists("content_body", $content_update_array)) {
            $is_valid_array = false;
        }

        // Nếu info hợp lệ thì tiến hành update
        if ($is_valid_array) {
            \PostService\update_post_content($post_content->get_id(), $content_update_array["content_title"], $content_update_array["content_body"]);
            // cập nhật lại modified_date của post
            $post->set_modified_date(time());
            \PostService\update_post_info($post->get_id(), $post->get_name(), $post->get_description(), $post->get_cover_image_link(), $post->get_modified_date(), $post->get_views());
            echo(<<<END
                <div class="alert alert-success" role="alert">
                    Đã cập nhật nội dung bài viết
                </div>          
                END);
        } else {
            echo("<script>window.alert('Nội dung bài viết chưa hợp lệ, vui lòng kiểm tra lại')</script>");
        }
    }
    ?>

    <?php
    // Xử lý thêm link ảnh mới
    if (isset($_POST["image-submit"])) {
        // Kiểm tra link ảnh
        if (strlen($_POST["image-link"]) >= 2) {
            $content_image = new \Entities\PostContentImage();
            $content_image->set_id(uniqid());
            $content_image->set_image_link($_POST["image-link"]);
            $content_image->set_post_content_id($post_content->get_id());
            \PostService\add_content_image_link($content_image);
            echo(<<<END
            <div class="alert alert-success" role="alert">
                Đã thêm link hình ảnh
            </div>          
            END);
        } else {
            echo("<script>window.alert('Link ảnh không hợp lệ, vui lòng kiểm tra lại')</script>");
        }
    }
    ?>

    <?php
    // Xử lý xóa link ảnh
    for ($i = 0; $i < count($image_array); $i++) {
        if (isset($_POST["{$image_array[$i]->get_id()}"])) {
            \PostService\delete_content_image($image_array[$i]->get_id());
            echo(<<<END
                <div class="alert alert-danger" role="alert">
                    Đã xóa link hình ảnh
                </div>          
                END);
        }
    }
    ?>

    <!--Điều hướng-->
    <nav id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
        <a class="btn btn-primary" href="/admin/admin_post_edit.php?post-id=<?= $post->get_id() ?>"><i class="bi bi-arrow-left"></i> Trở lại</a>
        <ul class="nav nav-pills">
            <form method="post">
                <button class="btn btn-info" id="refresh" name="refresh"><i class="bi bi-arrow-counterclockwise"></i> Làm mới</button>
            </form>
        </ul>
    </nav>
    <div class="container">
        <div class="alert alert-info" role="alert">
            <i class="bi bi-info-circle"></i> Sau khi thay đổi thông tin hãy bấn nút lưu để đảm bảo thông tin mới được cập nhật
        </div>
        <h3><i class="bi bi-file-earmark-post"></i> <b>Cập nhật nội dung bài viết: <?= $post->get_name() ?></b></h3>
        <form method="post" class="border border-primary" style="border-radius: 5px;">
            <div class="container">
                <div class="mb-3">
                    <label for="content-title" class="form-label"><b>Tiêu đề *</b></label>
                    <input type="text" class="form-control" id="content-title" name="content-title" placeholder="Tiêu đề (từ 2 ký tự trở lên)" value="<?= $post_content->get_title() ?>">
                </div>
                <div class="mb-3">
                    <label for="content-body" class="form-label"><b>Nội dung *</b></label>
                    <textarea class="form-control" id="content-body" name="content-body" rows="3" placeholder="Nội dung (từ 20 ký tự trở lên)"><?= $post_content->get_content() ?></textarea>
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary" id="save-submit" name="save-submit"><i class="bi bi-arrow-up-square-fill"></i> Lưu</button>
                    <button class="btn btn-danger" id="save-cancel" name="save-cancel"><i class="bi bi-x-square-fill"></i> Hủy</button>
                </div>
            </div>
        </form><br>
        <h3><i class="bi bi-images"></i> <b>Hình ảnh minh họa:</b></h3>
        <form method="post" class="border border-warning" style="border-radius: 5px;">
            <div class="container">
                <div class="mb-3">
                    <label for="image-link" class="form-label"><b>Thêm link ảnh minh họa *</b></label>
                    <input type="text" class="form-control" id="image-link" name="image-link" placeholder="link chứa hình ảnh minh họa (từ 2 ký tự trở lên)">
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary" id="image-submit" name="image-submit"><i class="bi bi-arrow-up-square-fill"></i> Lưu</button>                
                    <button class="btn btn-danger" id="image-cancel" name="image-cancel"><i class="bi bi-x-square-fill"></i> Hủy</button>
                </div>
            </div>
        </form><br>
        <h5><b>Các hình ảnh hiện có</b></h5>
        <!--Hiển thị lên các hình ảnh hiện có-->
        <?php
        if (count($image_array) > 0) {
        ?>
        <div class="row row-cols-1 row-cols-md-4 g-4">
        <?php
            for ($i = 0; $i < count($image_array); $i++) {
        ?>
            <div class="col">
                <div class="card h-100">
                    <img src="<?= $image_array[$i]->get_image_link() ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text"><?= $image_array[$i]->get_image_link() ?></p>
                    </div>
                    <div class="card-footer">
                        <form method="post">
                            <button class="btn btn-danger" id="<?= $image_array[$i]->get_id() ?>" name="<?= $image_array[$i]->get_id() ?>"><i class="bi bi-trash3-fill"></i> Xóa</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php
            }
        ?>
        </div>
        <?php
        } else {
        ?>
        <!--Thông báo không có hình ảnh minh họa-->
        <div class="alert alert-warning" role="alert">
            <i class="bi bi-info-circle-fill"></i> Nội dung này chưa có ảnh minh họa
        </div>
        <?php
        }
        ?>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php"; ?>
</body>

</html>