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