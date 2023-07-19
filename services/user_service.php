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