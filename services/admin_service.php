<?php
namespace AdminServices;

use function Repositories\select_current_admin_password;

/**
 * Chứa các xử lý thông tin trung gian giữa template và database
 *  - Tính toán số liệu
 *  - Chuyển đổi thông tin thô từ template về dạng object
 */
include $_SERVER["DOCUMENT_ROOT"] . "/trochoiviet/repositories/admin_repo.php";    // Thêm vào file admin_repo

/**
 * Đăng ký admin mới
 * Input: object chứa thông tin admin mới
 * Output: true -> thêm thành công | false -> không thành công
 */
function register_new_admin(\Entities\AdminInfo $new_admin): bool
{
    $service_result = \AdminRepositories\insert_admin($new_admin);
    return $service_result;
}



/**
 * Login
 * input: username, password
 * output: true -> login thành công | false -> không thành công
 */
function login(string $email, string $password): bool
{
    return \AdminRepositories\repo_login($email, $password);
}

/**
 * Lấy ra thông tin của admin thông qua email\
 * input: email
 * output: AdminInfo obj -> có tồn tại | null -> Không tồn tại
 */
function get_admin_info_by_email(string $email): \Entities\AdminInfo
{
    return \AdminRepositories\select_admininfo_by_email($email);
}

/**
 * Cập nhật thông tin admin
 * input: email, name, phone_number, self_intro
 * output: true -> update thành công | false -> không thành công
 */
function update_admin_info(string $email, string $name, string $phone_number, string $self_intro): bool
{
    return \AdminRepositories\update_admininfo_by_email($email, $name, $phone_number, $self_intro);
}

/**
 * Cập nhật password
 * input: admin_email, current_password, new_password
 * output: true -> update thành công | false -> không thành công
 */
function update_password(string $email, string $current_password, string $new_password): bool
{
    // Kiểm tra current_password do người dùng nhập vào
    $db_current_password = \AdminRepositories\select_current_admin_password($email);

    // Kiểm tra password hiện tại
    if ($current_password != $db_current_password) {
        return false;   // sai password hiện tại
    }

    // Kiểm tra password mới
    if ($new_password == null || strlen($new_password) < 5) {
        return false;   // password mới không hợp lệ
    }

    // Tiến hành update password
    return \AdminRepositories\update_admin_password($email, $new_password); // Cập nhật thành công sẽ trả ra true
}