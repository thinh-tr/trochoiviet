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