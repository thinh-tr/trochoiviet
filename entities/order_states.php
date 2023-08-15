<?php
namespace OrderStates;

const not_confirm = "NOT_CONFIRM";  // trạng thái chưa xác nhận
const waiting = "IS_WAITING";   // trạng thái sau khi xác nhận
const received = "IS_RECEIVED"; // trạng thái đã được tiếp nhận
const shipping = "IS_SHIPPING"; // trạng thái đang giao
const finished = "IS_FINISHED"; // đã hoàn tất
const canceled = "IS_CANCELED"; // trạng thái đã hủy