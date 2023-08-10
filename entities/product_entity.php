<?php
namespace Entities;
// Các class chứa thông tin liên quan đến Sản phẩm trên website

// class chứa thông tin về sản phẩm
class Product
{
    // Thuộc tính
    private $id;
    private $name;
    private $cover_image_link;
    private $description;
    private $retail_price;
    private $remain_quantity;
    private $admin_email;

    // constructor
    public function __construct()
    {

    }

    // Getter
    public function get_id(): string
    {
        return $this->id;
    }

    public function get_name(): string
    {
        return $this->name;
    }

    public function get_cover_image_link(): string
    {
        return $this->cover_image_link;
    }

    public function get_description(): string
    {
        return $this->description;
    }

    public function get_retail_price(): int
    {
        return $this->retail_price;
    }

    public function get_remain_quantity(): int
    {
        return $this->remain_quantity;
    }

    public function get_admin_email(): string
    {
        return $this->admin_email;
    }

    // Setter
    public function set_id(string $id): void
    {
        $this->id = $id;
    }

    public function set_name(string $name): void
    {
        $this->name = $name;
    }

    public function set_cover_image_link(string $cover_image_link): void
    {
        $this->cover_image_link = $cover_image_link;
    }

    public function set_description(string $description): void
    {
        $this->description = $description;
    }

    public function set_retail_price(int $retail_price): void
    {
        $this->retail_price = $retail_price;
    }

    public function set_remain_quantity(int $remain_quantity): void
    {
        $this->remain_quantity = $remain_quantity;
    }

    public function set_admin_email(string $admin_email): void
    {
        $this->admin_email = $admin_email;
    }
}