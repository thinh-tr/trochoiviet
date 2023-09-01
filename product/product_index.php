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
    <title>Trang cửa hàng</title>
    <style>
        #header {
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .col a {
            text-decoration: none;
        }

        .card-footer form a {
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div id="header">
        <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>

        <!--scroll nav menu-->
        <nav id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
            <a class="navbar-brand" href="#"><i class="bi bi-card-list"></i> <b>Danh mục sản phẩm</b></a>
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link" href="#list-item-1"><i class="bi bi-box-seam"></i> Sản phẩm mới</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#list-item-2"><i class="bi bi-bag-heart"></i> Được mua nhiều nhất</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#list-item-3"><i class="bi bi-lightbulb"></i> Có thể bạn quan tâm</a>
                </li>
                <li class="nav-item">
                    <form method="post">
                        <a href="/product/product_search_page.php" class="btn btn-outline-warning"><i class="bi bi-search"></i> Tìm kiếm sản phẩm</a>
                        <button class="btn btn-info"><i class="bi bi-arrow-repeat"></i> Làm mới</button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/services/product_service.php"; ?>

    <?php
    // Truy vấn thông tin các danh mục sản phẩm
    $new_product_array = \ProductService\get_new_product();
    $popular_product_array = \ProductService\get_popular_product();
    $random_product_array = \ProductService\get_random_product();
    ?>


    <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example bg-body-tertiary p-3 rounded-2" tabindex="0">
        <div class="container">
            <h3 id="list-item-1"><i class="bi bi-box-seam"></i> <b>Sản phẩm mới</b></h3>
            <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            // Kiểm tra array và hiển thị các sản phẩm mới nhất
            if (count($new_product_array) > 0) {
                foreach ($new_product_array as $product) {
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
                                <p class="card-text"><b>Đăng bởi:</b> <small><?= $product->get_admin_email() ?></small></p>
                            </div>  
                        </div>
                    </a>
                </div>
            <?php
                }
            } else {
                // Nếu không có sản phẩm nào thì hiển thị card placeholder
            ?>
            <div class="card" aria-hidden="true">
                <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title placeholder-glow">
                        <span class="placeholder col-6"></span>
                    </h5>
                    <p class="card-text placeholder-glow">
                        <span class="placeholder col-7"></span>
                        <span class="placeholder col-4"></span>
                        <span class="placeholder col-4"></span>
                        <span class="placeholder col-6"></span>
                        <span class="placeholder col-8"></span>
                    </p>
                </div>
            </div>
            <?php
            }
            ?>
            </div><br>

            <h3 id="list-item-2"><i class="bi bi-bag-heart"></i> <b>Sản phẩm được mua nhiều</b></h3>
            <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            // Kiểm tra array và hiển thị các sản phẩm mới nhất
            if (count($popular_product_array) > 0) {
                foreach ($popular_product_array as $product) {
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
                                <p class="card-text"><b>Đăng bởi:</b> <small><?= $product->get_admin_email() ?></small></p>
                            </div>  
                        </div>
                    </a>
                </div>
            <?php
                }
            } else {
                // Nếu không có sản phẩm nào thì hiển thị card placeholder
            ?>
            <div class="card" aria-hidden="true">
                <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title placeholder-glow">
                        <span class="placeholder col-6"></span>
                    </h5>
                    <p class="card-text placeholder-glow">
                        <span class="placeholder col-7"></span>
                        <span class="placeholder col-4"></span>
                        <span class="placeholder col-4"></span>
                        <span class="placeholder col-6"></span>
                        <span class="placeholder col-8"></span>
                    </p>
                </div>
            </div>
            <?php
            }
            ?>
            </div><br>

            <h3 id="list-item-3"><i class="bi bi-lightbulb"></i> <b>Có thể bạn quan tâm</b></h3>
            <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            // Kiểm tra array và hiển thị các sản phẩm mới nhất
            if (count($random_product_array) > 0) {
                foreach ($random_product_array as $product) {
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
                                <p class="card-text"><b>Đăng bởi:</b> <small><?= $product->get_admin_email() ?></small></p>
                            </div>  
                        </div>
                    </a>
                </div>
            <?php
                }
            } else {
                // Nếu không có sản phẩm nào thì hiển thị card placeholder
            ?>
            <div class="card" aria-hidden="true">
                <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title placeholder-glow">
                        <span class="placeholder col-6"></span>
                    </h5>
                    <p class="card-text placeholder-glow">
                        <span class="placeholder col-7"></span>
                        <span class="placeholder col-4"></span>
                        <span class="placeholder col-4"></span>
                        <span class="placeholder col-6"></span>
                        <span class="placeholder col-8"></span>
                    </p>
                </div>
            </div>
            <?php
            }
            ?>
            </div>

        </div>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php"; ?>
</body>
</html>