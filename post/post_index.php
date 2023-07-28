<?php
// script xử lý
include $_SERVER["DOCUMENT_ROOT"] . "/entities/post_entity.php";    // entity

/**
 * Repository
 * Truy vấn 10 bài đăng mới nhất
 * input: none
 * output: array chứa các bài đăng -> tìm thấy kết quả | array rỗng -> không có kết quả
 */
function repo_get_10_newest_post(): array
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM post ORDER BY post.created_date DESC LIMIT 10;";
        $statement = $connection->prepare($sql);
        $statement->execute();

        // Biến kết quả
        $newest_posts = array();
        $result = $statement->fetchAll();

        // Lấy ra kết quả truy vấn
        if ($result != false) {
            foreach ($result as $row) {
                $post = new \Entities\Post();   // post obj chứa thông tin của post
                $post->set_id($row["id"]);  // gán id
                $post->set_name($row["name"]);  // gán name
                $post->set_description($row["description"]);    // gán description
                $post->set_cover_image_link($row["cover_image_link"]);  // gán image link
                $post->set_created_date($row["created_date"]);  // gán created_date
                $post->set_modified_date($row["modified_date"] ?? $row["created_date"]);    // gán modified_date
                $post->set_admin_email($row["admin_email"]);    // gán admin_email
                array_push($newest_posts, $post);   // thêm post tìm được vào array
            }
            // Trả ra array chứa post mới nhất
            return $newest_posts;
        }

        // Nếu không có kết quả -> trả ra array rỗng
        return $newest_posts;

    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Service
 * Truy vấn 10 bài đăng mới nhất
 * input: none
 * output: array chứa các bài đăng -> tìm thấy kết quả | array rỗng -> không có kết quả
 */
function service_get_10_newest_post(): array
{
    return repo_get_10_newest_post();
}




/**
 * Repository
 * Truy vấn 10 bài viết có số lượt thích nhiều nhất
 * input: none
 * output: array chứa các bài đăng -> tìm thấy kết quả | array rỗng -> không có kết quả
 */
function repo_get_10_liked_post(): array
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql1 = "SELECT post_likes.post_id, count(post_likes.post_id) AS likes_number
                FROM post_likes
                GROUP BY post_likes.post_id
                ORDER BY likes_number DESC
                LIMIT 10;";
        $get_likes_number = $connection->prepare($sql1);
        $get_likes_number->execute();
        $likes_number_result = $get_likes_number->fetchAll();

        // Chuyển kết quả truy vấn (post_id) vào một array
        $most_liked_post_ids = array();
        foreach ($likes_number_result as $ids_and_likes) {
            array_push($most_liked_post_ids, $ids_and_likes["post_id"]);
        }

        // Biến chứa các post cần tìm
        $most_liked_posts = array();

        // Kiểm tra lại các post id tìm được
        if (count($most_liked_post_ids) > 0) {
            foreach ($most_liked_post_ids as $id) {
                // Truy vấn thông tin của post có id tương ứng
                $sql2 = "SELECT * FROM post WHERE post.id = '$id'";
                $get_post_info = $connection->prepare($sql2);
                $get_post_info->execute();
                $post_info = $get_post_info->fetchAll();
                $post = new \Entities\Post();
                // lấy ra từng thông tin của post
                foreach ($post_info as $row) {
                    $post->set_id($row["id"]);
                    $post->set_name($row["name"]);
                    $post->set_description($row["description"]);
                    $post->set_cover_image_link($row["cover_image_link"]);
                    $post->set_created_date($row["created_date"]);
                    $post->set_modified_date($row["modified_date"] ?? $row["created_date"]);
                    $post->set_admin_email($row["admin_email"]);
                }
                // push post tìm được vào array
                array_push($most_liked_posts, $post);
            }
            // trả ra array chứa các post cần tìm
            return $most_liked_posts;
        }
        // trả ra array rỗng nếu không tìm được kết quả
        return $most_liked_posts;
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Service
 * Truy vấn 10 bài viết có số lượt thích nhiều nhất
 * input: none
 * output: array chứa các bài đăng -> tìm thấy kết quả | array rỗng
 */
