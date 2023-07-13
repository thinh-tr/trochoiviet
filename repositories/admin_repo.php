<?php
namespace Repositories;

include $_SERVER["DOCUMENT_ROOT"] . "/trochoiviet/entities/admin_info.php";


/**
 * Thêm admin mới vào db
 * input: array chứa thông tin admin mới cần lưu
 * output: true -> tạo thành công | false -> không thành công
 */
function insert_admin(\Entities\AdminInfo $new_admin): bool
{
    // Giả sử các tham số có trong $new_admin đều đã được kiểm tra ở service
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/trochoiviet/connection_info.php";  // yêu cầu file thông tin để kết nối với db
        $connection = new \PDO($dsn, $username, $db_password);  // Khởi tạo connection
        $sql = sprintf(
            "INSERT INTO admin_info VALUES('%s', '%s', '%s', '%s', %u, '%s')",
            $new_admin->get_email(),
            $new_admin->get_password(),
            $new_admin->get_name(),
            $new_admin->get_phone_number(),
            $new_admin->get_join_date(),
            $new_admin->get_self_intro()
        );
        // tiến hành truy vấn thêm dữ liệu
        // Tạo statement
        $statement = $connection->prepare($sql);
        $execution_result = $statement->execute();
        return $execution_result;
    } catch (\PDOException $ex) {
        echo ("Errors occur when querying data: " . $ex->getMessage());
        //return false;
    }
}

/**
 * Login
 * input: email, password
 * output: true -> login thành công | false -> không thành công
 */
function repo_login(string $email, string $password): bool
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/trochoiviet/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = sprintf("SELECT * FROM admin_info WHERE admin_info.email = '%s' AND admin_info.password = '%s'", $email, $password);
        $statement = $connection->prepare($sql);
        $statement->execute();
        $login_admin = $statement->fetchAll();
        // Kiểm tra thông tin truy vấn
        if (count($login_admin) > 0) {
            return true;
        } else {
            return false;
        }
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Lấy ra toàn bộ thông tin của AdminInfo thông qua email
 * input: username
 * output: AdminInfo obj -> login thành công | null -> không thành công
 */
function select_admininfo_by_username_password(string $email): \Entities\AdminInfo
{
    // Giả sử các tham số đầu vào đều đã được kiểm tra ở service
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/trochoiviet/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);  // Khởi tạo connection
        $sql = sprintf("SELECT * FROM admin_info WHERE admin_info.email = '%s'", $email);
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        // chuyển kết quả từ dạng array về php obj
        if ($result != false) {
            $login_admin = new \Entities\AdminInfo(
                $result["email"],
                $result["password"],
                $result["name"],
                $result["phone_number"],
                $result["join_date"],
                $result["self_introduction"]
            );
            return $login_admin;    // Trả ra admin cần login
        } else {
            return null;    // Trả ra null khi không thể xác định thông tin đăng nhập
        }
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}