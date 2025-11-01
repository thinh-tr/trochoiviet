<?php
namespace OrderService;

include $_SERVER["DOCUMENT_ROOT"] . "/repositories/order_repo.php";

/**
 * Tạo Order
 * input: Order obj
 * output: void
 */
function create_order(\Entities\Order $order): void {
    \OrderRepository\insert_order($order);
}

/**
 * Tạo OrderDetail
 * input: OrderDetail obj
 * output: void
 */
function create_order_detail(\Entities\OrderDetail $order_detail): void {
    \OrderRepository\insert_order_detail($order_detail);
}

/**
 * Lấy ra array chứa các đơn hàng đang chờ xử lý
 * input: user_phone_number
 * output: Order array | array rỗng -> không tìm thấy thông tin
 */
function get_not_confirm_order_by_user_phone_number(string $user_phone_number): array {
    return \OrderRepository\select_not_confirm_order_by_user_phone_number($user_phone_number);
}

/**
 * Lấy ra các đơn hàng đang chờ xử lý
 * input: user_phone_number
 * output: Order array | array rỗng -> không tìm thấy thông tin
 */
function get_is_waiting_order_by_user_phone_number(string $user_phone_number): array {
    return \OrderRepository\select_is_waiting_order_by_user_phone_number($user_phone_number);
}

/**
 * Lấy ra các đơn hàng đang được xử lý
 * input: user_phone_number
 * output: Order array | array rỗng -> không tìm thấy thông tin
 */
function get_is_processing_order_by_user_phone_number(string $user_phone_number): array {
    return \OrderRepository\select_is_processing_order_by_user_phone_number($user_phone_number);
}

/**
 * Lấy ra các đơn hàng đã hoàn tất
 * input: user_phone_number
 * output: Order array | array rỗng -> không tìm thấy thông tin
 */
function get_is_finished_order_by_user_phone_number(string $user_phone_number): array {
    return \OrderRepository\select_is_finished_order_by_user_phone_number($user_phone_number);
}

/**
 * Lấy ra các đơn hàng đã bị hủy
 * input: user_phone_number
 * output: Order array | array rỗng -> không tìm thấy thông tin
 */
function get_is_canceled_order_by_user_phone_number(string $user_phone_number): array {
    return \OrderRepository\select_is_canceled_order_by_user_phone_number($user_phone_number);
}

/**
 * Lấy ra thông tin order được chỉ định
 * input: order_id
 * output: Order obj | null -> không có kết quả
 */
function get_order_by_order_id(string $order_id): \Entities\Order|null {
    return \OrderRepository\select_order_by_order_id($order_id);
}

/**
 * Lấy ra array chứa order_detail của một order chỉ định
 * input: order_id
 * output: array order_detail | array rỗng -> không có kết quả
 */
function get_order_details_by_order_id(string $order_id): array {
    return \OrderRepository\select_order_details_by_order_id($order_id);
}

/**
 * Cập nhật lại địa chỉ đơn hàng
 * input: order_id, delivery_address
 * output: void
 */
function update_order_delivery_address(string $order_id, string $delivery_address): void {
    \OrderRepository\update_order_delivery_address($order_id, $delivery_address);
}

/**
 * Cập nhật trạng thái order
 * input: order_state
 * output: void
 */
function update_order_state(string $order_id, string $order_state): void {
    \OrderRepository\update_order_state($order_id, $order_state);
}

/**
 * Cập nhật trang thái thanh toán
 * input: (string) order_id (int) payment_state
 * output: void
 */
function update_order_payment_state(string $order_id, int $payment_state): void {
    \OrderRepository\update_order_payment_state($order_id, $payment_state);
}

/**
 * Xóa các order được chỉ định
 * input: order_state
 * output: void
 */
function delete_order_with_order_id(string $order_id): void {
    \OrderRepository\delete_order_with_order_id($order_id);
}

/**
 * Xóa các order_detail của một order nhất định
 * input: order_id
 * output: void
 */
function delete_order_detail_with_order_id(string $order_id): void {
    \OrderRepository\delete_order_detail_with_order_id($order_id);
}

/**
 * Lấy ra array chứa các order_id ở một trạng thái nhất định
 * input: order_state
 * output: string array (order_id) | array rỗng -> không có kết quả
 */
function get_order_ids_at_the_same_state_by_user_phone_number(string $order_state, string $user_phone_number): array {
    return \OrderRepository\select_order_ids_at_the_same_state_by_user_phone_number($order_state, $user_phone_number);
}

/**
 * Lấy ra array chứa các order ở trạng thái được chỉ định và thuộc về một admin_email được chỉ định
 * input: admin_email, order_state
 * output: array chứa các Order | array rỗng -> không có kết quả
 */
function get_orders_by_admin_email_and_state(string $admin_email, string $order_state): array {
    return \OrderRepository\select_orders_by_admin_email_and_state($admin_email, $order_state);
}

/**
 * Lấy ra array chứa các order_id ở một trạng thái nhất định và thuộc về một admin nhất định
 * input: order_state, admin_email
 * output: string array (order_id) | array rỗng -> không có kết quả
 */
function get_order_ids_at_the_same_state_by_admin_email(string $order_state, string $admin_email): array {
    return \OrderRepository\select_order_ids_at_the_same_state_by_admin_email($order_state, $admin_email);
}

/**
 * Update delivery_date của một order
 * input: order_id, (int) delivery_date
 * output: void
 */
function update_order_delivery_date(string $order_id, int $delivery_date): void {
    \OrderRepository\update_order_delivery_date($order_id, $delivery_date);
}