<?php session_start(); ?>
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
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/admin/templates/admin_header.php"; ?>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/services/product_service.php"; ?>


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


    <!--Điều hướng-->
    <nav id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
        <a class="btn btn-primary" href="/index.php"><i class="bi bi-arrow-left"></i> Trang chủ</a>
        <ul class="nav nav-pills">
            <form method="post">
                <button class="btn btn-warning" id="order-submit" name="order-submit"><i class="bi bi-box2-fill"></i> Đặt hàng</button>
                <button class="btn btn-danger" id="delete-cart" name="delete-cart"><i class="bi bi-trash3-fill"></i> Xóa giỏ hàng</button>
                <button class="btn btn-info" id="refresh" name="refresh"><i class="bi bi-arrow-counterclockwise"></i> Làm mới</button>
            </form>
        </ul>
    </nav>

    <div class="container">
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
                <th scope="col">Số lượng</th>
                <th scope="col">Tổng giá</th>
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
                <td><?= $product->get_retail_price() * $_SESSION["shopping_cart"][$i]["quantity"] ?> VNĐ</td>
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
