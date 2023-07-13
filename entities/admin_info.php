<?php
namespace Entities;

// Khởi tạo class chứa thông tin admin
class AdminInfo {
    // thuộc tính
    private $email; // email
    private $password;  // password
    private $name;  // name
    private $phone_number;  // phone_number
    private $join_date; // join_date (lưu vào database ở dạng số nguyên)
    private $self_intro;

    // constructor
    function __construct(string $email, string $password, string $name, string $phone_number, int $join_date, string $self_intro) {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->phone_number = $phone_number;
        $this->join_date = $join_date;
        $this->self_intro = $self_intro;
    }

    // getter
    public function get_email(): string {
        return $this->email;
    }
    
    public function get_password(): string {
        return $this->password;
    }

    public function get_name(): string {
        return $this->name;
    }

    public function get_phone_number(): string {
        return $this->phone_number;
    }

    public function get_join_date(): int {
        return $this->join_date;
    }

    public function get_self_intro(): string {
        return $this->self_intro;
    }
}
