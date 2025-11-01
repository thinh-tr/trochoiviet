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


// class lưu thông tin QR CODE
class QRCode {
    // Thuộc tính
    private string $id;
    private string $admin_email;
    private string $qr_code_link;

    // constructor
    public function __construct() {

    }

    // Getter
    public function get_id(): string {
        return $this->id;
    }

    public function get_admin_email(): string {
        return $this->admin_email;
    }

    public function get_qr_code_link(): string {
        return $this->qr_code_link;
    }

    // Setter
    public function set_id(string $id): void {
        $this->id = $id;
    }

    public function set_admin_email(string $admin_email): void {
        $this->admin_email = $admin_email;
    }

    public function set_qr_code_link(string $qr_code_link): void {
        $this->qr_code_link = $qr_code_link;
    }
}