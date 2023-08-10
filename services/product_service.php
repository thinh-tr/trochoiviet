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