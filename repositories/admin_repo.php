<?php

include $_SERVER["DOCUMENT_ROOT"] . "/trochoiviet/entities/admin_info.php";


/**
 * Thêm admin mới vào db
 * input: array chứa thông tin admin mới cần lưu
 * output: true -> tạo thành công | false -> không thành công
 */
function insert_admin(AdminInfo $new_admin): bool
{
    // Giả sử các tham số có trong $new_admin đều đã được kiểm tra ở service
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/trochoiviet/connection_info.php";  // yêu cầu file thông tin để kết nối với db
        $connection = new PDO($dsn, $username, $password);  // Khởi tạo connection
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
    } catch (PDOException $ex) {
        echo ("Errors occur when querying data: " . $ex->getMessage());
        //return false;
    }
}

// Test thêm record mới
// $my_info = new AdminInfo("cels115@gmail.com", "cels", "12345", "cels", "9035162", time(), "Xin chào!");
// echo(insert_admin($my_info));
// count_username("cels");