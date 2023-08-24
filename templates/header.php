<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template</title>
    <style>
        div.container {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .register-form {
            margin-left: 20%;
            margin-right: 20%;
        }

    </style>
</head>
<body>

    <!-- Navbar --><nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
    <div class="container-fluid">
        <!-- <a class="navbar-brand" href="#">Navbar</a> -->
        <a class="navbar-brand" href="/index.php">
            <img src="/static/icons/Logo.jpg" alt="Logo" width="50" height="50">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/index.php"></i> Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/post/post_index.php"> Bài viết</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/product/product_index.php">Cửa hàng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/fanpage.php">Fan page</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/admin_index.php">Quản trị</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/introduction.php">Giới thiệu</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Người dùng
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/user/user_register.php">Đăng ký tài khoản</a></li>
                        <li><a class="dropdown-item" href="/user/user_password_register.php">Đăng ký mật khẩu</a></li>
                        <li><a class="dropdown-item" href="/user/user_login.php">Đăng nhập</a></li>
                        <li><a class="dropdown-item" href="/user/user_index.php">Trung tâm người dùng</a></li>
                    </ul>
                </li>
            </ul>
            <form>
                <a class="btn btn-outline-warning" href="/user/user_shopping_cart.php"><i class="bi bi-cart3"></i> Giỏ hàng</a>
                <a class="btn btn-outline-info" href="/post_search_page.php"><i class="bi bi-search"></i></button> Tìm kiếm</a>
            </form>
        </div>
    </div>
</nav>
<!-- Header -->

</body>
</html>