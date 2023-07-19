<?php
namespace Entities;

// class chứa thông tin trò chơi
class Post
{
    // Thuộc tính
    private $id;
    private $name;
    private $cover_image_link;
    private $created_date;
    private $modified_date;
    private $like_number;
    private $admin_email;

    // constructor
    public function __construct()
    {
        
    }

    // Getter
    public function get_id(): string    // id
    {
        return $this->id;
    }

    public function get_name(): string  // name
    {
        return $this->name;
    }

    public function get_cover_image_link(): string  // cover_image_link
    {
        return $this->cover_image_link;
    }

    public function get_created_date(): int // created_date
    {
        return $this->created_date;
    }

    public function get_modified_date(): int    // modified_date
    {
        return $this->modified_date;
    }

    public function get_like_number(): int  // like_number
    {
        return $this->like_number;
    }

    public function get_admin_email(): string   // admin_email
    {
        return $this->admin_email;
    }

    // Setter
    public function set_id(string $id): void    // id
    {
        $this->id = $id;
    }

    public function set_name(string $name): void  // name
    {
        $this->name = $name;
    }

    public function set_cover_image_link(string $cover_image_link): void  // cover_image_link
    {
        $this->cover_image_link = $cover_image_link;
    }

    public function set_created_date(int $created_date): void // created_date
    {
        $this->created_date = $created_date;
    }

    public function set_modified_date(int $modified_date): void    // modified_date
    {
        $this->modified_date = $modified_date;
    }

    public function set_like_number(int $like_number): void  // like_number
    {
        $this->like_number = $like_number;
    }

    public function set_admin_email(string $admin_email): void   // admin_email
    {
        $this->admin_email = $admin_email;
    }

}