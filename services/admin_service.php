<?php
namespace Services;

/**
 * Chứa các xử lý thông tin trung gian giữa template và database
 *  - Tính toán số liệu
 *  - Chuyển đổi thông tin thô từ template về dạng object
 */
include $_SERVER["DOCUMENT_ROOT"] . "/trochoiviet/repositories/admin_repo.php";    // Thêm vào file admin_repo

// Đọc

// Ghi

/**
 * Đăng ký admin mới
 * Input: object chứa thông tin admin mới
 * Output: true -> thêm thành công | false -> không thành công
 */
function register_new_admin(\Entities\AdminInfo $new_admin): bool
{
    $service_result = \Repositories\insert_admin($new_admin);
    return $service_result;
}



/**
 * Login
 * input: username, password
 * output: AdminInfo object | null
 */
function login(string $email, string $password): bool
{
    return \Repositories\repo_login($email, $password);
}