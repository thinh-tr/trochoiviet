<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/videocontent.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <title>Trang chủ</title>
    <style>
        #header {
            position: sticky;
            top: 0;
            z-index: 999;
        }
        .container {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div id="header">
        <?php include  $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php" ?> <!--header-->
    </div>

    <div class="container">
        <!-- Carousel -->
        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/static/images/KeoCo.jpg" class="d-block w-100" alt="..." height="500">
                </div>
                <div class="carousel-item">
                    <img src="/static/images/LuyenAi.jpg" class="d-block w-100" alt="..." height="500">
                </div>
                <div class="carousel-item">
                    <img src="/static/images/Naucom.jpg" class="d-block w-100" alt="..." height="500">
                </div>
                <div class="carousel-item">
                    <img src="/static/images/NgheNghiep.jpg" class="d-block w-100" alt="..." height="500">
                </div>
                <div class="carousel-item">
                    <img src="/static/images/DuaThuyen.jpg" class="d-block w-100" alt="..." height="500">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <!-- Carousel -->

        <!-- Embedded Video -->
        <div id="videoplay">
            <div class="sub-videoplay">
                <div class="text-heading">
                    <p>Vậy trò chơi dân gian là gì?</p>
                </div>
                <div class="text-sub">
                    Chúng ta cùng xem video ngắn dưới đây để nắm được tổng quan về trò chơi
                    dân gian là gì nhé!
                </div>
            </div>
            <div class="card">
                <div class="video">
                    <iframe width="680" height="420" src="https://www.youtube.com/embed/dqgsa7-y2Yc?start=153" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>
        <br>
        <!-- Embedded Video -->

        <h1 style="text-align: center;"><b>Một số loại hình trò chơi dân gian</b></h1><br>
        <!-- Nội dung phần thân trang -->
        <div class="container">
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <div class="col">
                    <div class="card h-100">
                        <img src="/static/images/LuyenAi.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><b>Trò chơi luyến ái</b></h5>
                            <p class="card-text">Là nhóm trò chơi mang tính chất thiên về tình yêu đôi lứa. Dưới chế độ
                                phong kiến xưa, nam nữ thường bị cấm cản bởi những lễ giáo phong kiến, họ
                                không được tự do tìm hiểu và chọn lựa người mình yêu, nhưng trò chơi luyến
                                ái đã đáp ứng được nhu cầu này của các nam thanh nữ tú, họ có dịp được
                                thân mật nhau mà không bị lễ giáo, lệ làng bác bỏ, và sau nhiều trò chơi
                                như thế có người đã thành vợ thành chồng. Trò chơi luyến ái còn mang một
                                chút tín ngưỡng dân gian, gửi gắm trong đó ước nguyện của nhân dân về sự
                                bình an, mùa màng tươi tốt. Cũng bởi tính thiêng đó mà trò chơi luyến ái
                                thường diễn ra trong không gian lễ hội, ít khi diễn ra ở những không gian
                                thường.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100">
                        <img src="/static/images/PhaoDat.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><b>Trò chơi phong tục</b></h5>
                            <p class="card-text">Trò chơi phong tục gồm các trò chơi nghiêng tính thiêng liêng, mang
                                dáng
                                dấp của những nghi lễ, phong tục xa xưa của người Việt. Nhóm trò chơi dân
                                gian này chứa đựng những tư tưởng, tình cảm của dân tộc, lưu giữ đậm nét
                                tín ngưỡng, phong tục dân tộc, từ tín ngưỡng vạn vật hữu linh cho đến quan
                                niệm về thờ cúng thần linh, trời đất. Bởi tính chất linh thiêng nên trò
                                chơi phong tục cũng được diễn ra nhiều trong không gian lễ hội.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100">
                        <img src="/static/images/DuaThuyen.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><b>Trò chơi trận chiến</b></h5>
                            <p class="card-text">Nhóm trò chơi chiến trận có hai loại thành phần tham gia, một là giữa
                                cá
                                nhân với nhau, hai là giữa tập thể với tập thể, tất cả hai thành phần tham
                                gia này đều là những con người có khiếu, có tài, đại diện cho một thôn,
                                làng hoặc bảng. Đây là những cuộc thi đấu đầy tinh thần thượng võ dân tộc
                                Đây là nhóm trò chơi có số người cổ vũ rất nhiều, nó đem lại nhiều niềm
                                vui cho cả những người ngoài cuộc chơi. Nó thể hiện rõ sức mạnh, sự tinh
                                nhuệ, năng động, sung sức của lớp lớp thế hệ trẻ dân tộc, sức mạnh được
                                phô bày ra giữa thiên nhiên, trời đất, nó thể hiện quan niệm sống hết
                                mình, cố gắng vượt lên những bất lợi của thiên nhiên, vượt qua khó khăn
                                của người Việt.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100">
                        <img src="/static/images/Oanquan-1.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><b>Trò chơi trí tuệ</b></h5>
                            <p class="card-text">Trò chơi trí tuệ là loại trò chơi chiếm một phần khá lớn trong tổng thể
                                các trò chơi dân gian. Nếu như trò chơi trận chiến thể hiện sự linh hoạt,
                                sức mạnh, khéo léo cũng như dẻo dai thì với trò chơi trí tuệ, người chơi
                                lại thể hiện khả năng quan sát, tư duy, trí tuệ của người chơi.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100">
                        <img src="/static/images/NgheNghiep.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><b>Trò chơi nghề nghiệp</b></h5>
                            <p class="card-text">Nhóm trò chơi nghề nghiệp là tập hợp những trò chơi mô phỏng và mang
                                dáng
                                dấp những nghề nghiệp, những công việc hằng ngày của nhân dân dưới hình
                                thức vừa làm vừa chơi, như trò Thi cấy lúa, Thi bắt vịt, Bắt cá. Mục đích
                                của những trò chơi nghề nghiệp này là tạo cho mọi người sự phấn khởi, hào
                                hứng trước những công việc mình đang làm, những công việc này sẽ được thể
                                hiện dưới hình thức một cuộc thi tài với yếu tố thắng thua được đặt lên
                                hàng đầu.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Home body -->

    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/footer.php" ?> <!--footer-->
</body>

</html>