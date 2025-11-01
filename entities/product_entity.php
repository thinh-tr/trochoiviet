<?php
namespace Entities;
// Các class chứa thông tin liên quan đến Sản phẩm trên website

// class chứa thông tin về sản phẩm
class Product {
    // Thuộc tính
    private $id;
    private $name;
    private $cover_image_link;
    private $description;
    private $retail_price;
    private $remain_quantity;
    private $admin_email;

    // constructor
    public function __construct() {

    }

    // Getter
    public function get_id(): string {
        return $this->id;
    }

    public function get_name(): string {
        return $this->name;
    }

    public function get_cover_image_link(): string {
        return $this->cover_image_link;
    }

    public function get_description(): string {
        return $this->description;
    }

    public function get_retail_price(): int {
        return $this->retail_price;
    }

    public function get_remain_quantity(): int {
        return $this->remain_quantity;
    }

    public function get_admin_email(): string {
        return $this->admin_email;
    }

    // Setter
    public function set_id(string $id): void {
        $this->id = $id;
    }

    public function set_name(string $name): void {
        $this->name = $name;
    }

    public function set_cover_image_link(string $cover_image_link): void {
        $this->cover_image_link = $cover_image_link;
    }

    public function set_description(string $description): void {
        $this->description = $description;
    }

    public function set_retail_price(int $retail_price): void {
        $this->retail_price = $retail_price;
    }

    public function set_remain_quantity(int $remain_quantity): void {
        $this->remain_quantity = $remain_quantity;
    }

    public function set_admin_email(string $admin_email): void {
        $this->admin_email = $admin_email;
    }
}

// class chứa thông tin của hình ảnh sản phẩm
class ProductImage {
    // Thuộc tính
    private $id;
    private $image_link;
    private $product_id;

    // contructor
    public function __construct() {

    }

    // Getter
    public function get_id(): string {
        return $this->id;
    }

    public function get_image_link(): string {
        return $this->image_link;
    }

    public function get_product_id(): string {
        return $this->product_id;
    }

    // Setter
    public function set_id(string $id): void {
        $this->id = $id;
    }

    public function set_image_link(string $image_link): void {
        $this->image_link = $image_link;
    }

    public function set_product_id(string $product_id): void {
        $this->product_id = $product_id;
    }
}

// class chứa thông tin ProductRating
class ProductRating {
    // Thuộc tính
    private string $id;
    private int $rating_star;
    private string $content;
    private string $product_id;
    private string $user_phone_number;

    // constructor
    public function __construct() {

    }

    // Getter
    public function get_id(): string {
        return $this->id;
    }

    public function get_rating_star(): int {
        return $this->rating_star;
    }

    public function get_content(): string {
        return $this->content;
    }

    public function get_product_id(): string {
        return $this->product_id;
    }

    public function get_user_phone_number(): string {
        return $this->user_phone_number;
    }

    // Setter
    public function set_id(string $id): void {
        $this->id = $id;
    }

    public function set_rating_star(int $rating_star): void {
        $this->rating_star = $rating_star;
    }

    public function set_content(string $content): void {
        $this->content = $content;
    }

    public function set_product_id(string $product_id): void {
        $this->product_id = $product_id;
    }

    public function set_user_phone_number(string $user_phone_number): void {
        $this->user_phone_number = $user_phone_number;
    }
}

// Class chứa thông tin external link của Product
class ProductExternalLink {
    // Thuộc tính
    private string $id;
    private string $name;
    private string $link;
    private string $product_id;

    // constructor
    public function __construct() {

    }

    // Getter
    public function get_id(): string {
        return $this->id;
    }

    public function get_name(): string {
        return $this->name;
    }

    public function get_link(): string {
        return $this->link;
    }

    public function get_product_id(): string {
        return $this->product_id;
    }

    // Setter
    public function set_id(string $id): void {
        $this->id = $id;
    }

    public function set_name(string $name): void {
        $this->name = $name;
    }

    public function set_link(string $link): void {
        $this->link = $link;
    }

    public function set_product_id(string $product_id): void {
        $this->product_id = $product_id;
    }

}