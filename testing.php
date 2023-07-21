<?php
include "entities/user_entity.php";

function select_user_info_by_phone_number(string $phone_number): \Entities\UserInfo
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM user_info WHERE user_info.phone_number = '$phone_number'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        // chuyển kết quả từ dạng array về php obj
        if ($result != false) {
            foreach ($result as $row) {
                $user_phone_number = $row["phone_number"];
                $user_email = $row["email"];
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
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

function get_user_info(string $phone_number): \Entities\UserInfo
{
    return select_user_info_by_phone_number($phone_number);
}

$user = get_user_info("0702948947");
echo($user->get_phone_number());