function service_get_10_liked_post(): array
{
    return repo_get_10_liked_post();
}



/**
 * Repository
 * Truy vấn 10 bài viết có số lượt bình luận nhiều nhất
 * input: none
 * output: array chứa các bài đăng -> tìm thấy kết quả | array rỗng -> không có kết quả
 */
function repo_get_10_most_commented_post(): array
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql1 = "SELECT post_comment.post_id, count(post_comment.id) AS comment_number
                FROM post_comment
                GROUP BY post_comment.post_id
                ORDER BY comment_number DESC
                LIMIT 10";
        $get_comment_number = $connection->prepare($sql1);
        $get_comment_number->execute();
        $comment_number_result = $get_comment_number->fetchAll();

        // Chuyển kết quả truy vấn (post_id) vào một array
        $most_commented_post_ids = array();
        foreach ($comment_number_result as $ids_and_comments) {
            array_push($most_commented_post_ids, $ids_and_comments["post_id"]);
        }

        // Biến chứa các post cần tìm
        $most_commented_posts = array();

        // Kiểm tra lại các post id tìm được
        if (count($most_commented_post_ids) > 0) {
            foreach ($most_commented_post_ids as $id) {
                // Truy vấn thông tin của post có id tương ứng
                $sql2 = "SELECT * FROM post WHERE post.id = '$id'";
                $get_post_info = $connection->prepare($sql2);
                $get_post_info->execute();
                $post_info = $get_post_info->fetchAll();
                $post = new \Entities\Post();
                // lấy ra từng thông tin của post
                foreach ($post_info as $row) {
                    $post->set_id($row["id"]);
                    $post->set_name($row["name"]);
                    $post->set_description($row["description"]);
                    $post->set_cover_image_link($row["cover_image_link"]);
                    $post->set_created_date($row["created_date"]);
                    $post->set_modified_date($row["modified_date"] ?? $row["created_date"]);
                    $post->set_admin_email($row["admin_email"]);
                }
                // push post tìm được vào array
                array_push($most_commented_posts, $post);
            }
            // trả ra array chứa các post cần tìm
            return $most_commented_posts;
        }
        // trả ra array rỗng nếu không tìm được kết quả
        return $most_commented_posts;
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Service
 * Truy vấn 10 bài viết có số lượt bình luận nhiều nhất
 * input: none
 * output: array chứa các bài đăng -> tìm thấy kết quả | array rỗng -> không có kết quả
 */
function service_get_10_most_commented_post(): array
{
    return repo_get_10_most_commented_post();
}



/**
 * Repository
 * Truy vấn ngẫu nhiên 3 bài viết
 * input: none
 * output: array chứa các bài đăng -> tìm thấy kết quả | array rỗng -> không có kết quả
 */
function repo_get_randomly_6_posts(): array
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM post ORDER BY rand() LIMIT 6";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();

        // Biến chứa kết quả cần trả ra
        $random_posts = array();

        if ($result != false) {
            // Lần lượt lấy ra thông tin của các post rồi push vào array
            foreach ($result as $row) {
                $post = new \Entities\Post();
                $post->set_id($row["id"]);
                $post->set_name($row["name"]);
                $post->set_description($row["description"]);
                $post->set_cover_image_link($row["cover_image_link"]);
                $post->set_created_date($row["created_date"]);
                $post->set_modified_date($row["modified_date"] ?? $row["created_date"]);
                $post->set_admin_email($row["admin_email"]);
                array_push($random_posts, $post);   // thêm post vào array chứa kết quả
            }
            // trả ra kết quả
            return $random_posts;
        }
        // trả ra array rỗng khi không tìm được kết quả
        return $random_posts;
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Service
 * Truy vấn ngẫu nhiên 3 bài viết
 * input: none
 * output: array chứa các bài đăng -> tìm thấy kết quả | array rỗng -> không có kết quả
 */
