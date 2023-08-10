<?php
namespace ProductService;

include $_SERVER["DOCUMENT_ROOT"] . "/repositories/product_repo.php";

/**
 * Lấy ra tất cả các product của một admin được chỉ định
 * input: admin_email
 * output: array chứa các Product obj | array rỗng -> không có kết quả nào
 */
function get_product_by_admin_email(string $admin_email): array
{
    return \ProductRepository\select_product_by_admin_email($admin_email);
}

/**
 * Thêm product mới
 * input: obj Product
 * output: void
 */
function create_product(\Entities\Product $product): void
{
    \ProductRepository\insert_product($product);
}

/**
 * Lấy ra thông tin product theo product_id
 * input: product_id
 * output: Post obj | null -> không tìm thấy kết quả
 */
function get_product_by_product_id(string $product_id): \Entities\Product
{
    return \ProductRepository\select_product_by_product_id($product_id);
}


/**
 * Cập nhật thông tin product
 * input:  id, name, cover_image, description, retail_price, remain_quantity
 * output: void
 */
function update_product(string $product_id, string $name, string $cover_image, string $description, int $retail_price, int $remain_quantity): void
{
    \ProductRepository\update_product($product_id, $name, $cover_image,$description, $retail_price, $remain_quantity);
}