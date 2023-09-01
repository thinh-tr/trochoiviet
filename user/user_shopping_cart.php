<?php session_start(); 

// const not_confirm = "NOT_CONFIRM";  // trạng thái chưa xác nhận
// const waiting = "IS_WAITING";   // trạng thái sau khi xác nhận
// const received = "IS_RECEIVED"; // trạng thái đã được tiếp nhận
// const shipping = "IS_SHIPPING"; // trạng thái đang giao
// const finished = "IS_FINISHED"; // đã hoàn tất
// const canceled = "IS_CANCELED"; // trạng thái đã hủy

// Class chứa thông tin về order
class Order
{
    // Thuộc tính
    private string $id;
    private string $state;
    private int $payment_state;
    private int $order_date;
    private int $delivery_date;
    private string $delivery_address;
    private string $user_phone_number;
    private string $admin_email;

    // constructor
    public function __construct()
    {

    }

    // Getter
    public function get_id(): string
    {
        return $this->id;
    }

    public function get_state(): string
    {
        return $this->state;
    }

    public function get_payment_state(): int
    {
        return $this->payment_state;
    }

    public function get_order_date(): int
    {
        return $this->order_date;
    }

    public function get_delivery_date(): int
    {
        return $this->delivery_date;
    }

    public function get_delivery_address(): string
    {
        return $this->delivery_address;
    }

    public function get_user_phone_number(): string
    {
        return $this->user_phone_number;
    }

    public function get_admin_email(): string
    {
        return $this->admin_email;
    }

    // Setter
    public function set_id(string $id): void
    {
        $this->id = $id;
    }

    public function set_state(string $state): void
    {
        $this->state = $state;
    }

    public function set_payment_state(int $payment_state): void
    {
        $this->payment_state = $payment_state;
    }

    public function set_order_date(int $order_date): void
    {
        $this->order_date = $order_date;
    }

    public function set_delivery_date(int $delivery_date): void
    {
        $this->delivery_date = $delivery_date;
    }

    public function set_delivery_address(string $delivery_address): void
    {
        $this->delivery_address = $delivery_address;
    }

    public function set_user_phone_number(string $user_phone_number): void
    {
        $this->user_phone_number = $user_phone_number;
    }

    public function set_admin_email(string $admin_email): void
    {
        $this->admin_email = $admin_email;
    }
}

// Class chứa thông tin về order detail
class OrderDetail
{
    // Thuộc tính
    private string $id;
    private string $order_id;
    private string $product_id;
    private int $retail_price;
    private int $product_quantity;
    private int $total_price;

    // constructor
    public function __construct()
    {

    }

    // Getter
    public function get_id(): string
    {
        return $this->id;
    }

    public function get_order_id(): string
    {
        return $this->order_id;
    }

    public function get_product_id(): string
    {
        return $this->product_id;
    }

    public function get_retail_price(): int
    {
        return $this->retail_price;
    }

    public function get_product_quantity(): int
    {
        return $this->product_quantity;
    }

    public function get_total_price(): int
    {
        return $this->total_price;
    }

    // Setter
    public function set_id(string $id): void
    {
        $this->id = $id;
    }

    public function set_order_id(string $order_id): void
    {
        $this->order_id = $order_id;
    }

    public function set_product_id(string $product_id): void
    {
        $this->product_id = $product_id;
    }

    public function set_retail_price(int $retail_price): void
    {
        $this->retail_price = $retail_price;
    }

    public function set_product_quantity(int $product_quantity): void
    {
        $this->product_quantity = $product_quantity;
    }

    public function set_total_price(int $total_price): void
    {
        $this->total_price = $total_price;
    }
}


/**
 * Tạo Order
 * input: Order obj
 * output: void
 */
function insert_order(Order $order): void
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "INSERT INTO `order`  VALUES('{$order->get_id()}', '{$order->get_state()}', {$order->get_payment_state()}, {$order->get_order_date()}, {$order->get_delivery_date()}, '{$order->get_delivery_address()}', '{$order->get_user_phone_number()}', '{$order->get_admin_email()}')";
        $statement = $connection->prepare($sql);
        $statement->execute();  // Thực hiện truy vấn
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Tạo OrderDetail
 * input: OrderDetail obj
 * output: void
 */
