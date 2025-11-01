<?php
namespace Entities;

// Class thông tin người dùng
class UserInfo {
    // Thuộc tính
    private $phone_number;
    private $email;
    private $name;
    private $join_date;

    // constructor
    public function __construct() {

    }

    // Getter
    public function get_phone_number(): string  // phone_number
    {
        return $this->phone_number;
    }

    public function get_email(): string // email
    {
        return $this->email;
    }

    public function get_name(): string  // name
    {
        return $this->name;
    }

    public function get_join_date(): int    // join_date
    {
        return $this->join_date;
    }


    // Setter
    public function set_phone_number(string $phone_number): void  // phone_number
    {
        $this->phone_number = $phone_number;
    }

    public function set_email(string $email): void // email
    {
        $this->email = $email;
    }

    public function set_name(string $name): void  // name
    {
        $this->name = $name;
    }

    public function set_join_date(int $join_date): void    // join_date
    {
        $this->join_date = $join_date;
    }

}

// Class thông tin đăng nhập của người dùng
class UserLoginInfo {
    // Thuộc tính
    private $id;
    private $phone_number;
    private $password;

    // constructor
    public function __construct() {

    }

    // getter
    public function get_id(): string    // id
    {
        return $this->id;
    }

    public function get_phone_number(): string  // phone_number
    {
        return $this->phone_number;
    }

    public function get_password(): string {
        return $this->password;
    }

    //setter
    public function set_id(string $id): void    // id
    {
        $this->id = $id;
    }

    public function set_phone_number(string $phone_number): void  // phone_number
    {
        $this->phone_number = $phone_number;
    }

    public function set_password(string $password): void    // password
    {
        $this->password = $password;
    }

}