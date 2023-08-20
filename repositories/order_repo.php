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

/**
 * Lấy ra array chứa các đơn hàng chưa comfirm
 * input: user_phone_number
 * output: Order array | array rỗng -> không tìm thấy thông tin
 */
function select_not_confirm_order_by_user_phone_number(string $user_phone_number): array
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM `order` WHERE `order`.state = 'not_confirm' and `order`.user_phone_number = '$user_phone_number'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $order_array = array(); // array chứa kết quả trả về
        
        // Kiểm tra kết quả truy vấn
        if ($result != false && count($result) > 0) {
            foreach ($result as $row) {
                $order = new \Entities\Order();
                $order->set_id($row["id"]);
                $order->set_state($row["state"]);
                $order->set_payment_state($row["payment_state"]);
                $order->set_order_date($row["order_date"]);
                $order->set_delivery_date($row["delivery_date"]);
                $order->set_user_phone_number($row["user_phone_number"]);
                $order->set_admin_email($row["admin_email"]);
                array_push($order_array, $order);   // push order tìm được vào array
            }
        }
        // trả ra kết quả
        return $order_array;
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Lấy ra các đơn hàng đang chờ xử lý
 * input: user_phone_number
 * output: Order array | array rỗng -> không tìm thấy thông tin
 */
function select_is_waiting_order_by_user_phone_number(string $user_phone_number): array
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM `order` WHERE `order`.state = 'is_waiting' and `order`.user_phone_number = '$user_phone_number'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $order_array = array(); // array chứa kết quả trả về
        
        // Kiểm tra kết quả truy vấn
        if ($result != false && count($result) > 0) {
            foreach ($result as $row) {
                $order = new \Entities\Order();
                $order->set_id($row["id"]);
                $order->set_state($row["state"]);
                $order->set_payment_state($row["payment_state"]);
                $order->set_order_date($row["order_date"]);
                $order->set_delivery_date($row["delivery_date"]);
                $order->set_user_phone_number($row["user_phone_number"]);
                $order->set_admin_email($row["admin_email"]);
                array_push($order_array, $order);   // push order tìm được vào array
            }
        }
        // trả ra kết quả
        return $order_array;
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Lấy ra các đơn hàng đang được xử lý
 * input: user_phone_number
 * output: Order array | array rỗng -> không tìm thấy thông tin
 */
function select_is_processing_order_by_user_phone_number(string $user_phone_number): array
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM `order` WHERE `order`.state = 'is_received' or `order`.state = 'is_shipping' AND `order`.user_phone_number = '$user_phone_number'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $order_array = array(); // array chứa kết quả trả về
        
        // Kiểm tra kết quả truy vấn
        if ($result != false && count($result) > 0) {
            foreach ($result as $row) {
                $order = new \Entities\Order();
                $order->set_id($row["id"]);
                $order->set_state($row["state"]);
                $order->set_payment_state($row["payment_state"]);
                $order->set_order_date($row["order_date"]);
                $order->set_delivery_date($row["delivery_date"]);
                $order->set_user_phone_number($row["user_phone_number"]);
                $order->set_admin_email($row["admin_email"]);
                array_push($order_array, $order);   // push order tìm được vào array
            }
        }
        // trả ra kết quả
        return $order_array;
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Lấy ra các đơn hàng đã hoàn tất
 * input: user_phone_number
 * output: Order array | array rỗng -> không tìm thấy thông tin
 */
function select_is_finished_order_by_user_phone_number(string $user_phone_number): array
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM `order` WHERE `order`.state = 'is_finished' AND `order`.user_phone_number = '$user_phone_number'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $order_array = array(); // array chứa kết quả trả về
        
        // Kiểm tra kết quả truy vấn
        if ($result != false && count($result) > 0) {
            foreach ($result as $row) {
                $order = new \Entities\Order();
                $order->set_id($row["id"]);
                $order->set_state($row["state"]);
                $order->set_payment_state($row["payment_state"]);
                $order->set_order_date($row["order_date"]);
                $order->set_delivery_date($row["delivery_date"]);
                $order->set_user_phone_number($row["user_phone_number"]);
                $order->set_admin_email($row["admin_email"]);
                array_push($order_array, $order);   // push order tìm được vào array
            }
        }
        // trả ra kết quả
        return $order_array;
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Lấy ra các đơn hàng đã bị hủy
 * input: user_phone_number
 * output: Order array | array rỗng -> không tìm thấy thông tin
 */
function select_is_canceled_order_by_user_phone_number(string $user_phone_number): array
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM `order` WHERE `order`.state = 'is_canceled' AND `order`.user_phone_number = '$user_phone_number'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $order_array = array(); // array chứa kết quả trả về
        
        // Kiểm tra kết quả truy vấn
        if ($result != false && count($result) > 0) {
            foreach ($result as $row) {
                $order = new \Entities\Order();
                $order->set_id($row["id"]);
                $order->set_state($row["state"]);
                $order->set_payment_state($row["payment_state"]);
                $order->set_order_date($row["order_date"]);
                $order->set_delivery_date($row["delivery_date"]);
                $order->set_user_phone_number($row["user_phone_number"]);
                $order->set_admin_email($row["admin_email"]);
                array_push($order_array, $order);   // push order tìm được vào array
            }
        }
        // trả ra kết quả
        return $order_array;
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Lấy ra thông tin order được chỉ định
 * input: order_id
 * output: Order obj | null -> không có kết quả
 */
function select_order_by_order_id(string $order_id): \Entities\Order | null
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM `order` WHERE `order`.id = '$order_id'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $order = null;
        // Kiểm tra kết quả truy vấn
        if ($result != false && count($result) > 0) {
            $order = new \Entities\Order();
            $order->set_id($result[0]["id"]);
            $order->set_state($result[0]["state"]);
            $order->set_payment_state($result[0]["payment_state"]);
            $order->set_order_date($result[0]["order_date"]);
            $order->set_delivery_date($result[0]["delivery_date"]);
            $order->set_delivery_address($result[0]["delivery_address"]);
            $order->set_user_phone_number($result[0]["user_phone_number"]);
            $order->set_admin_email($result[0]["admin_email"]);
        }
        return $order;
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}


/**
 * Lấy ra array chứa các order_detail của một order chỉ định
 */
function select_order_details_by_order_id(string $order_id): array
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM `order_detail` WHERE `order_detail`.order_id = '$order_id'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $order_detail_array = array(); // array chứa kết quả trả về
        
        // Kiểm tra kết quả truy vấn
        if ($result != false && count($result) > 0) {
            foreach ($result as $row) {
                $order_detail = new \Entities\OrderDetail();
                $order_detail->set_id($row["id"]);
                $order_detail->set_order_id($row["order_id"]);
                $order_detail->set_product_id($row["product_id"]);
                $order_detail->set_retail_price($row["retail_price"]);
                $order_detail->set_product_quantity($row["product_quantity"]);
                $order_detail->set_total_price($row["total_price"]);
                array_push($order_detail_array, $order_detail);   // push order tìm được vào array
            }
        }
        // trả ra kết quả
        return $order_detail_array;
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}