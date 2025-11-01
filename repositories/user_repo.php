<?php
namespace UserRepository;

// user entities
include $_SERVER["DOCUMENT_ROOT"] . "/entities/user_entity.php";

/**
 * Tạo thông tin UserInfo mới (không bao gồm mật khẩu login)
 * input: UserInfo
 * output: true -> tạo thành công | false -> không thành công
 */
function insert_user_info(\Entities\UserInfo $user_info): void {
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "INSERT INTO db_trochoiviet.user_info VALUES('{$user_info->get_phone_number()}', '{$user_info->get_email()}', '{$user_info->get_name()}', {$user_info->get_join_date()})";
        $statement = $connection->prepare($sql);
        $statement->execute();  // thực hiện truy vấn
    } catch (\PDOexception $ex) {
        echo ("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Tạo thông tin UserLoginInfo mới
 * input: UserLoginInfo
 * output: true -> tạo thành công | false -> không thành công
 */
function insert_user_login_info(\Entities\UserLoginInfo $user_login_info): bool {
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "INSERT INTO db_trochoiviet.user_login_info VALUES('{$user_login_info->get_id()}', '{$user_login_info->get_phone_number()}', '{$user_login_info->get_password()}')";
        $statement = $connection->prepare($sql);
        return $statement->execute();
    } catch (\PDOException $ex) {
        echo ("Errors occur when  querying data: " . $ex->getMessage());
    }
}

/**
 * Đăng nhập người dùng
 * input: phone_number, password
 * output: true -> login thành công | false -> không thành công
 */
function repo_login(string $phone_number, string $password): bool {
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM user_login_info WHERE user_login_info.phone_number = '$phone_number' AND user_login_info.password = '$password';";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        // Kiểm tra kết quả truy vấn
        if (count($result) > 0) {
            return true;    // login thành công
        } else {
            return false;   // không thành công
        }
    } catch (\PDOException $ex) {
        echo ("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Lấy thông tin user thông qua phone_number
 * input: phone_number
 * output: UserInfo -> có tồn tại thông tin | null -> không tồn tại thông tin
 */
function select_user_info_by_phone_number(string $phone_number): \Entities\UserInfo {
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM user_info WHERE user_info.phone_number = '$phone_number'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        // chuyển kết quả từ dạng array về php obj
        if ($result != false) {
            foreach ($result as $row) {
                $user_phone_number = $row["phone_number"];
                $user_email = $row["email"] ?? "";  // Nếu nhận lại kết quả null từ truy vấn thì được gán là chuỗi rỗng
                $user_name = $row["name"];
                $user_join_date = $row["join_date"];
            }
            // gán thông tin vào obj UserInfo
            $user_info = new \Entities\UserInfo();
            $user_info->set_phone_number($user_phone_number);
            $user_info->set_email($user_email);
            $user_info->set_name($user_name);
            $user_info->set_join_date($user_join_date);
            // trả ra kết quả cho tầng service
            return $user_info;
        } else {
            return null;    // trả ra null khi không tìm thấy kết quả
        }
    } catch (\PDOException $ex) {
        echo ("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Lấy ra password hiện tại của user
 * input: phone_number
 * output: password
 */
function select_current_user_password(string $phone_number): string {
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT password FROM user_login_info WHERE user_login_info.phone_number = '$phone_number'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $current_password = $row["password"];
        }
        return $current_password;
    } catch (\PDOException $ex) {
        echo ("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Update thông tin user thông qua phone_number
 * input: phone_number, email, name
 * output: true -> update thành công | false -> không thành công
 */
function update_user_info_by_phone_number(string $phone_number, string $email, string $name): bool {
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "UPDATE user_info SET user_info.email = '$email', user_info.name = '$name' WHERE user_info.phone_number = '$phone_number'";
        $statement = $connection->prepare($sql);
        return $statement->execute();   // Trả ra kết quả truy vấn
    } catch (\PDOException $ex) {
        echo ("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Kiểm tra xem số điện thoại đã được sử dụng hay chưa
 * input: phone_number
 * output: true -> đã được sử dụng | false -> chưa được sử dụng
 */
function is_used_user_phone_number(string $phone_number): bool {
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM user_info WHERE user_info.phone_number = '$phone_number'";
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
 * Khởi tạo password mới cho user
 * input: UserLoginInfo
 * output: true -> tạo thành công | false -> không thành công
 */
function insert_user_new_password(\entities\UserLoginInfo $user_login_info): bool {
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "INSERT INTO user_login_info VALUES('{$user_login_info->get_id()}', '{$user_login_info->get_phone_number()}', '{$user_login_info->get_password()}')";
        $statement = $connection->prepare($sql);
        return $statement->execute();
    } catch (\PDOException $ex) {
        echo ("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Update user password
 * input: phone_number, new_password
 * output: true -> uodate thành công | false -> không thành công
 */
function update_user_password(string $phone_number, string $new_password): bool {
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "UPDATE user_login_info SET user_login_info.password = '$new_password' where user_login_info.phone_number = '$phone_number'";
        $statement = $connection->prepare($sql);
        return $statement->execute();
    } catch (\PDOException $ex) {
        echo ("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Kiểm tra xem UserInfo đã tồn tại hay chưa
 * input: phone_number
 * output: true -> đã tồn tại | false -> chưa tồn tại
 */
function is_user_info_exists(string $phone_number): bool {
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM user_info WHERE user_info.phone_number = '$phone_number'";
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
 * Kiểm tra xem UserLoginInfo đã tồn tại hay chưa,
 * input: phone_number,
 * output: true -> đã tồn tại | false -> chưa tồn tại
 */
function is_user_login_info_exists(string $phone_number): bool {
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM user_login_info WHERE user_login_info.phone_number = '$phone_number'";
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