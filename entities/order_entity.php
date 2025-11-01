<?php
namespace Entities;
// Chứa các class thông tin về order

const not_confirm = "NOT_CONFIRM";  // trạng thái chưa xác nhận
const waiting = "IS_WAITING";   // trạng thái sau khi xác nhận
const received = "IS_RECEIVED"; // trạng thái đã được tiếp nhận
const shipping = "IS_SHIPPING"; // trạng thái đang giao
const finished = "IS_FINISHED"; // đã hoàn tất
const canceled = "IS_CANCELED"; // trạng thái đã hủy

// Class chứa thông tin về order
class Order {
    // Thuộc tính
    private string $id;
    private string $state;
    private int $payment_state;
    private int $order_date;
    private int $delivery_date;
    private string $delivery_address;
    private string $user_phone_number;
    private string $admin_email;

    // constructor
    public function __construct() {

    }

    // Getter
    public function get_id(): string {
        return $this->id;
    }

    public function get_state(): string {
        return $this->state;
    }

    public function get_payment_state(): int {
        return $this->payment_state;
    }

    public function get_order_date(): int {
        return $this->order_date;
    }

    public function get_delivery_date(): int {
        return $this->delivery_date;
    }

    public function get_delivery_address(): string {
        return $this->delivery_address;
    }

    public function get_user_phone_number(): string {
        return $this->user_phone_number;
    }

    public function get_admin_email(): string {
        return $this->admin_email;
    }

    // Setter
    public function set_id(string $id): void {
        $this->id = $id;
    }

    public function set_state(string $state): void {
        $this->state = $state;
    }

    public function set_payment_state(int $payment_state): void {
        $this->payment_state = $payment_state;
    }

    public function set_order_date(int $order_date): void {
        $this->order_date = $order_date;
    }

    public function set_delivery_date(int $delivery_date): void {
        $this->delivery_date = $delivery_date;
    }

    public function set_delivery_address(string $delivery_address): void {
        $this->delivery_address = $delivery_address;
    }

    public function set_user_phone_number(string $user_phone_number): void {
        $this->user_phone_number = $user_phone_number;
    }

    public function set_admin_email(string $admin_email): void {
        $this->admin_email = $admin_email;
    }
}

// Class chứa thông tin về order detail
class OrderDetail {
    // Thuộc tính
    private string $id;
    private string $order_id;
    private string $product_id;
    private int $retail_price;
    private int $product_quantity;
    private int $total_price;

    // constructor
    public function __construct() {

    }

    // Getter
    public function get_id(): string {
        return $this->id;
    }

    public function get_order_id(): string {
        return $this->order_id;
    }

    public function get_product_id(): string {
        return $this->product_id;
    }

    public function get_retail_price(): int {
        return $this->retail_price;
    }

    public function get_product_quantity(): int {
        return $this->product_quantity;
    }

    public function get_total_price(): int {
        return $this->total_price;
    }

    // Setter
    public function set_id(string $id): void {
        $this->id = $id;
    }

    public function set_order_id(string $order_id): void {
        $this->order_id = $order_id;
    }

    public function set_product_id(string $product_id): void {
        $this->product_id = $product_id;
    }

    public function set_retail_price(int $retail_price): void {
        $this->retail_price = $retail_price;
    }

    public function set_product_quantity(int $product_quantity): void {
        $this->product_quantity = $product_quantity;
    }

    public function set_total_price(int $total_price): void {
        $this->total_price = $total_price;
    }
}