function service_get_randomly_6_posts(): array
{
    return repo_get_randomly_6_posts();
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
    <title>Bài đăng</title>
</head>
<style>
    h2 {
        font-weight: bold;
    }

    .card h5 {
        font-weight: bold;
    }

    div.col-4 {
        width: 20%;
    }
</style>

<body>
<?php include  $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?> <!--header-->
<?php include $_SERVER["DOCUMENT_ROOT"] . "/services/post_service.php"; ?>

<?php
// lấy ra danh sách các bài viết mới thêm gần đây
$newest_posts = service_get_10_newest_post();    // post mới
$most_liked_posts = service_get_10_liked_post(); // post được like nhiều nhất
$most_commented_posts = service_get_10_most_commented_post();    // post được comment nhiều nhất
$random_posts = service_get_randomly_6_posts(); //
?>

<div class="container">
    <!--scroll nav menu-->
    <nav id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
        <a class="navbar-brand" href="#"><i class="bi bi-card-list"></i> <b>Danh mục bài viết</b></a>
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link" href="#list-item-1"><i class="bi bi-newspaper"></i> Bài viết mới</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#list-item-2"><i class="bi bi-balloon-heart"></i> Bài viết được yêu thích</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#list-item-3"><i class="bi bi-chat"></i> Bài viết được bàn luận nhiều nhất</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#list-item-4"><i class="bi bi-lightbulb"></i> Có thể bạn quan tâm</a>
            </li>
        </ul>
    </nav>

    <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example bg-body-tertiary p-3 rounded-2" tabindex="0">
        <div class="container">
            <!--hiển thị các post mới nhất-->
            <h2 id="list-item-1"><i class="bi bi-newspaper"></i> Bài viết mới</h2>
            <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            if (count($newest_posts) > 0) {
                foreach($newest_posts as $post) {
                    // Hiển thị các bài viết mới
            ?>
                <div class="col">
                    <div class="card h-100">
                        <img src="<?= $post->get_cover_image_link() ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?= $post->get_name() ?></h5>
                            <p class="card-text"><?= $post->get_description() ?></p>
                            <a class="btn btn-primary" href="#">Đến xem</a>
                        </div>
                    <div class="card-footer">
                        <small class="text-body-secondary"><b>Đăng ngày:</b> <?= date("d-m-y" ,$post->get_created_date()) ?> <br> <b>Tác giả:</b> <?= $post->get_admin_email() ?></small>
                    </div>
                    </div>
                </div>
            <?php
                }
            } else {
            ?>
            <!--Hiển thị place holder vì không tìm thấy kết quả-->
                <div class="card" aria-hidden="true">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title placeholder-glow">
                            <span class="placeholder col-6"></span>
                        </h5>
                        <p class="card-text placeholder-glow">
                            <span class="placeholder col-7"></span>
                            <span class="placeholder col-4"></span>
                            <span class="placeholder col-4"></span>
                            <span class="placeholder col-6"></span>
                            <span class="placeholder col-8"></span>
                        </p>
                        <a class="btn btn-primary disabled placeholder col-6" aria-disabled="true"></a>
                    </div>
                </div>
            <?php
            }
            ?>
            </div><br>

            <!--Bài viết có số lượt thích nhiều nhất-->
            <h2 id="list-item-2"><i class="bi bi-balloon-heart"></i> Bài viết được yêu thích</h2>
            <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            if (count($most_liked_posts) > 0) {
                foreach($most_liked_posts as $post) {
                    // Hiển thị các bài viết mới
            ?>
                <div class="col">
                    <div class="card h-100">
                        <img src="<?= $post->get_cover_image_link() ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?= $post->get_name() ?></h5>
                            <p class="card-text"><?= $post->get_description() ?></p>
                            <a class="btn btn-primary" href="#">Đến xem</a>
                        </div>
                    <div class="card-footer">
                        <small class="text-body-secondary"><b>Đăng ngày:</b> <?= date("d-m-y" ,$post->get_created_date()) ?> <br> <b>Tác giả:</b> <?= $post->get_admin_email() ?></small>
                    </div>
                    </div>
                </div>
            <?php
                }
            } else {
            ?>
            <!--Hiển thị place holder vì không tìm thấy kết quả-->
                <div class="card" aria-hidden="true">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title placeholder-glow">
                            <span class="placeholder col-6"></span>
                        </h5>
                        <p class="card-text placeholder-glow">
                            <span class="placeholder col-7"></span>
                            <span class="placeholder col-4"></span>
                            <span class="placeholder col-4"></span>
                            <span class="placeholder col-6"></span>
                            <span class="placeholder col-8"></span>
                        </p>
                        <a class="btn btn-primary disabled placeholder col-6" aria-disabled="true"></a>
                    </div>
                </div>
            <?php
            }
            ?>
            </div><br>

            <!--Bài viết có số lượt comment nhiều nhất-->
            <h2 id="list-item-3"><i class="bi bi-chat"></i> Bài viết được bàn luận nhiều nhất</h2>
            <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            if (count($most_commented_posts) > 0) {
                foreach($most_commented_posts as $post) {
                    // Hiển thị các bài viết mới
            ?>
                <div class="col">
                    <div class="card h-100">
                        <img src="<?= $post->get_cover_image_link() ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?= $post->get_name() ?></h5>
                            <p class="card-text"><?= $post->get_description() ?></p>
                            <a class="btn btn-primary" href="#">Đến xem</a>
                        </div>
                    <div class="card-footer">
                        <small class="text-body-secondary"><b>Đăng ngày:</b> <?= date("d-m-y" ,$post->get_created_date()) ?> <br> <b>Tác giả:</b> <?= $post->get_admin_email() ?></small>
                    </div>
                    </div>
                </div>
            <?php
                }
            } else {
            ?>
            <!--Hiển thị place holder vì không tìm thấy kết quả-->
                <div class="card" aria-hidden="true">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title placeholder-glow">
                            <span class="placeholder col-6"></span>
                        </h5>
                        <p class="card-text placeholder-glow">
                            <span class="placeholder col-7"></span>
                            <span class="placeholder col-4"></span>
                            <span class="placeholder col-4"></span>
                            <span class="placeholder col-6"></span>
                            <span class="placeholder col-8"></span>
                        </p>
                        <a class="btn btn-primary disabled placeholder col-6" aria-disabled="true"></a>
                    </div>
                </div>
            <?php
            }
            ?>
            </div><br>

            <!--Bài viết đề xuất-->
            <h2 id="list-item-4"><i class="bi bi-lightbulb"></i> Có thể bạn quan tâm</h2>
            <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            if (count($random_posts) > 0) {
                foreach($random_posts as $post) {
                    // Hiển thị các bài viết mới
            ?>
                <div class="col">
                    <div class="card h-100">
                        <img src="<?= $post->get_cover_image_link() ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?= $post->get_name() ?></h5>
                            <p class="card-text"><?= $post->get_description() ?></p>
                            <a class="btn btn-primary" href="#">Đến xem</a>
                        </div>
                    <div class="card-footer">
                        <small class="text-body-secondary"><b>Đăng ngày:</b> <?= date("d-m-y" ,$post->get_created_date()) ?> <br> <b>Tác giả:</b> <?= $post->get_admin_email() ?></small>
                    </div>
                    </div>
                </div>
            <?php
                }
            } else {
            ?>
            <!--Hiển thị place holder vì không tìm thấy kết quả-->
                <div class="card" aria-hidden="true">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title placeholder-glow">
                            <span class="placeholder col-6"></span>
                        </h5>
                        <p class="card-text placeholder-glow">
                            <span class="placeholder col-7"></span>
                            <span class="placeholder col-4"></span>
                            <span class="placeholder col-4"></span>
                            <span class="placeholder col-6"></span>
                            <span class="placeholder col-8"></span>
                        </p>
                        <a class="btn btn-primary disabled placeholder col-6" aria-disabled="true"></a>
                    </div>
                </div>
            <?php
            }
            ?>
            </div>
        </div>
    </div>
</div>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php"; ?> <!--footer-->
</body>
</html>