<?php
namespace PostRepository;

// file game entity
include $_SERVER["DOCUMENT_ROOT"] . "/trochoiviet/entities/post_entity.php";

// Các hàm truy vấn thông tin từ database

/**
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
 * Truy vấn thông tin của post thông qua post_id (hỗ trợ hiển thị ở đầu trang nội dung),
 * input: post_id
 * output: obj Post chứa thông tin của post cần tìm | null -> không tìm thấy thông tin
 */
function select_post_by_id(string $post_id): \Entities\Post
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM post WHERE post.id = '$post_id'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();

        // Kiểm tra kết quả tìm được
        if ($result != false && count($result) > 0) {
            // trường hợp có kết quả tìm được
            $post = new \Entities\Post();   // biến chứa post cần trả ra

            $post->set_id($result[0]["id"]);    // gán id
            $post->set_name($result[0]["name"]);    // gán name
            $post->set_description($result[0]["description"]);  // gán description
            $post->set_cover_image_link($result[0]["cover_image_link"]);    // gán cover_image_link
            $post->set_created_date($result[0]["created_date"]);  // gán created_date
            $post->set_modified_date($result[0]["modified_date"] ?? $result[0]["created_date"]);    // modified_date
            $post->set_views($result[0]["views"]);  // views
            $post->set_admin_email($result[0]["admin_email"]);  // admin email

            // trả ra Post obj tìm được
            return $post;
        }
        // trường hợp không có kết quả
        return null;
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Truy vấn số lượt thích của một post
 * input: post_id
 * output: số lượt thích
 */
function select_post_like_number_by_post_id(string $post_id): int
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT count(post_likes.user_phone_number) AS likes
                FROM post_likes
                WHERE post_likes.post_id = '$post_id'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        // lấy ra kết quả cần tìm
        return $result[0]["likes"];
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Truy vấn số lượt comment của một post
 * input: post_id
 * output: số comment
 */
function select_post_comment_by_post_id(string $post_id): int
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT count(post_comment.id) AS comments
                FROM post_comment
                WHERE post_comment.post_id = '$post_id'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        // Lấy ra kết quả cần tìm
        return $result[0]["comments"];
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Tăng lượt views của post lên 1
 * input: post_id
 * output: void
 */
function update_post_views(string $post_id): void
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "UPDATE post SET post.views = post.views + 1 WHERE post.id = '$post_id'";
        $statement = $connection->prepare($sql);
        $statement->execute();  // thực hiện truy vấn
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Like và bỏ like
 * input: user_phone_number, post_id
 * output: void
 */
function update_post_likes(string $user_phone_number, string $post_id): void
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);

        // Kiểm tra xem người dùng này đã like post hay chưa
        $sql_like_checking = "SELECT * FROM post_likes WHERE post_likes.post_id = '$post_id' and post_likes.user_phone_number = '$user_phone_number'";
        $like_checking_statement = $connection->prepare($sql_like_checking);
        $like_checking_statement->execute();
        $is_liked = $like_checking_statement->fetchAll();
        // Kiểm tra kết quả
        if ($is_liked != false && count($is_liked) > 0) {
            // Trường hợp đã like -> tiến hành hủy like

        } else {
            // Trường hợp chưa like -> tiến hành like

        }
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Kiểm tra xem người dùng đã like một post nào đó hay chưa
 * input: post_id, user_phone_number
 * output: true -> đã like | false -> chưa like
 */
function is_liked_post(string $post_id, string $user_phone_number): bool
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM post_likes WHERE post_likes.post_id = '$post_id' and post_likes.user_phone_number = '$user_phone_number'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        if ($result != false && count($result) > 0) {
            // Trường hợp đã like
            return true;
        } else {
            // Trường hợp chưa like
            return false;
        }
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Thêm like cho post
 * input: post_id, user_phone_number
 * output: void
 */
function insert_like(string $post_id, string $user_phone_number): void
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $uniqid = uniqid();
        $sql = "INSERT INTO post_likes VALUES('$uniqid', '$post_id', '$user_phone_number');";
        $statement = $connection->prepare($sql);
        $statement->execute();  // chạy truy vấn
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Xóa like của post
 * input: post_id, user_phone_number
 * output: void
 */
function delete_like(string $post_id, string $user_phone_number): void
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "DELETE FROM post_likes WHERE post_likes.post_id = '$post_id' and post_likes.user_phone_number = '$user_phone_number'";
        $statement = $connection->prepare($sql);
        $statement->execute();  // chạy truy vấn
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }

}

/**
 * Thêm bình luận mới
 * input: obj PostComment
 * output: true -> Đăng tải thành công | false -> không thành công
 */
function insert_comment(\Entities\PostComment $post_comment): bool
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "INSERT INTO post_comment VALUES('{$post_comment->get_id()}', '{$post_comment->get_created_date()}', '{$post_comment->get_content()}', '{$post_comment->get_user_phone_number()}', '{$post_comment->get_post_id()}')";
        $statement = $connection->prepare($sql);
        return $statement->execute();   // trả ra kết quả truy vấn
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}