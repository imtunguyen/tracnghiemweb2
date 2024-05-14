

<?php 
    include '../includes/header.php';
    include '../includes/database.php';
    include '../includes/functionCauHoi.php';
    include '../includes/functionDeThi.php';
    include '../includes/functionChiTietDeThi.php';
    include '../includes/functionCauTraLoi.php';
    include '../includes/functionMonHoc.php';

    $cauhoi = getCauHoi($connect);
    $monhoc = getMonHoc($connect);
    $ma_nguoi_tao=$_SESSION['userId'];
    $addchdethi=AddCHDethi($connect,$_GET['id'],$ma_nguoi_tao);
    $dethi = getChiTietDeThibyId($connect, $_GET['id']);
    $_SESSION['ma_de_thi'] = $_GET['id'];
    


    if(isset($_POST['submit'])){
        $ma_cau_hoi_array = $_POST['ma_cau_hoi'];
        echo 'array';
        print_r($ma_cau_hoi_array);
        $ma_de_thi = $_SESSION['ma_de_thi'];
        deleteChiTietDeThi($connect, $ma_de_thi);
        foreach($ma_cau_hoi_array as $ma_cau_hoi){
            echo "ma cau hoi" .$ma_cau_hoi;
            addChiTietDeThi($connect, $ma_de_thi,$ma_cau_hoi);
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
                    <div class="col-3">
                        <input type="text" name="search_box" id="search_box" class="form-control" placeholder="Tìm kiếm câu hỏi" />
                    </div>
                    <div class="col-3">
                        <select class="form-select" name="filter_monhoc" id="filter_monhoc">
                            <option disabled selected>Môn học</option>
                            <?php while($monhoc_record = $monhoc->fetch_assoc()) { ?>
                                <option value="<?php echo $monhoc_record['ma_mon_hoc']; ?>"><?php echo $monhoc_record['ten_mon_hoc']; ?></option>
<?php } ?>
                        </select>
                    </div>
                    <div class="col-3">
                        <select class="form-select" name="filter_dokho" id="filter_dokho">
                            <option disabled selected>Độ khó</option>
                            <option value="Dễ">Dễ</option>
                            <option value="Trung bình">Trung bình</option>
                            <option value="Khó">Khó</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <button class="btn btn-info" id="refresh">REFRESH</button>
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
                    
                    while ($cauhoi_record = $addchdethi->fetch_assoc()) { 
                        $noidung = getCauHoibyID($connect, $cauhoi_record["ma_cau_hoi"]);
                        $chdethi = $noidung->fetch_assoc(); ?>
                        <tr>
                        <td> <?php echo $stt ?> </td>
                        <td> <?php echo $chdethi["noi_dung"] ?></td>
                        <input type="hidden" name="ma_cau_hoi[]" value=" <?php echo $cauhoi_record['ma_cau_hoi'] ?> ">
                        </tr>
                    <?php
                        $stt++;
                    }?>
                    </tbody>
                </table>
            </div>
            <div class="col-2 d-flex align-items-center justify-content-center">
                <div class="btn-group-vertical">
                    <button class="btn btn-primary mb-3" id=tabAll_2>>></button>
                    <button class="btn btn-primary mb-3" id=tabAll_1><<</button>
                    <button class="btn btn-primary mb-3" id="tab1_2">></button>
                    <button class="btn btn-primary mb-3" id="tab2_1"><</button>
                </div>
            </div>
            <div class="col-5 border overflow-y-scroll " style="height: 600px;">
                <div class="p-3">Câu hỏi trong đề thi</div>
                <form action="" method="post">
                    <table class="table-striped" id="t_draggable2">
                    <tbody class="t_sortable ">
                        <tr>
                            <th>STT</th>
                            <th>Nội dung câu hỏi</th>
                        </tr>
                        
                        <?php
                        if ($dethi->num_rows > 0) {
                            $stt = 1;
                            $stt = 1;
                            while ($chiTiet = $dethi->fetch_assoc()) {
                                $noidung = getCauHoibyID($connect, $chiTiet["ma_cau_hoi"]);
                                $noidungch = $noidung->fetch_assoc();
                                echo '<tr>';
                                echo '<td>' . $stt . '</td>';
                                echo '<td>' . $noidungch["noi_dung"] . '</td>';
                                echo '<input type="hidden" name="ma_cau_hoi[]" value="' .$noidungch['ma_cau_hoi'] .'">';
                                echo '</tr>';
                                $stt++;
                            }
                        }
                        ?>
                        </tbody>
                    </table>
            </div>
            
        </div>
        <div class="text-end mt-3">
                <button class="btn btn-primary" type="submit" name="submit">Save</button>
            </form>
        </div>
    </div>
   

    <script>
    $(document).ready(function() {
        $("#t_draggable1 tbody").on('click', 'tr', function() {
            if (!$(this).is(':first-child')) {
                var selectRow = $(this).toggleClass('selected');
            }  
        });
        
        $("#t_draggable2 tbody").on('click', 'tr', function() {
            if (!$(this).is(':first-child')) {
                var selectRow = $(this).toggleClass('selected');
            }  
        });

        $('#tabAll_2').click(function() {
            var selectedRow=$('#t_draggable1 tbody tr:not(:first-child)');
            var table=$('#t_draggable2 tbody');
            moveRow(selectedRow,table);
        });

        // Di chuyển tất cả hàng từ bảng 2 sang bảng 1
        $('#tabAll_1').click(function() {
            var selectedRow=$('#t_draggable2 tbody tr:not(:first-child)');
            var table=$('#t_draggable1 tbody');
            moveRow(selectedRow,table);
        });

        // Di chuyển hàng đã chọn từ bảng 2 sang bảng 1
        $('#tab2_1').click(function() {
            var selectedRow=$('#t_draggable2 .selected');
            var table=$('#t_draggable1 tbody');
            moveRow(selectedRow,table);
        });
        $('#tab1_2').click(function() {
            var selectedRow=$('#t_draggable1 .selected');
            var table=$('#t_draggable2 tbody');
            moveRow(selectedRow,table);
        });

        function moveRow(row, table) {
            row.each(function() {
                var hiddenInput = $(this).find("input[name='ma_cau_hoi[]']");
                hiddenInput.appendTo(table);

                var ma_cau_hoi = hiddenInput.val();
                console.log('Mã câu hỏi vừa di chuyển: ' + ma_cau_hoi);
            });

            row.appendTo(table);
            row.removeClass('selected');
        }
      
        $('#refresh').click(function(){
            $('#filter_monhoc option:first').prop('selected', true);
            $('#filter_dokho option:first').prop('selected', true);
            $('#search_box').val('');
            $.ajax({
                url: 'dethi_search.php', 
                type: 'GET',
                data: {search_text: '', mon_hoc: '', do_kho: ''}, 
                success: function(response) {
                    $('#t_draggable1 tbody').html(response);
                }
        });
        });
    });
</script>

<
<script>
    $(document).ready(function() {
$('#search_box, #filter_monhoc, #filter_dokho').change(function() {
        var searchText = $('#search_box').val();
        var monHoc = $('#filter_monhoc').val();
        var doKho = $('#filter_dokho').val();
        $.ajax({
            url: 'dethi_search.php',
            type: 'GET',
            data: {search_text: searchText, mon_hoc: monHoc, do_kho: doKho,},
            success: function(response) {
                $('#t_draggable1 tbody').html(response);
            }
        });
    });
});
</script>

    </body>
    </html>
