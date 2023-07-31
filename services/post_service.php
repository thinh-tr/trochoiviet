<?php
namespace PostService;

// repository
include $_SERVER["DOCUMENT_ROOT"] . "/repositories/post_repo.php";

// Các hàm truy vấn thông tin từ database

/**
 * Truy vấn 10 bài đăng mới nhất
 * input: none
 * output: array chứa các bài đăng -> tìm thấy kết quả | array rỗng -> không có kết quả
 */
function service_get_10_newest_post(): array
{
    return \PostRepository\repo_get_10_newest_post();    // trả ra kết quả
}

/**
 * Truy vấn thông tin của post thông qua post_id (hỗ trợ hiển thị ở đầu trang nội dung),
 * input: post_id
 * output: obj Post chứa thông tin của post cần tìm | null -> không tìm thấy thông tin
 */
function get_post_by_id(string $post_id): \Entities\Post
{
    return \PostRepository\select_post_by_id($post_id);
}

/**
 * Truy vấn số lượt thích của một post
 * input: post_id
 * output: số lượt thích
 */
function get_post_like_number(string $post_id): int
{
    return \PostRepository\select_post_like_number_by_post_id($post_id);
}

/**
 * Truy vấn số lượt comment của một post
 * input: post_id
 * output: số comment
 */
function get_post_comment_number(string $post_id): int
{
    return \PostRepository\select_post_comment_by_post_id($post_id);
}

/**
 * Tăng lượt views của post lên 1
 * input: post_id
 * output: void
 */
function increase_post_views(string $post_id): void
{
    \PostRepository\update_post_views($post_id);
}


/**
 * Kiểm tra xem người dùng đã like một post nào đó hay chưa
 * input: post_id, user_phone_number
 * output: true -> đã like | false -> chưa like
 */
function is_liked_post(string $post_id, string $user_phone_number): bool
{
    return \PostRepository\is_liked_post($post_id, $user_phone_number);
}

/**
 * Thích bài viết
 * input: post_id, user_phone_number
 * output: void
 */
function like_post(string $post_id, string $user_phone_number): void
{
    \PostRepository\insert_like($post_id, $user_phone_number);
}

/**
 * Bỏ thích bài viết
 * input: post_id, user_phone_number
 * output: void
 */
function unlike_post(string $post_id, string $user_phone_number): void
{
    \PostRepository\delete_like($post_id, $user_phone_number);
}
