<?php
namespace OrderService;

include $_SERVER["DOCUMENT_ROOT"] . "/repositories/order_repo.php";

/**
 * Tạo Order
 * input: Order obj
 * output: void
 */
function create_order(\Entities\Order $order): void
{
    \OrderRepository\insert_order($order);
}

/**
 * Tạo OrderDetail
 * input: OrderDetail obj
 * output: void
 */
function create_order_detail(\Entities\OrderDetail $order_detail): void
{
    \OrderRepository\insert_order_detail($order_detail);
}

/**
 * Lấy ra array chứa các đơn hàng đang chờ xử lý
 * input: user_phone_number
 * output: Order array | array rỗng -> không tìm thấy thông tin
 */
function get_not_confirm_order_by_user_phone_number(string $user_phone_number): array
{
    return \OrderRepository\select_not_confirm_order_by_user_phone_number($user_phone_number);
}

/**
 * Lấy ra các đơn hàng đang chờ xử lý
 * input: user_phone_number
 * output: Order array | array rỗng -> không tìm thấy thông tin
 */
function get_is_waiting_order_by_user_phone_number(string $user_phone_number): array
{
    return \OrderRepository\select_is_waiting_order_by_user_phone_number($user_phone_number);
}

/**
 * Lấy ra các đơn hàng đang được xử lý
 * input: user_phone_number
 * output: Order array | array rỗng -> không tìm thấy thông tin
 */
function get_is_processing_order_by_user_phone_number(string $user_phone_number): array
{
    return \OrderRepository\select_is_processing_order_by_user_phone_number($user_phone_number);
}

/**
 * Lấy ra các đơn hàng đã hoàn tất
 * input: user_phone_number
 * output: Order array | array rỗng -> không tìm thấy thông tin
 */
function get_is_finished_order_by_user_phone_number(string $user_phone_number): array
{
    return \OrderRepository\select_is_finished_order_by_user_phone_number($user_phone_number);
}

/**
 * Lấy ra các đơn hàng đã bị hủy
 * input: user_phone_number
 * output: Order array | array rỗng -> không tìm thấy thông tin
 */
function get_is_canceled_order_by_user_phone_number(string $user_phone_number): array
{
    return \OrderRepository\select_is_canceled_order_by_user_phone_number($user_phone_number);
}

/**
 * Lấy ra thông tin order được chỉ định
 * input: order_id
 * output: Order obj | null -> không có kết quả
 */
function get_order_by_order_id(string $order_id): \Entities\Order | null
{
    return \OrderRepository\select_order_by_order_id($order_id);
}

/**
 * Lấy ra array chứa order_detail của một order chỉ định
 * input: order_id
 * output: array order_detail | array rỗng -> không có kết quả
 */
function get_order_details_by_order_id(string $order_id): array
{
    return \OrderRepository\select_order_details_by_order_id($order_id);
}