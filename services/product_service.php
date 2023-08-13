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

/**
 * Xóa product
 * input: product_id
 * output: void
 */
function delete_product(string $product_id): void
{
    \ProductRepository\delete_product($product_id);
}

/**
 * Thêm ảnh minh họa cho product
 * input: ProductImage obj
 * output: void
 */
function create_product_image(\Entities\ProductImage $product_image): void
{
    \ProductRepository\insert_product_image($product_image);
}

/**
 * Lấy ra các ProductImage của một product được chỉ định
 * input: product_id
 * output: array chứa các ProductImage | array rỗng -> không có kết quả
 */
function get_product_image_by_product_id(string $product_id): array
{
    return \ProductRepository\select_product_image_by_product_id($product_id);
}

/**
 * Xóa ProductImage được chọn
 * input: product_image_id
 * output: void
 */
function delete_product_image(string $product_image_id): void
{
    \ProductRepository\delete_product_image($product_image_id);
}

/**
 * Truy vấn 12 product mới nhất
 * input: none
 * output: Product array | array rỗng -> không có kết quả
 */
function get_new_product(): array
{
    return \ProductRepository\select_new_product();
}

/**
 * Truy vấn 12 product ngẫu nhiên
 * input: none
 * output: product array | array rỗng -> không có kết quả
 */
function get_random_product(): array
{
    return \ProductRepository\select_random_product();
}

/**
 * Truy vấn 12 product được mua nhiều nhất
 * input: none
 * output: Product array | array rỗng -> không có kết quả
 */
function get_popular_product(): array
{
    return \ProductRepository\select_popular_product();
}

/**
 * Tìm kiếm product theo từ khóa (theo name)
 * input: keyword
 * output: array Product | array rỗng -> không tìm thấy lết quả
 */
function search_product_by_name(string $keyword): array
{
    return \ProductRepository\search_product_by_name($keyword);
}