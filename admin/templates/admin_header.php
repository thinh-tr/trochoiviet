<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin header</title>
</head>

<body>
    <!-- manager navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="primary">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Quản lý bài đăng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Quản lý cửa hàng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Quản lý đơn hàng</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Tài khoản quản trị viên
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/admin/admin_login.php">Đăng nhập</a></li>
                            <li><a class="dropdown-item" href="/admin/admin_info.php">Thông tin tài khoản</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

</body>

</html>