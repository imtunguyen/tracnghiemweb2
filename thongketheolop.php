<?php
include('./includes/header.php');
include('./includes/database.php');
if (!(isset($_SESSION['username']) && isset($_SESSION['userId']) && isset($_SESSION['permissionId']))) {
    header("Location: dangnhap.php");
}
if (!isset($_GET['ma_lop'])) {
    header("Location: lophoc.php");
} else {
    $ma_lop = $_GET['ma_lop'];
}
// get so luong de thi trong lop
$sql_get_count_dethi = "SELECT Count(bt.ma_bai_thi) as countDt from bai_thi bt join lop on lop.ma_lop = bt.ma_lop where lop.ma_lop = $ma_lop";
$result_get_count_dethi = mysqli_query($connect, $sql_get_count_dethi);
$row_get_count_dethi = mysqli_fetch_assoc($result_get_count_dethi);
$sl_de_thi = $row_get_count_dethi['countDt'];

// get diem trung binh cua lop
$sql_get_dtb_lop = "SELECT AVG(subquery.tong_diem) AS trungBinh
FROM (
    SELECT SUM(kq.diem) AS tong_diem
    FROM ket_qua kq
    JOIN chi_tiet_lop ON kq.user_id = chi_tiet_lop.user_id
    JOIN chi_tiet_quyen ctq ON ctq.user_id = kq.user_id
    WHERE chi_tiet_lop.ma_lop = $ma_lop
      AND ctq.ma_quyen = 3
    GROUP BY kq.user_id
) AS subquery";
$result_get_dtb_lop = mysqli_query($connect, $sql_get_dtb_lop);
$row_get_dtb_lop = mysqli_fetch_assoc($result_get_dtb_lop);
$dtb_lop = $row_get_dtb_lop['trungBinh'];
$slHocSinh = $row_get_slHocSinh['slHocSinh'];

?>
<div class="container">
    <article>
        <h2 class="text-center mb-5">Tổng quan</h2>
        <div class="row gap-5 m-auto justify-content-center">
            <div class="col-3 d-flex align-items-center justify-content-center rounded" style="height: 120px; width: 325px; background-color: #d3d3d3">
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <img src="./images/de_thi.png" alt="">
                    <div class="d-flex flex-column justify-content-center">
                        <p class="mb-1">Số lượng đề thi trong lớp</p>
                        <p class="m-0"><?php echo $sl_de_thi; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-3 d-flex align-items-center justify-content-center rounded" style="height: 120px; width: 325px; background-color: #d3d3d3">
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <img src="./images/dtb.png" alt="">
                    <div class="d-flex flex-column justify-content-center">
                        <p class="mb-1">Điểm trung bình của lớp</p>
                        <p class="m-0"><?php echo $dtb_lop; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-3 d-flex align-items-center justify-content-center rounded" style="height: 120px; width: 325px; background-color: #d3d3d3">
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <img src="./images/dcao.png" alt="">
                    <div class="d-flex flex-column justify-content-center">
                        <p class="mb-1">Tỷ lệ đạt điểm cao của lớp (9đ)</p>
                        <p class="m-0"><?php echo $slHocSinh; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </article>
    <article>
        <h2 class="text-center mt-5">
            Biểu đồ thống kê top 10 học sinh có điểm cao nhất theo lớp
        </h2>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load("current", {
                packages: ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ["Element", "Density", {
                        role: "style"
                    }],
                    ["Copper", 8.94, "#b87333"],
                    ["Silver", 10.49, "silver"],
                    ["Gold", 19.30, "gold"],
                    ["Platinum", 21.45, "color: #e5e4e2"],
                    ["Platinum", 21.45, "color: #e5e4e2"],
                    ["Platinum", 21.45, "color: #e5e4e2"],
                    ["Platinum", 21.45, "color: #e5e4e2"],
                    ["Platinum", 21.45, "color: #e5e4e2"],
                    ["Platinum", 21.45, "color: #e5e4e2"],
                    ["Platinum", 21.45, "color: #e5e4e2"],

                ]);

                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                    {
                        calc: "stringify",
                        sourceColumn: 1,
                        type: "string",
                        role: "annotation"
                    },
                    2
                ]);

                var options = {
                    title: "Density of Precious Metals, in g/cm^3",
                    width: "100%",
                    height: 400,
                    bar: {
                        groupWidth: "95%"
                    },
                    legend: {
                        position: "none"
                    },
                };
                var chart = new google.visualization.ColumnChart(document.getElementById("tk_top10"));
                chart.draw(view, options);
            }
        </script>
        <div id="tk_top10" class="mb-5" style="width: 100%; height: 400px;"></div>
    </article>

    <article>
        <hr>
        <h2 class="text-center mt-5 mb-5">
            Thống kê điểm của sinh viên theo đề thi
        </h2>
        <div class="row">
            <div class="col-5">
                <div class="d-flex gap-2 align-items-center justify-content-center">
                    <p class="m-0" style="width:70px;">
                        Đề thi:
                    </p>
                    <select class="form-select">
                        <option selected>--Chọn đề thi--</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="d-flex gap-3 align-items-center">
            <section>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    google.charts.load("current", {
                        packages: ['corechart']
                    });
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                            ["Element", "Density", {
                                role: "style"
                            }],
                            ["Copper", 8.94, "#b87333"],
                            ["Silver", 10.49, "silver"],
                            ["Gold", 19.30, "gold"],
                            ["Platinum", 21.45, "color: #e5e4e2"]
                        ]);

                        var view = new google.visualization.DataView(data);
                        view.setColumns([0, 1,
                            {
                                calc: "stringify",
                                sourceColumn: 1,
                                type: "string",
                                role: "annotation"
                            },
                            2
                        ]);

                        var options = {
                            title: "Thống kê Top 5 học sinh có điểm cao nhất theo bài thi",
                            width: 600,
                            height: 400,
                            bar: {
                                groupWidth: "95%"
                            },
                            legend: {
                                position: "none"
                            },
                        };
                        var chart = new google.visualization.ColumnChart(document.getElementById("tk_top5"));
                        chart.draw(view, options);
                    }
                </script>
                <div id="tk_top5" style="width: 50%; height: 300px;"></div>
            </section>
            <section>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['corechart']
                    });
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {

                        var data = google.visualization.arrayToDataTable([
                            ['Task', 'Hours per Day'],
                            ['Work', 11],
                            ['Eat', 2],
                            ['Commute', 2],
                            ['Watch TV', 2],
                            ['Sleep', 7]
                        ]);

                        var options = {
                            title: 'Thống kê tỉ lệ trên trung bình của học sinh theo bài thi'
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                        chart.draw(data, options);
                    }
                </script>

                <div id="piechart" style="width: 50%; height: 500px;"></div>
            </section>
        </div>
        <h3 class="text-center mt-5 mb-3">Danh sách điểm của sinh viên theo đề thi</h3>
        <table class="table table-bordered table-striped align-middle text-center">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Điểm</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>



    </article>