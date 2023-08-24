<?php
namespace AdminServices;

/**
 * Chứa các xử lý thông tin trung gian giữa template và database
 *  - Tính toán số liệu
 *  - Chuyển đổi thông tin thô từ template về dạng object
 */
include $_SERVER["DOCUMENT_ROOT"] . "/repositories/admin_repo.php";    // Thêm vào file admin_repo
include $_SERVER["DOCUMENT_ROOT"] . "/repositories/post_repo.php";
include $_SERVER["DOCUMENT_ROOT"] . "/repositories/order_repo.php";
include $_SERVER["DOCUMENT_ROOT"] . "/repositories/product_repo.php";

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

/**
 * Lấy ra password hiện tại của admin
 * input: admin_email
 * output: password -> thành công | string rỗng -> không tìm thấy
 */
function is_used_admin_email(string $email): bool
{
    return \AdminRepositories\is_used_admin_info($email);
}

/**
 * Lấy ra tất cả admin_email có trong database
 * input: none
 * output: array chứa tất cả admin_email | array rỗng -> không có kết quả
 */
function get_all_admin_email(): array
{
    return \AdminRepositories\select_all_admin_email();
}

/**
 * Tạo QR CODE mới
 * input: QRCode obj
 * output: void
 */
function create_qr_code_link(\Entities\QRCode $qr_code): void
{
    \AdminRepositories\insert_qr_code_link($qr_code);
}


/**
 * Lấy ra thông tin của QRCode theo admin_email
 * input: admin_email
 * output: QRCode obj | null -> không có kết quả
 */
function get_qr_code_by_admin_email(string $admin_email): \Entities\QRCode | null
{
    return \AdminRepositories\select_qr_code_by_admin_email($admin_email);
}

/**
 * Xóa QR code của admin
 * input: admin_email
 * output: void
 */
function delete_qr_code_by_admin_email(string $admin_email): void
{
    \AdminRepositories\delete_qr_code_by_admin_email($admin_email);
}

/**
 * Lấy ra password hiện tại của admin_email chỉ định
 * input: admin_email
 * output: password -> thành công | string rỗng -> không tìm thấy
 */
function get_current_admin_password(string $email): string
{
    return \AdminRepositories\select_current_admin_password($email);
}

// /**
//  * Xóa tài khoản admin
//  * input: admin_email
//  * output: bool
//  * note: Đảm bảo rằng tất cả các thông tin liên quan đến admin này đều đã được xóa thủ công trước đó (post, product, order)
//  */
// function delete_admin_info(string $admin_email): bool
// {
//     // Kiểm tra lại các thông tin trước khi xóa

//     $deleted_allowed = true;    // Biến kiểm tra điều kiện xóa

//     // Kiểm tra Post
//     if (count(\PostRepository\select_posts_by_admin_email($admin_email))) {
//         $deleted_allowed = false;   // Không đủ điều kiện xóa
//     }

//     // Kiểm tra Order
//     if (\OrderRepository\select_order_number_of_admin_email($admin_email) > 0) {
//         $deleted_allowed = false;   // Không đủ điều kiện xóa
//     }

//     // Kiểm tra Product
//     if (count(\ProductRepository\select_product_by_admin_email($admin_email)) > 0) {
//         $deleted_allowed = false;   // Không đủ điều kiện xóa
//     }

//     if ($deleted_allowed) {
//         // Tiến hành xóa
//         \AdminRepositories\delete_qr_code_by_admin_email($admin_email);
//         \AdminRepositories\delete_admin_info($admin_email);
//         return true;    // Xác nhận đã xóa
//     } else {
//         return false;   // Không thể xóa
//     }

// }