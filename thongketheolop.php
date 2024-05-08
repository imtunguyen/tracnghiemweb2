<?php
include('./includes/header.php');
include('./includes/database.php');
if (!(isset($_SESSION['username']) && isset($_SESSION['userId']))) {
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
    JOIN chi_tiet_quyen ctq on ctq.user_id = kq.user_id
    Join chi_tiet_chuc_nang ctcn on ctcn.ma_quyen = ctq.ma_quyen 
    Where ctcn.ma_chuc_nang = 22
     AND chi_tiet_lop.ma_lop = $ma_lop
    GROUP BY kq.user_id
) AS subquery";
$result_get_dtb_lop = mysqli_query($connect, $sql_get_dtb_lop);
$row_get_dtb_lop = mysqli_fetch_assoc($result_get_dtb_lop);
$dtb_lop = $row_get_dtb_lop['trungBinh'];

// get tong ket qua trong lop
$sql_get_slKq = "SELECT count(kq.user_id) as SlKq From ket_qua kq Join 
chi_tiet_lop ctl on kq.user_id = ctl.user_id Join lop on lop.ma_lop = ctl.ma_lop
JOIN chi_tiet_quyen ctq on ctq.user_id = kq.user_id
Join chi_tiet_chuc_nang ctcn on ctcn.ma_quyen = ctq.ma_quyen Where ctcn.ma_chuc_nang = 22 AND ctl.ma_lop = $ma_lop";
$result_get_slKq = mysqli_query($connect, $sql_get_slKq);
$row_slKq = mysqli_fetch_assoc($result_get_slKq);
$slKq = $row_slKq['SlKq'];

// get tong ket qua trong lop >= 9

