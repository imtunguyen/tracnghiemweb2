<?php 
    include '../includes/config.php';
    include '../includes/database.php';
    include '../includes/functionCauHoi.php';
    include '../includes/functions.php';
    include '../includes/functionDeThi.php';
    include '../includes/functionChiTietDeThi.php';
    include '../includes/functionCauTraLoi.php';
    include '../includes/functionMonHoc.php';

    $cauhoi = getCauHoi($connect);
    $monhoc = getMonHoc($connect);
    $dethi = getChiTietDeThibyId($connect, $_GET['id']);
    $_SESSION['ma_de_thi'] = $_GET['id'];


    if(isset($_POST['submit'])){
        $ma_cau_hoi_array = $_POST['ma_cau_hoi'];
        $ma_de_thi = $_SESSION['ma_de_thi'];
        deleteChiTietDeThi($connect, $ma_de_thi);
        foreach($ma_cau_hoi_array as $ma_cau_hoi){
            addChiTietDeThi($connect, $ma_de_thi, $ma_cau_hoi);
        }
        header("Location: dethi.php");
        $_SESSION['toastr'] = 'Thêm câu hỏi vào đề thi thành công';
        exit;
    }
    
    ?>
    <script>
        $(document).ready(function() {
            $('.tables_ui tbody tr').click(function() {
                $(this).toggleClass('selected');
            });
        });
    </script>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Đề thi Edit</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/style.css"> 
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="https://unpkg.com/placeholder-loading/dist/css/placeholder-loading.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    </head>
    <body>

    <div class="container">
        <div class="row gx-5">
            <div class="col-12 mb-3 sticky-top">
                <div class="row">
                    <div class="col-4">
                        <input type="text" name="search_box" id="search_box" class="form-control" placeholder="Tìm kiếm câu hỏi" />
                    </div>
                    <div class="col-4">
                        <select class="form-select" name="filter_monhoc" id="filter_monhoc">
                            <option disabled selected>Môn học</option>
                            <?php while($monhoc_record = $monhoc->fetch_assoc()) { ?>
                                <option value="<?php echo $monhoc_record['ma_mon_hoc']; ?>"><?php echo $monhoc_record['ten_mon_hoc']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-4">
                        <select class="form-select" name="filter_dokho" id="filter_dokho">
                            <option disabled selected>Độ khó</option>
                            <option value="Dễ">Dễ</option>
                            <option value="Trung bình">Trung bình</option>
                            <option value="Khó">Khó</option>
                        </select>
                    </div>
                </div>
                <hr>
            </div>
            <div class="col-5 border overflow-y-scroll" style="height: 600px;">
                <div class="p-3">Câu hỏi</div>
                <table class=" table-striped " id="t_draggable1">
                <tbody class="t_sortable">
                    <tr>
                        <th>STT</th>
                        <th>Nội dung câu hỏi</th>
                    </tr>
                    <?php
                    $stt = 1; 
                    
                    while ($cauhoi_record = $cauhoi->fetch_assoc()) { ?>
                    
                        <tr>
                        <td> <?php echo $stt ?> </td>
                        <td> <?php echo $cauhoi_record["noi_dung"] ?></td>
                        <input type="hidden" name="ma_cau_hoi[]" value="' <?php echo $cauhoi_record['ma_cau_hoi'] ?> '">
                        </tr>
                    <?php
                        $stt++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="col-2 d-flex align-items-center justify-content-center">
                <div class="btn-group-vertical">
                    <button class="btn btn-primary mb-3">>></button>
                    <button class="btn btn-primary mb-3"><<</button>
                    <button class="btn btn-primary mb-3" id="tab1_2">></button>
                    <button class="btn btn-primary"><</button>
                </div>
            </div>
            <div class="col-5 border">
                <div class="p-3">Câu hỏi trong đề thi</div>
                <form action="" method="post">
                    <table class="tables_ui table table-border overflow-y-scroll" id="t_draggable2"style="height: 500px">
                        
                        <tr>
                            <th>STT</th>
                            <th>Nội dung câu hỏi</th>
                        </tr>
                        <tbody class="t_sortable ">
                        <?php
                        if ($dethi->num_rows > 0) {
                            $stt = 1;
                            while ($chiTiet = $dethi->fetch_assoc()) {
                                $noidung = getCauHoibyID($connect, $chiTiet["ma_cau_hoi"]);
                                $noidungch = $noidung->fetch_assoc();
                                echo '<tr>';
                                echo '<td>' . $stt . '</td>';
                                echo '<td>' . $noidungch["noi_dung"] . '</td>';
                                echo '<input type="hidden" name="ma_cau_hoi[]" value="' . $noidungch['ma_cau_hoi'] . '">';
                                echo '</tr>';
                                $stt++;
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                    <div class="text-end">
                        <button class="btn btn-primary" type="submit" name="submit" >Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
    var $t_draggable1 = $("#t_draggable1");
        $("tbody.t_sortable").sortable({
            connectWith: ".t_sortable",
            items: "> tr:not(:first)",
            appendTo: $t_draggable1,
            helper: "clone",
            zIndex: 999990
        }).disableSelection();

        $t_draggable1.droppable({
            accept: ".t_sortable tr",
            hoverClass: "ui-state-hover",
            drop: handleDrop
        });

        var $t_draggable2 = $("#t_draggable2");
        $t_draggable2.sortable({
            connectWith: ".t_sortable",
            items: "> tr:not(:first)",
            appendTo: $t_draggable2,
            helper: "clone",
            zIndex: 999990,
            stop: function(event, ui) {
                // Xử lý khi thả phần tử
                var ma_cau_hoi = ui.item.find("input[name='ma_cau_hoi[]']").val();
                console.log("Câu hỏi được kéo ra ma_cau_hoi:", ma_cau_hoi);
            }
        });

        function handleDrop(event, ui) {
            var droppedRow = ui.draggable;
            var ma_cau_hoi_input = droppedRow.find("input[name='ma_cau_hoi[]']");
            if (ma_cau_hoi_input.length > 0) {
                var ma_cau_hoi = ma_cau_hoi_input.val();
                console.log("Câu hỏi được kéo ma_cau_hoi:", ma_cau_hoi);
            } else {
                console.log("Không tìm thấy mã câu hỏi.");
            }
            return false;
        }

    });
    </script>

    <script>
    $(document).ready(function() {
        $("#tab1_2").on('click', function() {
            $("#t_draggable1 tbody tr.selected").each(function() {
                var selectedRow = $(this);
                moveRow(selectedRow);
            });
        });
        $("#t_draggable1 tbody").on('click', 'tr', function() {
            var selectRow = $(this).toggleClass('selected');
        });
        function moveRow(selectedRow) {
            var newRow = selectedRow.clone();
            $('#t_draggable2 tbody').append(newRow);
            selectedRow.remove();
        }
    });
      
    </script>
    </body>
    </html>