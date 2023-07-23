<?php

function is_used_admin_info(string $email): bool
{
    try {
        require "./connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "SELECT * FROM admin_info WHERE admin_info.email = '$email'";
        $statement = $connection->prepare($sql);
        $result = $statement->execute();
        $statement->execute();
        $result = $statement->fetchAll();
        if (count($result) > 0) {
            return true;
        }
        return false;
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

if (is_used_admin_info("levy@gmail.com")) {
    echo "true";
} else {
    echo "false";
}