$sql_get_slkq9 = "SELECT count(kq.user_id) as slkq From ket_qua kq Join 
chi_tiet_lop ctl on kq.user_id = ctl.user_id Join lop on lop.ma_lop = ctl.ma_lop
JOIN chi_tiet_quyen ctq on ctq.user_id = kq.user_id
Join chi_tiet_chuc_nang ctcn on ctcn.ma_quyen = ctq.ma_quyen Where ctcn.ma_chuc_nang = 22 AND ctl.ma_lop = $ma_lop
AND kq.diem >= 9";
$result_get_slkq9 = mysqli_query($connect, $sql_get_slkq9);
$row_slKq9 = mysqli_fetch_assoc($result_get_slkq9);
$slKq9 = $row_slKq9['slkq'];

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
                        <p class="m-0"><?php echo ($slKq9 / $slKq) * 100  ?></p>
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
                    ["Element", "Điểm", {
                        role: "style"
                    }],
                    <?php 
                        $sql_select_top10 = "SELECT kq.*, dt.ten_de_thi, users.ho_va_ten
                        FROM ket_qua kq 
                        JOIN chi_tiet_lop ctl ON kq.user_id = ctl.user_id 
                        JOIN lop ON lop.ma_lop = ctl.ma_lop
                        JOIN bai_thi ON kq.ma_bai_thi = bai_thi.ma_bai_thi
                        JOIN de_thi dt ON dt.ma_de_thi = bai_thi.ma_de_thi 
                        JOIN users ON users.id = kq.user_id
                        JOIN chi_tiet_quyen ctq on ctq.user_id = kq.user_id
                        Join chi_tiet_chuc_nang ctcn on ctcn.ma_quyen = ctq.ma_quyen 
                        Where ctcn.ma_chuc_nang = 22 AND ctl.ma_lop = $ma_lop  
                        ORDER BY kq.diem DESC 
                        LIMIT 10;
                        ";
                        $result_top10 = mysqli_query($connect, $sql_select_top10);
                        if(mysqli_num_rows($result_top10) > 0) {
                            while($row_top10 = mysqli_fetch_assoc($result_top10)) {
                                echo "['" .$row_top10["ho_va_ten"]. " - ". $row_top10["ten_de_thi"] ."', " .$row_top10["diem"]. ", " ."'silver'],";
                            }
                        }
                    ?>
                    
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
                    <select class="form-select" id="bai_thi_select">
                        <option selected>--Chọn đề thi--</option>
                        <?php
                        $sql_get_baithi = "SELECT bt.ma_bai_thi, dt.ten_de_thi
                        FROM bai_thi bt 
                        JOIN de_thi dt ON bt.ma_de_thi = dt.ma_de_thi
                        JOIN lop l ON l.ma_lop = bt.ma_lop
                        WHERE l.ma_lop = $ma_lop";
                        $result_get_baithi = mysqli_query($connect, $sql_get_baithi);
                        if(mysqli_num_rows($result_get_baithi) > 0) {
                            while($row_get_baithi = mysqli_fetch_assoc($result_get_baithi)) {
                                echo "<option value='" .$row_get_baithi['ma_bai_thi']. "'>" .$row_get_baithi['ten_de_thi']. "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="d-flex gap-5 align-items-center">
            <section>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    var chartTop5;
                    $(document).ready(function() {
                        $('#bai_thi_select').change(function() {
                            var selectedBaiThiId = $(this).val();
                            
                            // xử lý Thống kê Top 5 học sinh có điểm cao nhất theo đề thi
                            $.ajax({
                                type: 'POST',
                                url: 'xulytk_top5hsdiemcaonhat.php',
                                data: { ma_bai_thi: selectedBaiThiId, ma_lop: <?php echo $ma_lop; ?> },
                                success: function(response) {
                                    let array = JSON.parse(response);
                                    var convertedArray = array.map(function(item) {
                                        return [item[0], parseInt(item[1]), item[2]];
                                    });
                                        console.log(convertedArray);
                                    drawChartTop5(convertedArray);
                                },
                                error: function(xhr, status, error) {
                                    console.error('Đã xảy ra lỗi khi gửi giá trị: ' + error);
                                }
                            });

                            // Xử lý Thống kê tỉ lệ trên trung bình của học sinh theo đề thi

                            $.ajax({
                                type: 'POST',
                                url: 'xulytk_tiletrentb.php',
                                data: { ma_bai_thi: selectedBaiThiId, ma_lop: <?php echo $ma_lop; ?> },
                                success: function(response) {
                                    console.log("Xy ly ti le tren tb");
                                    let array = JSON.parse(response);
                                        console.log(response);
                                        drawPieChart(array);
                                },
                                error: function(xhr, status, error) {
                                    console.error('Đã xảy ra lỗi khi gửi giá trị: ' + error);
                                }
                            });
                        });
                    });
                        google.charts.load("current", {
                        packages: ['corechart']
                    });
                    google.charts.setOnLoadCallback(drawChartTop5);

                    function drawChartTop5(array) {
                        // Kiểm tra nếu biểu đồ đã được khởi tạo trước đó, thì xóa nó
                        if (chartTop5) {
                            chartTop5.clearChart();
                        }

                        console.log(...array);
                        // Tạo DataTable từ dữ liệu mới
                        var data = google.visualization.arrayToDataTable([
                            ["Element", "Điểm", { role: "style" }],
                            ...array 
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
                            title: "Thống kê Top 5 học sinh có điểm cao nhất theo đề thi",
                            width: 600,
                            height: 400,
                            bar: {
                                groupWidth: "95%"
                            },
                            legend: {
                                position: "none"
                            },
                        };
                        chartTop5 = new google.visualization.ColumnChart(document.getElementById("tk_top5"));
                        chartTop5.draw(view, options);
                    }
                </script>
                <div id="tk_top5" style="width: 50%; height: 300px;"></div>
            </section>
            
            <section>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    var pieChart;
                    google.charts.load('current', {
                        'packages': ['corechart']
                    });
                    google.charts.setOnLoadCallback(drawPieChart);

                    function drawPieChart(array) {
                        if(pieChart) {
                            pieChart.clearChart();
                        }
                        var data = google.visualization.arrayToDataTable([['Loại', 'Điểm'],...array]);

                        var options = {
                            title: 'Thống kê tỉ lệ trên trung bình của học sinh theo đề thi',
                            chartArea: {width: '100%', height: '80%', left: '10%', top: '30%'}
                        };

                        pieChart = new google.visualization.PieChart(document.getElementById('piechart'));

                        pieChart.draw(data, options);
                    }
                </script>

                <div id="piechart" style="width: 50%; height: 400px;"></div>
            </section>
        </div>
        <h4 class="text-center mt-5 mb-3">Danh sách điểm của sinh viên theo đề thi</h4>
        <table class="table table-bordered table-striped align-middle text-center">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Điểm</th>
                </tr>
            </thead>
            <tbody id="dsKq">
                <script>
                    $(document).ready(function() {
                        $('#bai_thi_select').change(function() {
                            var selectedBaiThiId = $(this).val();
                            $.ajax({
                                type: 'POST',
                                url: 'xulytk_dskq.php',
                                data: { ma_bai_thi: selectedBaiThiId, ma_lop: <?php echo $ma_lop; ?> },
                                success: function(response) {
                                    $('#dsKq').html(response);
                                    console.log(response);
                                },
                                error: function(xhr, status, error) {
                                    console.error('Đã xảy ra lỗi khi gửi giá trị: ' + error);
                                }
                            });
                        });
                    });
                </script>
            </tbody>
        </table>
    </article>