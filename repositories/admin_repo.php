<?php
// Chứa các hàm thao tác trực tiếp với database của chương trình

// Entity class chứa thông tin admin
// class AdminInfo {
//     // thuộc tính
//     private $email; // email
//     private $username;  // username
//     private $password;  // password
//     private $name;  // name
//     private $phone_number;  // phone_number
//     private $join_date; // join_date (lưu vào database ở dạng số nguyên)
//     private $self_intro;

//     // constructor
//     function __construct(string $email, string $username, string $password, string $name, string $phone_number, int $join_date, string $self_intro) {
//         $this->email = $email;
//         $this->username = $username;
//         $this->password = $password;
//         $this->name = $name;
//         $this->phone_number = $phone_number;
//         $this->join_date = $join_date;
//         $this->self_intro = $self_intro;
//     }

//     // getter
//     public function get_email(): string {
//         return $this->email;
//     }
    
//     public function get_password(): string {
//         return $this->password;
//     }

//     public function get_username(): string {
//         return $this->username;
//     }

//     public function get_name(): string {
//         return $this->name;
//     }

//     public function get_phone_number(): string {
//         return $this->phone_number;
//     }

//     public function get_join_date(): int {
//         return $this->join_date;
//     }

//     public function get_self_intro(): string {
//         return $this->self_intro;
//     }
// }

include "./entities/admin_info.php";

/**
 * Thêm admin mới vào db
 * input: array chứa thông tin admin mới cần lưu
 * output: true -> tạo thành công | false -> không thành công
 */
function insert_admin(AdminInfo $new_admin): bool {
    // Giả sử các tham số có trong $new_admin đều đã được kiểm tra ở service
    try {
        require "./database/connection_info.php";  // yêu cầu file thông tin để kết nối với db
        $sql = sprintf("insert into admin_info VALUES('%s', '%s', '%s', '%s', '%s', %u, '%s')",
                        $new_admin->get_email(),
                        $new_admin->get_username(),
                        $new_admin->get_password(),
                        $new_admin->get_name(),
                        $new_admin->get_phone_number(),
                        $new_admin->get_join_date(),
                        $new_admin->get_self_intro() );
        // tiến hành truy vấn thêm dữ liệu
        // Tạo statement
        $statement = $connection->prepare($sql);
        $execution_result = $statement->execute();
        return $execution_result;
    } catch (PDOException $ex) {
        echo("Errors occur when modifying data: " . $ex->getMessage());
        return false;
    }
}

// Test thêm record mới
// $my_info = new AdminInfo("cels113@gmail.com", "cels", "12345", "cels", "9035162", time(), "Xin chào!");
// echo(insert_new_admin($my_info));