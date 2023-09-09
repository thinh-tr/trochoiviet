<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template</title>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
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
                        <a class="nav-link" href="/statistic/post_statistic_with_time.php">Thống kê theo thời gian</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/statistic/post_statistic_with_category.php">Thống kê theo danh mục bài viết</a>
                    </li>
                </ul>
                <form>
                    <a class="btn btn-outline-info" href="/post_search_page.php"><i class="bi bi-search"></i></button> Tìm kiếm</a>
                </form>
            </div>
        </div>
    </nav>
</body>
</html>