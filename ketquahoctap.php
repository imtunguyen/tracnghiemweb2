<?php
include('./includes/header.php');
include('./includes/database.php');
?>

<div class="container">
    <h1 class="text-center mb-5">Thống kê kết quả học tập của sinh viên</h1>
    <div class="row">
        <p>Kết quả học tập</p>
        <select class="form-select" id="lop_select">
            <option selected>--Chọn lớp--</option>
            <?php
            $user_id = $_SESSION['userId'];
            $sql_get_lophoc = "SELECT lop.ma_lop, lop.ten_lop
            FROM lop 
            JOIN chi_tiet_lop ctl ON ctl.ma_lop = lop.ma_lop
            JOIN users ON users.id = ctl.user_id
            WHERE users.id = $user_id";
            $result_get_lophoc = mysqli_query($connect, $sql_get_lophoc);
            if(mysqli_num_rows($result_get_lophoc) > 0) {
                while($row_get_lophoc = mysqli_fetch_assoc($result_get_lophoc)) {
                    echo "<option value='" .$row_get_lophoc['ma_lop']. "'>" .$row_get_lophoc['ten_lop']. "</option>";
                }
            }
            ?>
        </select>
    </div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">

            var chart;
            $(document).ready(function() {
                $('#lop_select').change(function() {
                    var selectedlopHocId = $(this).val();
                    console.log(selectedlopHocId);
                    $.ajax({
                        type: 'POST',
                        url: 'xulytk_ketquahoctap.php',
                        data: { ma_lop: selectedlopHocId },
                        success: function(response) {
                            if(response != "Không có dữ liệu." && response != "Thiếu dữ liệu đầu vào.") {
                                let array = JSON.parse(response);
                                var convertedArray = array.map(function(item) {
                                return [item[0], parseInt(item[1]), item[2]];
                                });
                            console.log(convertedArray);
                            drawChart(convertedArray);
                                
                            } else {
                                chart.clearChart();
                               
                            }
                            
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
            google.charts.setOnLoadCallback(drawChart);

            function drawChart(array) {
                if (chart) {
                    chart.clearChart();
                }

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
                    title: "Kết quả học tập theo lớp",
                    width: "100%",
                    height: 400,
                    bar: {
                        groupWidth: "95%"
                    },
                    legend: {
                        position: "none"
                    },
                };
                chart = new google.visualization.ColumnChart(document.getElementById("tk_kq"));
                chart.draw(view, options);
            }
        </script>
</div>
<div id="tk_kq" style="width: 100%; height: 300px;"></div>
<div class="container" style="margin-top: 120px;">
    <h2 class="text-center mb-3">
        Danh sách kết quả tất cả các bài thi của sinh viên
    </h2>
    <table class="table table-bordered table-striped align-middle text-center">
        <thead>
            <tr>
                <th>STT</th>
                <th>Lớp</th>
                <th>Đề thi</th>
                <th>Số câu đúng</th>
                <th>Số câu sai</th>
                <th>Số câu chưa chọn</th>
                <th>Điểm</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $user_id = $_SESSION['userId'];
                $sql_get_all_kq = "SELECT DISTINCT kq.*, dt.ten_de_thi, lop.ten_lop
                FROM ket_qua kq 
                JOIN bai_thi ON kq.ma_bai_thi = bai_thi.ma_bai_thi
                JOIN de_thi dt ON dt.ma_de_thi = bai_thi.ma_de_thi
                JOIN users ON users.id = kq.user_id
                JOIN chi_tiet_lop ctl ON ctl.ma_lop = bai_thi.ma_lop 
                JOIN lop ON lop.ma_lop = ctl.ma_lop
                WHERE users.id = $user_id
";
                $result_get_all = mysqli_query($connect, $sql_get_all_kq);
                $stt = 0;
                while ($row_get_all = mysqli_fetch_assoc($result_get_all)) {
                    $stt += 1;
                    echo "<tr>
                    <td>" . $stt . "</td>
                    <td>" . $row_get_all['ten_lop'] . "</td>
                    <td>" . $row_get_all['ten_de_thi'] . "</td>
                    <td>" . $row_get_all['so_cau_dung'] . "</td>
                    <td>" . $row_get_all['so_cau_sai'] . "</td>
                    <td>" . $row_get_all['so_cau_chua_chon'] . "</td>
                    <td>" . $row_get_all['diem'] . "</td>
                  </tr>";
                }
            ?>
        </tbody>
    </table>
</div>