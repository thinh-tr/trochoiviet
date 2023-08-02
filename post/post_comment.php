<?php
// script xử lý truy vấn thông tin

include $_SERVER["DOCUMENT_ROOT"] . "/entities/post_entity.php";

/**
 * Repository
 * Truy vấn thông tin các comment của một post thông qua id,
 * input: post_id,
 * output: array chứa comment | array rỗng -> không có kết quả
 */
function repo_select_comment_by_post_id(string $post_id): array
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM post_comment WHERE post_comment.post_id = '$post_id'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $comment_array = array();   // Biến chứa array kết quả
        // Kiểm tra kết quả
        if ($result != false && count($result) > 0) {
            foreach ($result as $row) {
                $comment = new \Entities\PostComment(); // biến lưu comment
                $comment->set_id($row["id"]);
                $comment->set_created_date($row["created_date"]);
                $comment->set_content($row["content"]);
                $comment->set_user_phone_number($row["user_phone_number"]);
                $comment->set_post_id($row["post_id"]);
                array_push($comment_array, $comment);   // push comment vào array kết quả
            }
        }
        return $comment_array;  // trả ra array kết quả
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Service
 * Truy vấn thông tin các comment của một post thông qua id,
 * input: post_id,
 * output: array chứa comment | array rỗng -> không có kết quả
 */
function service_get_post_comment(string $post_id): array
{
    return repo_select_comment_by_post_id($post_id);
}


/**
 * Repository
 * Truy vấn thông tin các comment của một user đến một post thông qua post_id và user_phone_number,
 * input: post_id, user_phone_number
 * output: array chứa comment | array rỗng -> không có kết quả
 */
function repo_select_comment_by_post_id_and_user_phone_number(string $post_id, string $user_phone_number): array
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM post_comment WHERE post_comment.post_id = '$post_id' AND post_comment.user_phone_number = '$user_phone_number'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $comment_array = array();   // Biến chứa array kết quả
        // Kiểm tra kết quả
        if ($result != false && count($result) > 0) {
            foreach ($result as $row) {
                $comment = new \Entities\PostComment(); // biến lưu comment
                $comment->set_id($row["id"]);
                $comment->set_created_date($row["created_date"]);
                $comment->set_content($row["content"]);
                $comment->set_user_phone_number($row["user_phone_number"]);
                $comment->set_post_id($row["post_id"]);
                array_push($comment_array, $comment);   // push comment vào array kết quả
            }
        }
        return $comment_array;  // trả ra array kết quả
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Service
 * Truy vấn thông tin các comment của một post thông qua id,
 * input: post_id,
 * output: array chứa comment | array rỗng -> không có kết quả
 */
