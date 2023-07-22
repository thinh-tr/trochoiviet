<?php
namespace UserService;

// file repositories
include $_SERVER["DOCUMENT_ROOT"] . "/trochoiviet/repositories/user_repo.php";

/**
 * Tạo user mới với password login
 * input: UserInfo, UserLoginInfo
 * output: true -> tạo thành công | false -> không thành công
 */
function create_full_user_info(\Entities\UserInfo $user_info, \Entities\UserLoginInfo $user_login_info): bool
{
    // Giả sử các thông tin đã được kiểm tra tại template
    $is_created = false;
    if (\UserRepository\insert_user_info($user_info) && \UserRepository\insert_user_login_info($user_login_info)) {
        $is_created = true;
    }
    return $is_created; // Trả ra kết quả khởi tạo
}

/**
 * Đăng nhập người dùng
 * input: phone_number, password
 * output: true -> login thành công | false -> không thành công
 */
function login(string $phone_number, string $password): bool
{
    return \UserRepository\repo_login($phone_number, $password);    // trả ra kết quả login
}

/**
 * Lấy thông tin user thông qua phone_number
 * input: phone_number
 * output: UserInfo -> có tồn tại thông tin | null -> không tồn tại thông tin
 */
function get_user_info(string $phone_number): \Entities\UserInfo
{
    return \UserRepository\select_user_info_by_phone_number($phone_number);
}

/**
 * Lấy ra password hiện tại của user
 * input: phone_number
 * output: password
 */
function get_user_password(string $phone_number): string
{
    return \UserRepository\select_current_user_password($phone_number);
}

/**
 * Update thông tin user thông qua phone_number
 * input: phone_number, email, name
 * output: true -> update thành công | false -> không thành công
 */
function update_user_info(string $phone_number, string $email, string $name): bool
{
    return \UserRepository\update_user_info_by_phone_number($phone_number, $email, $name);
}