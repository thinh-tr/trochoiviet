<?php
namespace Entities;

class UserInfo
{
    // Thuộc tính
    private $phone_number;
    private $email;
    private $name;
    private $address;
    private $join_date;

    // constructor
    public function __construct()
    {

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

    public function get_address(): string   // address
    {
        return $this->address;
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

    public function set_address(string $address): void   // address
    {
        $this->address = $address;
    }

    public function set_join_date(int $join_date): void    // join_date
    {
        $this->join_date = $join_date;
    }

}