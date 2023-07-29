<?php
// script xử lý

include $_SERVER["DOCUMENT_ROOT"] . "/entities/post_entity.php";    // post entities

/**
 * Repository
 * Lấy ra array chứa các post_content của một post theo post id
 * input: post_id
 * output: array chứa post_content -> có kết quả | array rỗng -> không có kết quả
 */
function repo_select_post_contents_by_post_id(string $post_id): array
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $password);
        $sql = "SELECT * FROM post_content WHERE post_content.post_id = '$post_id'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $post_contents = array();   // Biến chứa các contents sẽ được trả ra

        // Kiểm tra kết quả trả về
        if ($result != false && count($result) > 0) {
            foreach ($result as $row) {
                $content = new \Entities\PostContent();    // biến chứa thông tin content
                $content->set_id($row["id"]);
                $content->set_title($row["title"]);
                $content->set_content($row["content"]);
                $content->set_post_id($row["post_id"]);
                // thêm content tìm được vào array kết quả
                array_push($post_contents, $content);
            }
            // Trả ra array chứa kết quả sau khi đã thêm tất cả content
            return $post_contents;
        }
        // trả ra array rỗng
        return $post_contents;
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Service
 * Lấy ra array chứa các post_content của một post theo post id
 * input: post_id
 * output: array chứa post_content -> có kết quả | array rỗng -> không có kết quả
 */
function service_get_post_contents_by_post_id(string $post_id): array
{
    return repo_select_post_contents_by_post_id($post_id);
}



/**
 * Repository
 * Lấy ra thông tin của các PostContentImage thông qua post_content_id
 * input: post_content_id
 * output: array chứa các PosrtContentImage -> tìm thấy kết quả | array rỗng -> không tìm thấy kết quả
 */
function repo_select_post_content_image_by_post_content_id(string $post_content_id): array
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM post_content_image WHERE post_content_image.post_content_id = '$post_content_id'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $post_content_images = array(); // Biến chứa content image cần trả ra
        // Kiểm tra kết quả trả về
        if ($result != false && count($result) > 0) {
            // trường hợp tìm được kết quả
            // Lần lượt lấy ra các PostContentImage rồi push vào array kết quả
            foreach ($result as $row) {
                $content_image = new \Entities\PostContentImage();
                $content_image->set_id($row["id"]);
                $content_image->set_image_link($row["image_link"]);
                $content_image->set_post_content_id($row["post_content_id"]);
                array_push($post_content_images, $content_image);   // push
            }
            // trả ra array kết quả tìm được
            return $post_content_images;
        }
        // trường hợp không tìm được kết quả
        return $post_content_images;    // trả ra array rỗng
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Service
 * Lấy ra thông tin của các PostContentImage thông qua post_content_id
 * input: post_content_id
 * output: array chứa các PosrtContentImage -> tìm thấy kết quả | array rỗng -> không tìm thấy kết quả
 */
function service_get_post_content_image_by_post_content_id(string $post_content_id): array
{
    return repo_select_post_content_image_by_post_content_id($post_content_id);
}


/**
 * Repository
 * Lấy ra array chứa thông tin của các video được nhúng trong bài post
 * input: post_id
 * output: array chứa các video link của bài post -> có kết quả | array rỗng -> không có kết quả
 */
function repo_select_post_video_by_post_id(string $post_id): array
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM post_video WHERE post_video.post_id = '$post_id'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $post_video_array = array();
        // Kiểm tra kết quả truy vấn
        if ($result != false && count($result) > 0) {
            // trường hợp tìm được kết quả
            foreach ($result as $row) {
                // lần lượt chuyển kết quả tìm được vào array kết quả
                $post_video = new \Entities\PostVideo();
                $post_video->set_id($row["id"]);
                $post_video->set_video_link($row["video_link"]);
                $post_video->set_post_id($row["post_id"]);
                array_push($post_video_array, $post_video);
            }
            // trả ra array chứa kết quả
            return $post_video_array;
        }
        // Nếu không tìm được kết quả
        return $post_video_array;   // trả ra array rỗng
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Service
 * Lấy ra array chứa thông tin của các video được nhúng trong bài post
 * input: post_id
 * output: array chứa các video link của bài post -> có kết quả | array rỗng -> không có kết quả
 */
