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