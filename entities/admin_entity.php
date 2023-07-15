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
    function __construct() {

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


    
    // setter
    public function set_email(string $email) {
        $this->email = $email;
    }

    public function set_password(string $password) {
        $this->password = $password;
    }

    public function set_name(string $name) {
        $this->name = $name;
    }

    public function set_phone_number(string $phone_number) {
        $this->phone_number = $phone_number;
    }

    public function set_join_date(int $join_date) {
        $this->join_date = $join_date;
    }

    public function set_self_intro(string $self_intro) {
        $this->self_intro = $self_intro;
    }
}