function insert_order_detail(OrderDetail $order_detail): void
{
    try {
        require $_SERVER["DOCUMENT_ROOT"] . "/connection_info.php";
        $connection = new \PDO($dsn, $username, $db_password);
        $sql = "INSERT INTO order_detail VALUES('{$order_detail->get_id()}', '{$order_detail->get_order_id()}', '{$order_detail->get_product_id()}', {$order_detail->get_retail_price()}, {$order_detail->get_product_quantity()}, {$order_detail->get_total_price()})";
        $statement = $connection->prepare($sql);
        $statement->execute();  // Thực hiện truy vấn
    } catch (\PDOException $ex) {
        echo("Errors occur when querying data: " . $ex->getMessage());
    }
}

/**
 * Tạo Order
 * input: Order obj
 * output: void
 */
function create_order(Order $order): void
{
    insert_order($order);
}

/**
 * Tạo OrderDetail
 * input: OrderDetail obj
 * output: void
 */
function create_order_detail(OrderDetail $order_detail): void
{
    insert_order_detail($order_detail);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Giỏ hàng</title>
    <style>
        #header {
            position: sticky;
            top: 0;
            z-index: 999;
        }
    </style>
</head>
<body>
    <div id="header">
        <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "/admin/templates/admin_header.php"; ?>

        <!--Điều hướng-->
        <nav id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
            <a class="btn btn-primary" href="/index.php"><i class="bi bi-arrow-left"></i> Trang chủ</a>
            <ul class="nav nav-pills">
                <form method="post">
                    <button class="btn btn-danger" id="delete-cart" name="delete-cart"><i class="bi bi-trash3-fill"></i> Xóa giỏ hàng</button>
                    <button class="btn btn-info" id="refresh" name="refresh"><i class="bi bi-arrow-counterclockwise"></i> Làm mới</button>
                </form>
            </ul>
        </nav>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/services/product_service.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/services/user_service.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/services/admin_service.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/entities/order_state.php"; ?>

    <?php
    // Xử lý truy vấn thông tin của người mua hàng
    $user_info = null;
    if (isset($_SESSION["user_phone_number"])) {
        // Nếu như có login từ người dùng
        $user_info = \UserService\get_user_info($_SESSION["user_phone_number"]);
    }
    ?>

    <?php
    // xử lý xóa giỏ hàng
    if (isset($_POST["delete-cart"])) {
            // Xóa tất cả item trong cart
            unset($_SESSION["shopping_cart"]);
            echo(<<<END
            <div class="alert alert-success" role="alert">
                Đã xóa giỏ hàng
            </div>          
            END);
        // unset($_SESSION["shopping_cart"]);
    }
    ?>

    <?php
    // xử lý tạo đơn hàng dự trên giỏ hàng
    if (isset($_POST["order-submit"])) {
        // Kiểm tra thông tin trên form
        $user_info_array = array();

        // Lần lượt kiểm tra thông tin trên form sau đó push vào array nếu thông tin đó hợp lệ

        // phone_number
        if (is_numeric($_POST["phone-number"]) && strlen($_POST["phone-number"])) {
            $user_info_array["phone_number"] = $_POST["phone-number"];  // thêm vào phone_number
        }

        // email (nếu người dùng có nhập vào thì kiểm tra)
        if (!empty($_POST["email"])) {
            if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                $user_info_array["email"] = $_POST["email"];    // thêm vào email
            }
        } else {
            // Nếu không thì thêm vào chuỗi rỗng
            $user_info_array["email"] = "";
        }

        // name
        if (strlen($_POST["name"]) >= 2) {
            $user_info_array["name"] = $_POST["name"];
        }

        // address
        if (strlen($_POST["address"]) >= 10) {
            $user_info_array["address"] = $_POST["address"];
        }

        // Kiểm tra lại array
        $is_valid_array = true;
        if (!array_key_exists("phone_number", $user_info_array)) {
            $is_valid_array = false;
        } else if (!array_key_exists("name", $user_info_array)) {
            $is_valid_array = false;
        } else if (!array_key_exists("address", $user_info_array)) {
            $is_valid_array = false;
        }

        if ($is_valid_array) {
            if (UserService\is_used_user_phone_number($user_info_array["phone_number"])) {
                // Nếu phone_number đã được lưu trong db -> tiến hành tạo trực tiếp order với phone_number đó
                $all_admin_emails = AdminServices\get_all_admin_email();

                // Tìm ra các admin_email có trong shopping_cart rồi push vào một array mới
                $ordered_admin_emails = array();
                for ($i = 0; $i < count($all_admin_emails); $i++) {
                    foreach ($_SESSION["shopping_cart"] as $item) {
                        if ($all_admin_emails[$i] == $item["admin_email"] && !in_array($all_admin_emails[$i], $ordered_admin_emails)) {
                            array_push($ordered_admin_emails, $all_admin_emails[$i]);
                        }
                    }
                }

                // Sau khi đã có được các admin_email nhận được đặt hàng -> tạo các order tương ứng với các email đó
                foreach ($ordered_admin_emails as $email) {
                    // Lần lượt tạo order tương ứng với từng email
                    $order = new Order();
                    $order->set_id(uniqid());
                    $order->set_state(OrderState\not_confirm);
                    $order->set_payment_state(0);
                    $order->set_order_date(time());
                    $order->set_delivery_date(0);
                    $order->set_delivery_address($user_info_array["address"]);
                    $order->set_user_phone_number($user_info_array["phone_number"]);
                    $order->set_admin_email($email);

                    // Ghi order vừa tạo vào database
                    create_order($order);
                    // Duyệt qua tất cả các item trong shopping_cart để tìm ra item có cùng admin_email sau đó tạo ra OrderDetail tương ứng rồi thêm vào order
                    foreach ($_SESSION["shopping_cart"] as $item) {
                        if ($item["admin_email"] == $order->get_admin_email()) {
                            $product = \ProductService\get_product_by_product_id($item["product_id"]); // Lấy ra thông tin product để phục vụ tạo OrderDetail
                            // Nếu item có admin_email trùng khớp với admin_email của order thì thêm item đó vào order
                            $order_detail = new OrderDetail();
                            $order_detail->set_id(uniqid());
                            $order_detail->set_order_id($order->get_id());
                            $order_detail->set_product_id($product->get_id());
                            $order_detail->set_retail_price($product->get_retail_price());
                            $order_detail->set_product_quantity($item["quantity"]);
                            $order_detail->set_total_price($item["quantity"] * $product->get_retail_price());

                            // Ghi order_detail vừa tạo vào database
                            create_order_detail($order_detail);
                        }
                    }
                }
                // Xóa giỏ hàng
                unset($_SESSION["shopping_cart"]);
                echo(<<<END
                    <div class="alert alert-success" role="alert">
                        Tạo đơn hàng thành công
                    </div>                  
                    END);
            } else {
                // Nếu phone_number chưa được lưu trong db -> tạo mới user_info trước sao đó mới tạo order và order_detail

                // Tạo thông user_info
                $new_user_info = new \Entities\UserInfo();
                $new_user_info->set_phone_number($user_info_array["phone_number"]);
                $new_user_info->set_email($user_info_array["email"]);
                $new_user_info->set_name($user_info_array["name"]);
                $new_user_info->set_join_date(time());
                // Ghi user_info mới vào database
                UserService\create_user_info($new_user_info);

                // Tiến hành tạo order
                $all_admin_emails = AdminServices\get_all_admin_email();
                // Tìm ra các admin_email có trong shopping_cart rồi push vào một array mới
                $ordered_admin_emails = array();
                for ($i = 0; $i < count($all_admin_emails); $i++) {
                    foreach ($_SESSION["shopping_cart"] as $item) {
                        if ($all_admin_emails[$i] == $item["admin_email"] && !in_array($all_admin_emails[$i], $ordered_admin_emails)) {
                            array_push($ordered_admin_emails, $all_admin_emails[$i]);
                        }
                    }
                }

                // Sau khi đã có được các admin_email nhận được đặt hàng -> tạo các order tương ứng với các email đó
                foreach ($ordered_admin_emails as $email) {
                    // Lần lượt tạo order tương ứng với từng email
                    $order = new Order();
                    $order->set_id(uniqid());
                    $order->set_state("not_confirm");
                    $order->set_payment_state(0);
                    $order->set_order_date(time());
                    $order->set_delivery_date(0);
                    $order->set_delivery_address($user_info_array["address"]);
                    $order->set_user_phone_number($user_info_array["phone_number"]);
                    $order->set_admin_email($email);

                    // Ghi order vừa tạo vào database
                    create_order($order);
                    // Duyệt qua tất cả các item trong shopping_cart để tìm ra item có cùng admin_email sau đó tạo ra OrderDetail tương ứng rồi thêm vào order
                    foreach ($_SESSION["shopping_cart"] as $item) {
                        if ($item["admin_email"] == $order->get_admin_email()) {
                            $product = \ProductService\get_product_by_product_id($item["product_id"]); // Lấy ra thông tin product để phục vụ tạo OrderDetail
                            // Nếu item có admin_email trùng khớp với admin_email của order thì thêm item đó vào order
                            $order_detail = new OrderDetail();
                            $order_detail->set_id(uniqid());
                            $order_detail->set_order_id($order->get_id());
                            $order_detail->set_product_id($product->get_id());
                            $order_detail->set_retail_price($product->get_retail_price());
                            $order_detail->set_product_quantity($item["quantity"]);
                            $order_detail->set_total_price($item["quantity"] * $product->get_retail_price());

                            // Ghi order_detail vừa tạo vào database
                            create_order_detail($order_detail);
                        }
                    }
                }
                // Xóa giỏ hàng
                unset($_SESSION["shopping_cart"]);
                echo(<<<END
                    <div class="alert alert-success" role="alert">
                        Tạo đơn hàng thành công
                    </div>                  
                    END);
            }
        } else {
            echo("<script>window.alert('Vui lòng kiểm tra lại thông tin mua hàng của bạn')</script>");
        }
    }
    ?>
    
    

    <div class="container">
        <!--Lưu ý khi mua hàng-->
        <div class="alert alert-danger" role="alert">
            <i class="bi bi-exclamation-square-fill"></i> Đảm bảo số điện thoại của bạn là chính xác vì số điện thoại này sẽ được lưu lại để giúp bạn tra cứu thông tin mua hàng. Hơn nữa, đơn hàng của bạn có thể sẽ bị hủy nếu người bán không thể xác minh được số điện thoại mà bạn cung cấp
        </div>
        <div class="alert alert-info" role="alert">
            <i class="bi bi-info-circle-fill"></i> Trước khi đặt hàng bạn hãy kiểm tra lại thông tin mua hàng và bấm nút "làm mới" ở góc trên bên phải để so sánh số lượng sản phẩm muốn mua so với số sản phẩm hiện có trong kho hàng của người bán nhé (ở trạng thái ✅ là có thể đặt hàng rồi).
        </div>
        <div class="alert alert-warning" role="alert">
            <i class="bi bi-exclamation-circle-fill"></i> Nếu có bất kỳ sản phẩm nào trong giỏ hàng của bạn ở trạng thái không khả dụng (❌) hãy chọn nút xóa sản phẩm đó, sau đó ghé lại trang sản phẩm để chọn số lượng phù hợp rồi thêm lại vào giỏ hàng.
        </div>

        <div class="card" style="margin-bottom: 1cm;">
            <div class="card-header">
                <h5 class="card-title"><small><i class="bi bi-info-circle"></i> <b>Thông tin mua hàng</b></small></h5>
            </div>
            <form method="post">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="phone-number" class="form-label"><i class="bi bi-telephone-fill"></i> <b>Số điện thoại *</b></label>
                        <input type="text" class="form-control" id="phone-number" name="phone-number" placeholder="Số điện thoại" value="<?php if (isset($user_info)) {echo($user_info->get_phone_number());} ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label"><i class="bi bi-envelope-fill"></i> <b>Email</b></label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Địa chỉ email" value="<?php if (isset($user_info)) {echo($user_info->get_email());} ?>">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label"><i class="bi bi-info-circle-fill"></i> <b>Tên *</b></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Tối thiểu 2 ký tự" value="<?php if (isset($user_info)) {echo($user_info->get_name());} ?>">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label"><i class="bi bi-house-fill"></i> <b>Địa chỉ giao hàng *</b></label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Tối thiểu 10 ký tự">
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-warning" id="order-submit" name="order-submit"><i class="bi bi-box2-fill"></i> Đặt hàng</button>
                </div>
            </form>
        </div>

        <h3><i class="bi bi-basket"></i> <b>Giỏ hàng của bạn</b></h3>
        <!--Kiểm tra xem giỏ hàng có tồn tại hay không-->
        <?php
        if (isset($_SESSION["shopping_cart"]) && count($_SESSION["shopping_cart"]) > 0) {
        ?>
        <table class="table" style="margin-bottom: 2cm;">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Mã sản phẩm</th>
                <th scope="col">Tên sản phẩm</th>
                <th scope="col">Đơn giá</th>
                <th scope="col">Số lượng cần mua</th>
                <th scope="col">Số lượng hiện có</th>
                <th scope="col">Tổng giá</th>
                <th scope="col">Khả dụng</th>
                <th scope="col">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 0; $i < count($_SESSION["shopping_cart"]); $i++) {
                $product = \ProductService\get_product_by_product_id($_SESSION["shopping_cart"][$i]["product_id"]);
            ?>
            <tr>
                <th scope="row"><?= $i + 1 ?></th>
                <td><?= $product->get_id() ?></td>
                <td><?= $product->get_name() ?></td>
                <td><?= $product->get_retail_price() ?> VNĐ</td>
                <td><?= $_SESSION["shopping_cart"][$i]["quantity"] ?></td>
                <td><?= $product->get_remain_quantity() ?></td>
                <td><?= $product->get_retail_price() * $_SESSION["shopping_cart"][$i]["quantity"] ?> VNĐ</td>
                <td>
                <?php
                if ($_SESSION["shopping_cart"][$i]["quantity"] <= $product->get_remain_quantity()) {
                ?>
                    <div class="btn btn-success"><i class="bi bi-check-lg"></i></div>
                <?php
                } else {
                ?>
                    <div class="btn btn-danger"><i class="bi bi-x-lg"></i></div>
                <?php
                }
                ?>
                </td>
                <td>
                    <form method="post">
                        <button class="btn btn-outline-danger" id="<?= $i ?>" name="<?= $i ?>"><i class="bi bi-trash3-fill"></i> Xóa</button>
                    </form>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
        </table>
        <?php
        } else {
        ?>
        <!--Thông báo giỏ hàng không có sản phẩm nào-->
        <div class="alert alert-warning" role="alert" style="margin-bottom: 3cm;">
            <i class="bi bi-info-circle-fill"></i> Bạn không có sản phẩm nào trong giỏ hàng
        </div>
        <?php
        }
        ?>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php"; ?>
</body>
</html>

<?php
// Xử lý xóa sản phẩm chỉ định trong giỏ hàng
for ($i = 0; $i < count($_SESSION["shopping_cart"]); $i++) {
    if (isset($_POST[$i])) {
        unset($_SESSION["shopping_cart"][$i]);
        $_SESSION["shopping_cart"] = array_values($_SESSION["shopping_cart"]);
        // Kiểm tra xem nếu giỏ hàng đã rỗng thì xóa luôn biến giỏ hàng
        if (count($_SESSION["shopping_cart"]) == 0) {
            unset($_SESSION["shopping_cart"]);
        }
        echo("<script>window.alert('Đã xóa sản phẩm khỏi giỏ hàng')</script>");
    }
}
?>

