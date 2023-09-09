<?php
namespace PostService;

// repository
include $_SERVER["DOCUMENT_ROOT"] . "/repositories/post_repo.php";

// Các hàm truy vấn thông tin từ database

/**
 * Truy vấn 10 bài đăng mới nhất
 * input: none
 * output: array chứa các bài đăng -> tìm thấy kết quả | array rỗng -> không có kết quả
 */
function service_get_10_newest_post(): array
{
    return \PostRepository\repo_get_10_newest_post();    // trả ra kết quả
}

/**
 * Truy vấn thông tin của post thông qua post_id (hỗ trợ hiển thị ở đầu trang nội dung),
 * input: post_id
 * output: obj Post chứa thông tin của post cần tìm | null -> không tìm thấy thông tin
 */
function get_post_by_id(string $post_id): \Entities\Post
{
    return \PostRepository\select_post_by_id($post_id);
}

/**
 * Truy vấn số lượt thích của một post
 * input: post_id
 * output: số lượt thích
 */
function get_post_like_number(string $post_id): int
{
    return \PostRepository\select_post_like_number_by_post_id($post_id);
}

/**
 * Truy vấn số lượt comment của một post
 * input: post_id
 * output: số comment
 */
function get_post_comment_number(string $post_id): int
{
    return \PostRepository\select_post_comment_by_post_id($post_id);
}

/**
 * Tăng lượt views của post lên 1
 * input: post_id
 * output: void
 */
function increase_post_views(string $post_id): void
{
    \PostRepository\update_post_views($post_id);
}


/**
 * Kiểm tra xem người dùng đã like một post nào đó hay chưa
 * input: post_id, user_phone_number
 * output: true -> đã like | false -> chưa like
 */
function is_liked_post(string $post_id, string $user_phone_number): bool
{
    return \PostRepository\is_liked_post($post_id, $user_phone_number);
}

/**
 * Thích bài viết
 * input: post_id, user_phone_number
 * output: void
 */
function like_post(string $post_id, string $user_phone_number): void
{
    \PostRepository\insert_like($post_id, $user_phone_number);
}

/**
 * Bỏ thích bài viết
 * input: post_id, user_phone_number
 * output: void
 */
function unlike_post(string $post_id, string $user_phone_number): void
{
    \PostRepository\delete_like($post_id, $user_phone_number);
}

/**
 * Thêm bình luận mới
 * input: obj PostComment
 * output: true -> Đăng tải thành công | false -> không thành công
 */
function add_new_comment(\Entities\PostComment $post_comment): bool
{
    return \PostRepository\insert_comment($post_comment);
}

/**
 * Xóa bình luận được chọn
 * input: comment_id
 * output: true -> xóa thành công | fasle -> không thành công
 */
function delete_comment(string $comment_id): void
{
    \PostRepository\delete_comment($comment_id);
}

/**
 * Lấy ra thông tin post_comment theo id
 * input: comment_id
 * output: obj PostComment -> tìm thấy thông tin | null -> không tìm thấy
 */
function get_comment(string $comment_id): \Entities\PostComment
{
    return \PostRepository\select_comment_by_id($comment_id);
}


/**
 * Cập nhật nội dung cho các bình luận
 * input: comment_id, content
 * output: void
 */
function update_comment_content(string $comment_id, string $content): void
{
    \PostRepository\update_comment_content($comment_id, $content);
}

/**
 * Thêm post vào mục post được theo dõi của user
 * input: UserPostFollow
 * output: bool
 */
function follow_post(string $user_phone_number, string $post_id): void
{
    \PostRepository\insert_user_post_follow($user_phone_number, $post_id);
}

/**
 * Xóa user post follow
 * input: user_post_follow_id
 * output: void
 */
function unfollow_post(string $user_phone_number, string $post_id): void
{
    \PostRepository\delete_user_post_follow($user_phone_number, $post_id);
}

/**
 * Kiểm tra xem user đã follow post hay chưa
 * input: user_phone_number, post_id
 * output: true -> đã follow | false -> chưa follow
 */
function is_post_followed(string $user_phone_number, string $post_id): bool
{
    return \PostRepository\is_post_followed($user_phone_number, $post_id);
}

/**
 * Lấy ra danh sách post_id được like bởi một user chỉ định
 * input: user_phone_number
 * output: array chứa post obj | array rỗng -> không có kết quả
 */
function get_liked_posts(string $user_phone_number): array
{
    return \PostRepository\select_liked_posts_by_user_phone_number($user_phone_number);
}

/**
 * Lấy ra danh sách post được follow bởi một user chỉ định
 * input: user_phone_number
 * output: array chứa post obj | array rỗng -> không có kết quả
 */
function get_follow_posts(string $user_phone_number): array
{
    return \PostRepository\select_follow_posts_by_user_phone_number($user_phone_number);
}

/**
 * Lấy tất cả các post được tạo bởi một admin chỉ định
 * input: admin_email
 * output: array chứa Post obj | array rỗng -> không có kết quả
 */
function get_posts_by_admin(string $admin_email): array
{
    return \PostRepository\select_posts_by_admin_email($admin_email);
}

/**
 * Service
 * Lấy ra array chứa các post_content của một post theo post id
 * input: post_id
 * output: array chứa post_content -> có kết quả | array rỗng -> không có kết quả
 */
