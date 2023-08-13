<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Tìm kiếm sản phẩm</title>
    <style>
        h2 {
            font-weight: bold;
        }

        .card h5 {
            font-weight: bold;
        }

        div.col-4 {
            width: 20%;
        }

        .col a {
            text-decoration: none;
        }

        .alert.alert-warning {
            margin-bottom: 3cm;
        }

        .nav-item {
            display: inline;
            margin-right: 2px;
        }
    </style>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/services/product_service.php"; ?>

    <?php
    // Lấy ra kết quả tìm kiếm
    $search_result = array();
    if (isset($_POST["search-submit"]) && strlen($_POST["keyword"]) > 0) {
        $search_result = \ProductService\search_product_by_name($_POST["keyword"]);
    }
    ?>

    <!--Điều hướng-->
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <a class="btn btn-primary" href="/product/product_index.php"><i class="bi bi-arrow-left"></i> Trang sản phẩm</a>
            <form class="d-flex" role="search" method="post">
                <input class="form-control me-2" type="search" placeholder="Tên sản phẩm" aria-label="Search" id="keyword" name="keyword">
                <button class="btn btn-outline-info" type="submit" id="search-submit" name="search-submit"><i class="bi bi-search"></i></button>
            </form>
        </div>
    </nav>

    <div class="container">
        <div class="container">
            <!--Hiển thị các kết quả tìm kiếm-->
            <h2><i class="bi bi-newspaper"></i> Kết quả tìm kiếm cho: <?= $_POST["keyword"] ?></h2>
            <?php
            if (count($search_result) > 0) {
            ?>
                <!--Trường hợp có tìm thấy kết quả-->
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php
                    foreach ($search_result as $product) {
                        // Lần lượt hiển thị ra các post
                    ?>
                    <!--Lần lượt hiển thị ra các product-->
                    <div class="col">
                        <a href="/product/product_detail.php?product-id=<?= $product->get_id() ?>">
                            <div class="card h-100">
                                <img src="<?= $product->get_cover_image_link() ?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"><b><?= $product->get_name() ?></b></h5>
                                    <h5 class="card-title">Đơn giá: <?= $product->get_retail_price() ?> VNĐ</h5>
                                    <p class="card-text">Số lượng còn lại: <?= $product->get_remain_quantity() ?></p>
                                </div>
                                <div class="card-footer">
                                    <p class="card-text">Đăng bởi: <small><?= $product->get_admin_email() ?></small></p>
                                </div>  
                            </div>
                        </a>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            <?php
            } else {
            ?>
            <!--Xuất ra thông báo không có post đã thích nào (cả trong trường hợp chưa login)-->
            <div class="alert alert-warning" role="alert">
                <i class="bi bi-info-circle-fill"></i> Không tìm thấy kết quả nào
            </div>
            <?php
            }
            ?>
        </div>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php"; ?>
</body>
</html>