<?php
namespace Entities;

// class chứa thông tin của một Post
class Post
{
    // Thuộc tính
    private $id;
    private $name;
    private $description;
    private $cover_image_link;
    private $created_date;
    private $modified_date;
    private $views;
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

    public function get_description(): string   // description
    {
        return $this->description;
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

    public function get_views(): int
    {
        return $this->views;
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

    public function set_description(string $description): void
    {
        $this->description = $description;
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

    public function set_views(int $views): void
    {
        $this->views = $views;
    }

    public function set_admin_email(string $admin_email): void   // admin_email
    {
        $this->admin_email = $admin_email;
    }
}

// class chứa thông tin của một Post Content
class PostContent
{
    // Thuộc tính
    private $id;
    private $title;
    private $content;
    private $post_id;

    // constructor
    public function __construct()
    {

    }

    // getter
    public function get_id(): string    // id
    {
        return $this->id;
    }

    public function get_title(): string     // title
    {
        return $this->title;
    }

    public function get_content(): string   // content
    {
        return $this->content;
    }

    public function get_post_id(): string   // post_id
    {
        return $this->post_id;
    }


    // setter
    public function set_id(string $id): void    // id
    {
        $this->id = $id;
    }

    public function set_title(string $title): void     // title
    {
        $this->title = $title;
    }

    public function set_content(string $content): void   // content
    {
        $this->content = $content;
    }

    public function set_post_id(string $post_id): void   // post_id
    {
        $this->post_id = $post_id;
    }

}

// class chứa thông tin của một Post Content Image
class PostContentImage
{
    // Thuộc tính
    private $id;
    private $image_link;
    private $post_content_id;

    // constructor
    public function __construct()
    {

    }

    // Getter
    public function get_id(): string    // id
    {
        return $this->id;
    }

    public function get_image_link(): string    // image_link
    {
        return $this->image_link;
    }

    public function get_post_content_id(): string   // post_content_id
    {
        return $this->post_content_id;
    }


    // Setter
    public function set_id(string $id): void    // id
    {
        $this->id = $id;
    }

    public function set_image_link(string $image_link): void    // image_link
    {
        $this->image_link = $image_link;
    }

    public function set_post_content_id(string $post_content_id): void   // post_content_id
    {
        $this->post_content_id = $post_content_id;
    }
}

// class chứa thông tin về link nhúng video
class PostVideo
{
    // thuộc tính
    private $id;
    private $video_source;
    private $video_link;
    private $post_id;

    // constructor
    public function __construct()
    {

    }

    // Getter
    public function get_id(): string
    {
        return $this->id;
    }

    public function get_video_source(): string
    {
        return $this->video_source;
    }

    public function get_video_link(): string
    {
        return $this->video_link;
    }

    public function get_post_id(): string
    {
        return $this->post_id;
    }

    // Setter
    public function set_id(string $id): void
    {
        $this->id = $id;
    }

    public function set_video_source(string $video_source): void
    {
        $this->video_source = $video_source;
    }

    public function set_video_link(string $video_link): void
    {
        $this->video_link = $video_link;
    }

    public function set_post_id(string $post_id): void
    {
        $this->post_id = $post_id;
    }

}


// class lưu thông tin bình luận bài viết
class PostComment
{
    // Thuộc tính
    private $id;
    private $created_date;
    private $content;
    private $user_phone_number;
    private $post_id;
    private $approved;

    // Constructor
    public function __construct()
    {
        
    }

    // Getter
    public function get_id(): string
    {
        return $this->id;
    }

    public function get_created_date(): int
    {
        return $this->created_date;
    }

    public function get_content(): string
    {
        return $this->content;
    }

    public function get_user_phone_number(): string
    {
        return $this->user_phone_number;
    }

    public function get_post_id(): string
    {
        return $this->post_id;
    }

    public function get_approval(): int
    {
        return $this->approved;
    }


    // Setter
    public function set_id(string $id): void
    {
        $this->id = $id;
    }

    public function set_created_date(int $created_date): void
    {
        $this->created_date = $created_date;
    }

    public function set_content(string $content): void
    {
        $this->content = $content;
    }

    public function set_user_phone_number(string $user_phone_number): void
    {
        $this->user_phone_number = $user_phone_number;
    }

    public function set_post_id(string $post_id): void
    {
        $this->post_id = $post_id;
    }

    public function set_approval(int $approved): void
    {
        $this->approved = $approved;
    }
}

// class lưu thông tin các bài viết đang được user follow
class UserPostFollow {
    // thuộc tính
    private $id;
    private $user_phone_number;
    private $post_id;

    // constructor
    public function __construct()
    {

    }

    // Getter
    public function get_id(): string
    {
        return $this->id;
    }

    public function get_user_phone_number(): string
    {
        return $this->user_phone_number;
    }

    public function get_post_id(): string
    {
        return $this->post_id;
    }

    // Setter
    public function set_id(string $id): void
    {
        $this->id = $id;
    }

    public function set_user_phone_number(string $user_phone_number): void
    {
        $this->user_phone_number = $user_phone_number;
    }

    public function set_post_id(string $post_id): void
    {
        $this->post_id = $post_id;
    }

}