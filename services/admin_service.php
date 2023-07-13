<?php
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
function register_new_admin(AdminInfo $new_admin): bool {
    $service_result = insert_admin($new_admin);
    return $service_result;
}

// Test
// Test thêm record mới
// $my_info = new AdminInfo("cels116@gmail.com", "cels", "12345", "cels", "9035162", time(), "Xin chào!");
// echo(register_new_admin($my_info));