function get_post_contents_by_post_id(string $post_id): array
{
    return \PostRepository\select_post_contents_by_post_id($post_id);
}


/**
 * Service
 * Lấy ra thông tin của các PostContentImage thông qua post_content_id
 * input: post_content_id
 * output: array chứa các PosrtContentImage -> tìm thấy kết quả | array rỗng -> không tìm thấy kết quả
 */
function get_post_content_image_by_post_content_id(string $post_content_id): array
{
    return \PostRepository\select_post_content_image_by_post_content_id($post_content_id);
}

/**
 * Service
 * Lấy ra array chứa thông tin của các video được nhúng trong bài post
 * input: post_id
 * output: array chứa các video link của bài post -> có kết quả | array rỗng -> không có kết quả
 */
function get_post_video_by_post_id(string $post_id): array
{
    return \PostRepository\select_post_video_by_post_id($post_id);
}

/**
 * Tìm kiếm bài viết theo tên
 * input: post_name
 * output: array post obj | array rỗng -> không có kết quả
 */
function search_post(string $keyword): array
{
    return \PostRepository\select_post_by_keyword($keyword);
}

/**
 * Cập nhật thông tin của Post theo post_id
 * input: post_id, post_name, post_description, post_cover_image, post_modified_date, post_views
 * output: void
 */
function update_post_info(string $post_id, string $post_name, string $post_description, string $post_cover_image_link, int $post_modified_date, int $post_views): void
{
    \PostRepository\update_post_info_by_post_id($post_id, $post_name, $post_description, $post_cover_image_link, $post_modified_date, $post_views);
}

/**
 * Cập nhật đoạn nội dung cho post
 * input: content_title, content_body
 * output: void
 */
function update_post_content(string $content_id, string $content_title, string $content_body): void
{
    \PostRepository\update_post_content_by_content_id($content_id, $content_title, $content_body);
}

/**
 * Lấy ra thông tin của post content thông qua id
 * input: content_id
 * output: PostContent obj | null -> không tìm thấy thông tin
 */
function get_post_content(string $content_id): \Entities\PostContent
{
    return \PostRepository\select_content_by_content_id($content_id);
}

/**
 * Thêm PostContentImage
 * input: PostContentImage obj
 * output: void
 */
function add_content_image_link(\Entities\PostContentImage $content_image): void
{
    \PostRepository\insert_content_image_link($content_image);
}

/**
 * Xóa content_image
 * input: content_image_id
 * output: void
 */
function delete_content_image(string $image_id): void
{
    \PostRepository\delete_content_image_by_id($image_id);
}

/**
 * Thêm post_content mới
 * input: PostContent
 * output: void
 */
function add_post_content(\Entities\PostContent $post_content): void
{
    \PostRepository\insert_post_content($post_content);
}

/**
 * Xóa post_content
 * input: content_id
 * output: void
 */
function delete_post_content(string $content_id): void
{
    \PostRepository\delete_post_content($content_id);
}

/**
 * Tạo post mới
 * input: Post obj
 * output: void
 */
function add_post(\Entities\Post $post): void
{
    \PostRepository\create_post($post);
}

/**
 * Xóa post
 * input: post_id
 * output: void
 */
function delete_post(string $post_id): void
{
    \PostRepository\delete_post($post_id);
}

/**
 * Thêm link video mới 
 * input: PostVideo obj
 * output: void
 */
function add_post_video(\Entities\PostVideo $post_video): void
{
    \PostRepository\insert_post_video($post_video);
}

/**
 * Xóa link video
 * input: post_video_id
 * output: void
 */
function delete_post_video(string $post_video_id): void
{
    \PostRepository\delete_post_video($post_video_id);
}

/**
 * Lấy ra các bình luận chưa được duyệt của một post
 * input: post_id
 * output: array chứa các PostComment | array rỗng -> không có kết quả
 */
function get_post_comment_with_no_approval(string $post_id): array
{
    return \PostRepository\select_post_comment_with_no_approval($post_id);
}

/**
 * Lấy ra các bình luận đã được duyệt của một post
 * input: post_id
 * output: array chứa các PostComment | array rỗng -> không có kết quả
 */
function get_post_comment_with_approval(string $post_id): array
{
    return \PostRepository\select_post_comment_with_approval($post_id);
}

/**
 * Phê duyệt bình luận
 * input: post_comment_id
 * output: void
 */
function approve_post_comment(string $post_comment_id): void
{
    \PostRepository\approve_post_comment($post_comment_id);
}

/**
 * Hủy phê duyệt bình luận
 * input: post_comment_id
 * output: void
 */
function disapprove_post_comment(string $post_comment_id): void
{
    \PostRepository\disapprove_post_comment($post_comment_id);
}

/**
 * Cập nhật thông tin category cho post
 * input: (string) post_id, (string) category
 * output: vvoid
 */
function update_post_category(string $post_id, string $category): void
{
    \PostRepository\update_post_category($post_id, $category);
}

/**
 * Truy vấn một số post có category tương tự như của post được chỉ định
 * input: (string) post_id, (string) category
 * output: Post array -> có kết quả | array rỗng -> không có kết quả
 */
function get_relative_posts_by_post_id(string $post_id, string $category): array
{
    return \PostRepository\select_relative_posts_by_post_id($post_id, $category);
}
