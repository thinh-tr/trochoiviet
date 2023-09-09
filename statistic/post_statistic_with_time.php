<?php
session_start();

// init data
$today_post_array;
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
    <title>Thống kê tin tức theo thời gian</title>
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
        <?php include $_SERVER["DOCUMENT_ROOT"] . "/statistic/templates/statistic_header.php"; ?>

        <!--scroll nav menu-->
        <nav id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
            <a class="navbar-brand" href="#"><i class="bi bi-list-columns"></i> <b>Danh mục thống kê</b></a>
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link" href="#list-item-1"><i class="bi bi-calendar-day"></i> Đăng tải hôm nay</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#list-item-2"><i class="bi bi-calendar-week"></i> Đăng tải trong tuần này</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#list-item-3"><i class="bi bi-calendar-month"></i> Đăng tải trong tháng này</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#list-item-4"><i class="bi bi-eyedropper"></i> Tùy chọn thời gian</a>
                </li>
                <li class="nav-item">
                    <form method="post">
                        <button class="btn btn-info"><i class="bi bi-arrow-repeat"></i> Làm mới</button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>

    <div class="container">
        <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example bg-body-tertiary p-3 rounded-2" tabindex="0">
           <!--Được đăng tải trong hôm nay-->
           <h3><i class="bi bi-calendar-day"></i> <b>Được đăng tải trong hôm nay</b></h3>
           <div class="container">
                <!--Lần lượt hiển thị các thẻ bài viết được đăng tải trong hôm nay-->
                <div class="list-group">

                </div>
           </div>
        </div>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php"; ?>
</body>
</html>