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

/**
 * Xóa bình luận được chọn
 * input: comment_id
 * output: true -> xóa thành công | fasle -> không thành công
 */
function delete_comment(string $comment_id): void
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "DELETE FROM post_comment WHERE post_comment.id = '$comment_id'";
        $statement = $connection->prepare($sql);
        $statement->execute();  // xóa comment
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Lấy ra thông tin post_comment theo id
 * input: comment_id
 * output: obj PostComment -> tìm thấy thông tin | null -> không tìm thấy
 */
function select_comment_by_id(string $comment_id): \Entities\PostComment
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . '/connection_info.php';
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM post_comment WHERE post_comment.id = '$comment_id'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $comment = null;
        // Kiểm tra kết quả
        if ($result != false && count($result) > 0) {
            $comment = new \Entities\PostComment();
            // lấy ra kết quả
            $comment->set_id($result[0]["id"]);
            $comment->set_created_date($result[0]["created_date"]);
            $comment->set_content($result[0]["content"]);
            $comment->set_user_phone_number($result[0]["user_phone_number"]);
            $comment->set_post_id($result[0]["post_id"]);
        }
        // trường hợp không tìm ra kết quả
        return $comment;
    } catch (\PDOException $ex) {
        echo("Error occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Cập nhật nội dung cho các bình luận
 * input: comment_id, content
 * output: void
 */
function update_comment_content(string $comment_id, string $content): void
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . '/connection_info.php';
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "UPDATE post_comment SET post_comment.content = '$content' WHERE post_comment.id = '$comment_id'";
        $statement = $connection->prepare($sql);
        $statement->execute();  // chạy lệnh truy vấn
    } catch (\PDOException $ex) {
        echo("Error occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Thêm post vào mục post được theo dõi của user
 * input: UserPostFollow
 * output: bool
 */
function insert_user_post_follow(string $user_phone_number, string $post_id): void
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $uniqid = uniqid();
        $sql = "INSERT INTO user_post_follow VALUES('$uniqid', '$user_phone_number', '$post_id')";
        $statement = $connection->prepare($sql);
        $statement->execute();   // trả ra kết quả truy vấn
    } catch (\PDOException $ex) {
        echo("Error occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Xóa user post follow
 * input: user_post_follow_id
 * output: void
 */
function delete_user_post_follow(string $user_phone_number, string $post_id): void
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "DELETE FROM user_post_follow WHERE user_post_follow.user_phone_number = '$user_phone_number' AND user_post_follow.post_id = '$post_id'";
        $statement = $connection->prepare($sql);
        $statement->execute();   // Xóa follow được chọn
    } catch (\PDOException $ex) {
        echo("Error occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Kiểm tra xem user đã follow post hay chưa
 * input: user_phone_number, post_id
 * output: true -> đã follow | false -> chưa follow
 */
function is_post_followed(string $user_phone_number, string $post_id): bool
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM user_post_follow WHERE user_post_follow.user_phone_number = '$user_phone_number' AND user_post_follow.post_id = '$post_id'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        if (count($result) > 0) {
            return true;    // đã follow
        } else {
            return false;   // chưa follow
        }
    } catch (\PDOException $ex) {
        echo("Error occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Lấy ra danh sách post được like bởi một user chỉ định
 * input: user_phone_number
 * output: array chứa post obj | array rỗng -> không có kết quả
 */
function select_liked_posts_by_user_phone_number(string $user_phone_number): array
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT post_likes.post_id FROM post_likes WHERE post_likes.user_phone_number = '$user_phone_number'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $liked_posts_array = array();
        // Lấy ra kết quả
        if (count($result) > 0) {
            foreach ($result as $row) {
                $post = select_post_by_id($row["post_id"]);    // lấy ra post obj tương ứng với id
                array_push($liked_posts_array, $post);  // thêm post tìm được vào array kết quả
            }
        }
        return $liked_posts_array; // trả ra biến kết quả
    } catch (\PDOException $ex) {
        echo("Error occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Lấy ra danh sách post được follow bởi một user chỉ định,
 * input: user_phone_number,
 * output: array chứa post obj | array rỗng -> không có kết quả
 */
function select_follow_posts_by_user_phone_number(string $user_phone_number): array
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM user_post_follow WHERE user_post_follow.user_phone_number = '$user_phone_number'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $follow_posts_array = array();
        // Lấy ra kết quả
        if (count($result) > 0) {
            foreach ($result as $row) {
                $post = select_post_by_id($row["post_id"]);    // lấy ra post obj tương ứng với id
                array_push($follow_posts_array, $post);  // thêm post tìm được vào array kết quả
            }
        }
        return $follow_posts_array; // trả ra biến kết quả
    } catch (\PDOException $ex) {
        echo("Error occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Lấy tất cả các post được tạo bởi một admin chỉ định
 * input: admin_email
 * output: array chứa Post obj | array rỗng -> không có kết quả
 */
function select_posts_by_admin_email(string $admin_email): array
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM post WHERE post.admin_email = '$admin_email'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        // Kiểm tra kết quả tìm được
        $post_array = array();  // array chứa kết quả trả về
        if (count($result) > 0) {
            foreach ($result as $row) {
                $post = new \Entities\Post();
                $post->set_id($row["id"]);
                $post->set_name($row["name"]);
                $post->set_description($row["description"]);
                $post->set_cover_image_link($row["cover_image_link"]);
                $post->set_created_date($row["created_date"]);
                $post->set_modified_date($row["modified_date"] ?? $row["created_date"]);
                $post->set_views($row["views"]);
                $post->set_admin_email($row["admin_email"]);
                // push post vừa tìm được vào array kết quả
                array_push($post_array, $post);
            }
        }
        // trả ra array kết quả
        return $post_array;
    } catch (\PDOException $ex) {
        echo("Error occur when querying data: " . $ex->getMessage());
    }
}


/**
 * Repository
 * Lấy ra array chứa các post_content của một post theo post id
 * input: post_id
 * output: array chứa post_content -> có kết quả | array rỗng -> không có kết quả
 */
function select_post_contents_by_post_id(string $post_id): array
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
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
 * Repository
 * Lấy ra thông tin của các PostContentImage thông qua post_content_id
 * input: post_content_id
 * output: array chứa các PosrtContentImage -> tìm thấy kết quả | array rỗng -> không tìm thấy kết quả
 */
function select_post_content_image_by_post_content_id(string $post_content_id): array
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
 * Repository
 * Lấy ra array chứa thông tin của các video được nhúng trong bài post
 * input: post_id
 * output: array chứa các video link của bài post -> có kết quả | array rỗng -> không có kết quả
 */
function select_post_video_by_post_id(string $post_id): array
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
                $post_video->set_video_source($row["video_source"]);
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
 * Tìm kiếm bài viết theo tên
 * input: post_name
 * output: array post obj | array rỗng -> không có kết quả
 */
function select_post_by_keyword(string $keyword): array
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM post WHERE post.name LIKE '%$keyword%'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $search_array = array();    // array chứa kết quả tìm kiếm
        // Kiểm tra kết quả trả về
        if (count($result) > 0) {
            foreach ($result as $row) {
                $post = new \Entities\Post();
                $post->set_id($row["id"]);
                $post->set_name($row["name"]);
                $post->set_description($row["description"]);
                $post->set_cover_image_link($row["cover_image_link"]);
                $post->set_created_date($row["created_date"]);
                $post->set_modified_date($row["modified_date"] ?? $row["created_date"]);
                $post->set_views($row["views"]);
                $post->set_admin_email($row["admin_email"]);
                array_push($search_array, $post);   // push post tìm được vào array kết quả
            }
        }
        // trả ra kết quả
        return $search_array;
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Cập nhật thông tin của Post theo post_id
 * input: post_id, post_name, post_description, post_cover_image, post_modified_date, post_views
 * output: void
 */
function update_post_info_by_post_id(string $post_id, string $post_name, string $post_description, string $post_cover_image_link, int $post_modified_date, int $post_views): void
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "UPDATE post
                SET post.name = '$post_name',
                    post.description = '$post_description',
                    post.cover_image_link = '$post_cover_image_link',
                    post.modified_date = $post_modified_date,
                    post.views = $post_views
                WHERE post.id = '$post_id'";
        $statement = $connection->prepare($sql);
        $statement->execute();  // thực hiện truy vấn
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}