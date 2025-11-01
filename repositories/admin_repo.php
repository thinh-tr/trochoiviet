<?php
namespace AdminRepositories;

use function PostRepository\select_posts_by_admin_email;

include $_SERVER["DOCUMENT_ROOT"] . "/entities/admin_entity.php";


/**
 * Thêm admin mới vào db
 * input: array chứa thông tin admin mới cần lưu
 * output: true -> tạo thành công | false -> không thành công
 */
function insert_admin(\Entities\AdminInfo $new_admin): bool {
    // Giả sử các tham số có trong $new_admin đều đã được kiểm tra ở service
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";  // yêu cầu file thông tin để kết nối với db
        $connection = new \PDO($dsn, $username, $db_password);  // Khởi tạo connection
        $sql = sprintf(
            "INSERT INTO admin_info VALUES('%s', '%s', '%s', '%s', %u, '%s')",
            $new_admin->get_email(),
            $new_admin->get_password(),
            $new_admin->get_name(),
            $new_admin->get_phone_number(),
            $new_admin->get_join_date(),
            $new_admin->get_self_intro(),
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
function repo_login(string $email, string $password): bool {
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
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
        echo ("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Lấy ra toàn bộ thông tin của AdminInfo thông qua email
 * input: username
 * output: AdminInfo obj -> có tồn tại thông tin | null -> không tồn tại thông tin
 */
function select_admininfo_by_email(string $email): \Entities\AdminInfo {
    // Giả sử các tham số đầu vào đều đã được kiểm tra ở service
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);  // Khởi tạo connection
        $sql = sprintf("SELECT * FROM admin_info WHERE admin_info.email = '%s'", $email);
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        // chuyển kết quả từ dạng array về php obj
        if ($result != false) {
            foreach ($result as $row) {
                $admin_email = $row["email"];
                $admin_password = $row["password"];
                $admin_name = $row["name"];
                $admin_phone_numer = $row["phone_number"];
                $admin_join_date = $row["join_date"];
                $admin_self_intro = $row["self_introduction"];
            }
            // gán thông tin vào obj AdminInfo
            $login_admin = new \Entities\AdminInfo();
            $login_admin->set_email($admin_email);
            $login_admin->set_password($admin_password);
            $login_admin->set_name($admin_name);
            $login_admin->set_phone_number($admin_phone_numer ?? "");
            $login_admin->set_join_date($admin_join_date ?? "");
            $login_admin->set_self_intro($admin_self_intro ?? "");
            return $login_admin;    // Trả ra admin cần login
        } else {
            return null;    // Trả ra null khi không thể xác định thông tin đăng nhập
        }
    } catch (\PDOException $ex) {
        echo ("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Cập nhật thông tin admin
 * input: name, phone_number, self_intro
 * output: true -> update thành công | false -> không thành công
 */
function update_admininfo_by_email(string $email, string $name, string $phone_number, string $self_intro): bool {
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "UPDATE admin_info
               SET admin_info.name = '$name',
               admin_info.phone_number = '$phone_number',
               admin_info.self_introduction = '$self_intro'
               WHERE admin_info.email = '$email'";
        $statement = $connection->prepare($sql);
        return $statement->execute();   // true nếu update thành công
    } catch (\PDOException $ex) {
        echo ("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Cập nhật password
 * input: admin_email, new_password
 * output: true -> update thành công | false -> không thành công
 */
function update_admin_password(string $email, string $new_password): bool {
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "UPDATE admin_info SET admin_info.password = '$new_password' WHERE admin_info.email = '$email'";
        $statement = $connection->prepare($sql);
        return $statement->execute();   // Trả ra kết quả truy vấn
    } catch (\PDOException $ex) {
        echo ("Errors occurs when querying data: " . $ex->getMessage());
    }
}

/**
 * Lấy ra password hiện tại của admin
 * input: admin_email
 * output: password -> thành công | string rỗng -> không tìm thấy
 */
function select_current_admin_password(string $email): string {
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT admin_info.password FROM admin_info WHERE admin_info.email = '$email'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $current_password = $row["password"];
        }
        return $current_password;   // trả ra password cần lấy
    } catch (\PDOException $ex) {
        echo ("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Kiểm tra xem email đã được đăng ký hay chưa
 * input: email
 * output: true -> đã được đăng ký | false -> chưa được đăng ký
 */
function is_used_admin_info(string $email): bool {
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM admin_info WHERE admin_info.email = '$email'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        if (count($result) > 0) {
            return true;
        }
        return false;
    } catch (\PDOException $ex) {
        echo ("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Lấy ra tất cả admin_email có trong database
 * input: none
 * output: array chứa tất cả admin_email | array rỗng -> không có kết quả
 */
function select_all_admin_email(): array {
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT DISTINCT admin_info.email FROM admin_info";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $admin_email_array = array();   // array chứa các admin_email
        // Kiểm tra kết quả trả về
        if ($result != false && count($result) > 0) {
            foreach ($result as $row) {
                array_push($admin_email_array, $row["email"]);  // push email tìm được vào array
            }
        }
        return $admin_email_array;  // trả ra array kết quả
    } catch (\PDOException $ex) {
        echo ("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Tạo QR CODE mới
 * input: QRCode obj
 * output: void
 */
function insert_qr_code_link(\Entities\QRCode $qr_code): void {
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "INSERT INTO qr_code VALUES('{$qr_code->get_id()}', '{$qr_code->get_admin_email()}', '{$qr_code->get_qr_code_link()}')";
        $statement = $connection->prepare($sql);
        $statement->execute();  // Thực hiện truy vấn
    } catch (\PDOException $ex) {
        echo ("Errors occur when querying data: " . $ex->getMessage());
    }
}


/**
 * Lấy ra thông tin của QRCode theo admin_email
 * input: admin_email
 * output: QRCode obj | null -> không có kết quả
 */
function select_qr_code_by_admin_email(string $admin_email): \Entities\QRCode|null {
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM qr_code WHERE qr_code.admin_email = '$admin_email'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        // Kiểm tra kết quả trả về
        if ($result != false && count($result) > 0) {
            // Lấy ra thông tin ở row[0]
            $qr_code = new \Entities\QRCode();
            $qr_code->set_id($result[0]["id"]);
            $qr_code->set_admin_email($result[0]["admin_email"]);
            $qr_code->set_qr_code_link($result[0]["qr_code_link"]);
            return $qr_code;    // trả ra qr_code cần tìm
        }
        return null;
    } catch (\PDOException $ex) {
        echo ("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Xóa QR code của admin
 * input: admin_email
 * output: void
 */
function delete_qr_code_by_admin_email(string $admin_email): void {
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "DELETE FROM qr_code WHERE qr_code.admin_email = '$admin_email'";
        $statement = $connection->prepare($sql);
        $statement->execute();  // Thực hiện truy vấn
    } catch (\PDOException $ex) {
        echo ("Errors occur when querying data: " . $ex->getMessage());
    }
}


/**
 * Xóa tài khoản admin
 * input: (string) admin-email
 * output: void
 */
function delete_admin_info($admin_email): void {
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "DELETE FROM `admin_info` WHERE `admin_info`.email = '$admin_email'";
        $statement = $connection->prepare($sql);
        $statement->execute();  // Thực hiện truy vấn
    } catch (\PDOException $ex) {
        echo ("Errors occur when querying data: " . $ex->getMessage());
    }
}