function service_get_post_comment_of_specified_user(string $post_id, string $user_phone_number): array
{
    return repo_select_comment_by_post_id_and_user_phone_number($post_id, $user_phone_number);
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
    <title>Bình luận bài viết</title>
</head>
<body>
    <?php include  $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php" ?> <!--header-->

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/services/post_service.php" ?>   <!--Service-->

    <!--Xử lý tải thông tin trang-->
    <?php
    // Biến lưu các comment của bài viết
    $post = new \Entities\Post();   // obj trống
    $post_comments = array();   // array trống
    $post_comments_of_user = array();   // array trống

    // Nhận request param từ trang post_detail
    if (isset($_GET["post-id"])) {
        // Truy vấn thông tin
        $post = \PostService\get_post_by_id($_GET["post-id"]);
        $post_comments = service_get_post_comment($_GET["post-id"]);
        // Nếu có tài khoảng user đang login thì lấy ra bình luận của user đó
        if (isset($_SESSION["user_phone_number"])) {
            $post_comments_of_user = service_get_post_comment_of_specified_user($_GET["post-id"], $_SESSION["user_phone_number"]);
        }
    }
    ?>

    <!--Xử lý xóa toàn bộ các comment rỗng-->
    <?php
    if (isset($_POST["delete-null-comment"])) {
        // Kiểm tra login
        if (isset($_SESSION["user_phone_number"])) {
            \PostService\clean_null_comment($_SESSION["user_phone_number"]);    // xóa các comment rỗng
            echo(<<<END
            <div class="alert alert-success" role="alert">
                Đã xóa tất cả các bình luận mà bạn bỏ rống
            </div>
            END);
        } else {
            echo(<<<END
            <div class="alert alert-warning" role="alert">
                Bạn vẫn chưa đăng nhập
            </div>
            END);
        }
    }
    ?>

    <!--scroll nav menu-->
    <nav id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
        <a class="btn btn-primary" href="/post/post_detail.php?post-id=<?= $post->get_id() ?>"><i class="bi bi-arrow-left"></i> <?= $post->get_name() ?></a>
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link" href="#list-item-1"><i class="bi bi-chat-right-dots-fill"></i> Tất cả bình luận</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#list-item-2"><i class="bi bi-person"></i> Bình luận của bạn</a>
            </li>
            <li>
                <a class="nav-link" href="/post/post_new_comment.php?post-id=<?= $post->get_id() ?>"><i class="bi bi-plus"></i> Thêm bình luận</a>
            </li>
            <li>
                <form method="post">
                    <button class="btn btn-warning" id="delete-null-comment" name="delete-null-comment"><i class="bi bi-arrow-repeat"></i> Làm sạch các bình luận bỏ rống</button>
                </form>
            </li>
        </ul>
    </nav>

    <h2 style="margin-left: 10px; text-align: center;"><i class="bi bi-chat-fill"></i> <b>Bình luận cho bài viết: <?= $post->get_name() ?></b></h2>
    <div class="container">
        <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example bg-body-tertiary p-3 rounded-2" tabindex="0">
            <!--Tất cả bình luận-->
            <!--Hiển thị tất cả các bình luận-->
            <h4 id="list-item-1"><i class="bi bi-chat-right-dots-fill"></i> <b>Tất cả bình luận</b></h4>
            <div class="container">
                <?php
                if (count($post_comments) > 0) {
                    foreach ($post_comments as $comment) {
                ?>
                    <!--card chứa nội dung comment-->
                    <div class="card border-primary w-75 mb-3">
                        <div class="card-header">
                            <small class="text-body-secondary">Bình luận của: <b><?= $comment->get_user_phone_number() ?></b></small>,
                            <small class="text-body-secondary">Ngày đăng: <b><?= date("d-m-Y", $comment->get_created_date()) ?></b></small>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><?= $comment->get_content() ?></p>
                        </div>
                    </div>
                <?php
                    }
                } else {
                ?>
                <!--Nếu không có bình luận nào thì hiển thị thông báo-->
                <div class="alert alert-warning" role="alert">
                    <i class="bi bi-info-circle"></i> Hiện tại không có bình luận nào
                </div>
                <?php
                }
                ?>
            </div>

            <h4 id="list-item-2"><i class="bi bi-person"></i> <b>Bình luận của bạn</b></h4>
            <div class="container">
                <?php
                if (count($post_comments_of_user) > 0) {
                    foreach ($post_comments_of_user as $comment) {
                ?>
                <!--card chứa nội dung comment-->
                    <!--card chứa nội dung comment-->
                    <div class="card border-warning w-75 mb-3">
                        <div class="card-header">
                            <small class="text-body-secondary">Bình luận của: <b><?= $comment->get_user_phone_number() ?></b></small>,
                            <small class="text-body-secondary">Ngày đăng: <b><?= date("d-m-Y", $comment->get_created_date()) ?></b></small>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><?= $comment->get_content() ?></p>
                        </div>
                        <div class="card-footer">
                            <form method="post">
                                <a class="btn btn-warning" href="/post/post_update_comment.php?post-id=<?= $post->get_id() ?>&comment-id=<?= $comment->get_id() ?>"><i class="bi bi-pencil-square"></i> Chỉnh sửa</a>
                            </form>
                        </div>
                    </div>
                <?php
                    }
                } else {
                ?>
                <!--Hiển thị thông báo không có bình luận nào-->
                <div class="alert alert-warning" role="alert">
                    <i class="bi bi-info-circle"></i> Bạn chưa có bình luận nào về bài viết này
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php" ?> <!--footer-->
</body>
</html>