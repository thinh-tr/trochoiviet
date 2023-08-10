<?php
namespace ProductRepository;

include $_SERVER["DOCUMENT_ROOT"] . "/entities/product_entity.php";

/**
 * Lấy ra tất cả các product của một admin được chỉ định
 * input: admin_email
 * output: array chứa các Product obj | array rỗng -> không có kết quả nào
 */
function select_product_by_admin_email(string $admin_email): array
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM product WHERE product.admin_email = '$admin_email'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $product_array = array();
        // Kiểm tra kết quả tìm được
        if ($result != false && count($result) > 0) {
            // lần lượt lấy ra các product tìm được
            foreach ($result as $row) {
                $product = new \Entities\Product();
                $product->set_id($row["id"]);
                $product->set_name($row["name"]);
                $product->set_cover_image_link($row["cover_image_link"]);
                $product->set_description($row["description"]);
                $product->set_retail_price($row["retail_price"]);
                $product->set_remain_quantity($row["remain_quantity"]);
                $product->set_admin_email($row["admin_email"]);
                array_push($product_array, $product);
            }
        }
        return $product_array;  // trả ra danh sách product
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Thêm product mới
 * input: obj Product
 * output: void
 */
function insert_product(\Entities\Product $product): void
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "INSERT INTO product VALUES('{$product->get_id()}', '{$product->get_name()}', '{$product->get_cover_image_link()}', '{$product->get_description()}', {$product->get_retail_price()}, {$product->get_remain_quantity()}, '{$product->get_admin_email()}')";
        $statement = $connection->prepare($sql);
        $statement->execute();  // thực hiện truy vấn
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Lấy ra thông tin product theo product_id
 * input: product_id
 * output: Post obj | null -> không tìm thấy kết quả
 */
function select_product_by_product_id(string $product_id): \Entities\Product
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM product WHERE product.id = '$product_id'";
        $statement = $connection->prepare($sql);
        $statement->execute();  // thực hiện truy vấn
        $result = $statement->fetchAll();
        $product = null;    // biến chứa kết quả
        // Kiểm tra kết quả trả về
        if ($result != false && count($result) > 0) {
            $product = new \Entities\Product();
            $product->set_id($result[0]["id"]);
            $product->set_name($result[0]["name"]);
            $product->set_cover_image_link($result[0]["cover_image_link"]);
            $product->set_description($result[0]["description"]);
            $product->set_retail_price($result[0]["retail_price"]);
            $product->set_remain_quantity($result[0]["remain_quantity"]);
            $product->set_admin_email($result[0]["admin_email"]);
        }
        // Trả ra kết quả
        return $product;
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Cập nhật thông tin product
 * input:  id, name, cover_image, description, retail_price, remain_quantity
 * output: void
 */
function update_product(string $product_id, string $name, string $cover_image, string $description, int $retail_price, int $remain_quantity): void
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "UPDATE product SET product.name = '$name', product.cover_image_link = '$cover_image', product.description = '$description', product.retail_price = $retail_price, product.remain_quantity = $remain_quantity WHERE product.id = '$product_id'";
        $statement = $connection->prepare($sql);
        $statement->execute();  // thực hiện truy vấn
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}