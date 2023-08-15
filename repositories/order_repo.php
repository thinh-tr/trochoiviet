<?php
namespace OrderRepository;

include $_SERVER["DOCUMENT_ROOT"] . "/entities/order_entity.php";

/**
 * Tạo Order
 * input: Order obj
 * output: void
 */
function insert_order(\Entities\Order $order): void
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "INSERT INTO `order`  VALUES('{$order->get_id()}', '{$order->get_state()}', {$order->get_payment_state()}, {$order->get_order_date()}, {$order->get_delivery_date()}, '{$order->get_delivery_address()}', '{$order->get_user_phone_number()}', '{$order->get_admin_email()}')";
        $statement = $connection->prepare($sql);
        $statement->execute();  // Thực hiện truy vấn
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Tạo OrderDetail
 * input: OrderDetail obj
 * output: void
 */
function insert_order_detail(\Entities\OrderDetail $order_detail): void
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "INSERT INTO order_detail VALUES('{$order_detail->get_id()}', '{$order_detail->get_order_id()}', '{$order_detail->get_product_id()}', {$order_detail->get_retail_price()}, {$order_detail->get_product_quantity()}, {$order_detail->get_total_price()})";
        $statement = $connection->prepare($sql);
        $statement->execute();  // Thực hiện truy vấn
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}