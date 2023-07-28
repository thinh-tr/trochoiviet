<?php
include "./entities/post_entity.php";

function get_10_newest_post(): array
{
    try {
        require "./connection_info.php";
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

function service_get_10_post(): array
{
    return get_10_newest_post();
}

?>
<?php
$var = service_get_10_post();
echo(gettype($var));
if (count($var) > 0) {
    foreach($var as $post) {
        echo("<p>{$post->get_name()}<p>");
    }
} else {
    echo("not found");
}
?>