function get_post_video_by_post_id(string $post_id): array
{
    return repo_select_post_video_by_post_id($post_id);
}

?>

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
    <title>Nội dung bài viết</title>
    <style>
        .post-header {
            width: 100%;
            width: 100vw;
            height: 200px;
        }
    </style>
</head>
<body>
    <?php include  $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?> <!--header-->

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/services/post_service.php"; ?>  <!--Post service-->

    <?php
    $post = null;   // biến chứa thông tin post
    $post_contents = array();   // array chứa post content
    $post_likes = -1;
    $post_comments = -1;
    // nhận lệnh từ url và bắt đầu truy vấn thông tin
    if (isset($_GET["post-id"])) {
        // Truy vấn thông tin theo post_id
        $post = \PostService\get_post_by_id($_GET["post-id"]);  // Lấy ra thông tin của Post cần hiển thị
        $post_contents = service_get_post_contents_by_post_id($_GET["post-id"]);    // Lấy ra các content của post cần hiển thị
        $post_likes = \PostService\get_post_like_number($_GET["post-id"]);
        $post_comments = \PostService\get_post_comment_number($_GET["post-id"]);
    }
    ?>
    
    <!--Nội dung bài viết-->
    <div class="container">
        <?php
        if ($post != null) {
            // Hiển thị thông tin của post
        ?>
        <!--Thông tin post-->
        <!--Đầu bài viết-->
        <div class="card mb-3">
        <img src="<?= $post->get_cover_image_link() ?>" class="card-img-top" alt="..." style="height: 300px;">
        <div class="card-body">
            <h1 class="card-title" style="text-align: center; font-weight: bold;"><?= $post->get_name() ?></h1>
            <p class="card-text"><?= $post->get_description() ?></p>
            <p class="card-text"><small class="text-body-secondary"><b>Tác giả:</b> <?= $post->get_admin_email() ?><br> <b>Ngày đăng:</b> <?= date("d-m-Y, H:i:s", $post->get_created_date()) ?><br> <b>Ngày cập nhật:</b> <?= date("d-m-Y, H:i:s", $post->get_created_date()) ?></small></p>
        </div>
        </div>
        
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <form class="container-fluid justify-content-start">
                    <button class="btn btn-outline-primary me-2" type="button"><i class="bi bi-hand-thumbs-up-fill"></i> <?= $post_likes ?></button>
                    <button class="btn btn-outline-warning me-2" type="button"><i class="bi bi-chat-fill"></i> <?= $post_comments ?></button>
                </form>
            </div>
        </nav>
        <!--Hiển thị các post content và hình ảnhcủa post-->
        <div class="container">
        <?php
        if (count($post_contents) > 0) {
            foreach ($post_contents as $content) {
        ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h3 class="card-title"><?= $content->get_title() ?></h3>
                    <p class="card-text"><?= $content->get_content() ?></p>
                </div>
            </div>
            <!--Tải hình ảnh minh họa của đoạn content-->
            <?php
            // Truy vấn các hình ảnh của đoạn content nếu có
            $content_image_links = service_get_post_content_image_by_post_content_id($content->get_id());
            if (count($content_image_links) > 0) {
            ?>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <!--Lần lượt hiển thị các hình ảnh-->
                <?php
                foreach ($content_image_links as $image) {
                ?>
                    <div class="col">
                        <img src="<?= $image->get_image_link() ?>" class="img-fluid" alt="...">
                    </div>
                <?php
                }
                ?>
            </div><br>
            <?php
            }
            ?>
        <?php
            }
        } else {
        ?>
            <!--Thông báo bài viết hiện đang cập nhật thông tin-->
            <div class="alert alert-warning" role="alert">
                <i class="bi bi-info-circle-fill"></i> Bài viết này hiện tại chưa có nội dung
            </div>
        <?php
        }
        ?>
        </div>
        <?php
        } else {
            // Không tìm được thông tin của post
        ?>
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Không thể tìm thấy bài viết này!</h4>
            <p>Đã có lỗi xảy ra trong quá trình truy vấn thông tin.</p>
            <hr>
            <p class="mb-0">Content not found.</p>
        </div>
        <?php
        }
        ?>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php"; ?> <!--footer-->
</body>
</html>