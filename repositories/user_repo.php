<?php
namespace UserRepository;

// user entities
include $_SERVER["DOCUMENT_ROOT"] . "/trochoiviet/entities/user_entity.php";

/**
 * Tạo thông tin UserInfo mới (không bao gồm mật khẩu login)
 * input: UserInfo
 * output: true -> tạo thành công | false -> không thành công
 */
function insert_user_info(\Entities\UserInfo $user_info): bool
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/trochoiviet/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "INSERT INTO db_trochoiviet.user_info VALUES('{$user_info->get_phone_number()}', '{$user_info->get_email()}', '{$user_info->get_name()}', '{$user_info->get_address()}', {$user_info->get_join_date()})";
        $statement = $connection->prepare($sql);
        return $statement->execute();
    } catch (\PDOexception $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Tạo thông tin UserLoginInfo mới
 * input: UserLoginInfo
 * output: true -> tạo thành công | false -> không thành công
 */
function insert_user_login_info(\Entities\UserLoginInfo $user_login_info): bool
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/trochoiviet/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "INSERT INTO db_trochoiviet.user_login_info VALUES('{$user_login_info->get_id()}', '{$user_login_info->get_phone_number()}', '{$user_login_info->get_password()}')";
        $statement = $connection->prepare($sql);
        return $statement->execute();
    } catch (\PDOException $ex) {
        echo("Errors occur when  querying data: " . $ex->getMessage());
    }
}