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