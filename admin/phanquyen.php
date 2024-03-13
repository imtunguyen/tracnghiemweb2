<?php
include('../includes/admin_header.php');
include('../includes/database.php');
?>

<?php
include('./view_all_quyen.php');
?>

<?php
include('../includes/admin_footer.php');
?>

<script>
$(document).ready(function() {
  $('#check_all_nguoidung').change(function() {
    if ($(this).is(':checked')) {
      $('#them_nguoidung').prop('checked', true);
      $('#sua_nguoidung').prop('checked', true);
      $('#xoa_nguoidung').prop('checked', true);
    } else {
      $('#them_nguoidung').prop('checked', false);
      $('#sua_nguoidung').prop('checked', false);
      $('#xoa_nguoidung').prop('checked', false);
    }
  });

  $('#check_all_cauhoi').change(function() {
    if ($(this).is(':checked')) {
      $('#them_cauhoi').prop('checked', true);
      $('#sua_cauhoi').prop('checked', true);
      $('#xoa_cauhoi').prop('checked', true);
    } else {
      $('#them_cauhoi').prop('checked', false);
      $('#sua_cauhoi').prop('checked', false);
      $('#xoa_cauhoi').prop('checked', false);
    }
  });

  $('#check_all_quyen').change(function() {
    if ($(this).is(':checked')) {
      $('#them_quyen').prop('checked', true);
      $('#sua_quyen').prop('checked', true);
      $('#xoa_quyen').prop('checked', true);
    } else {
      $('#them_quyen').prop('checked', false);
      $('#sua_quyen').prop('checked', false);
      $('#xoa_quyen').prop('checked', false);
    }
  });

  $('#check_all_dethi').change(function() {
    if ($(this).is(':checked')) {
      $('#them_dethi').prop('checked', true);
      $('#sua_dethi').prop('checked', true);
      $('#xoa_dethi').prop('checked', true);
    } else {
      $('#them_dethi').prop('checked', false);
      $('#sua_dethi').prop('checked', false);
      $('#xoa_dethi').prop('checked', false);
    }
  });

  $('#check_all_lop').change(function() {
    if ($(this).is(':checked')) {
      $('#them_lop').prop('checked', true);
      $('#sua_lop').prop('checked', true);
      $('#xoa_lop').prop('checked', true);
    } else {
      $('#them_lop').prop('checked', false);
      $('#sua_lop').prop('checked', false);
      $('#xoa_lop').prop('checked', false);
    }
  });

  $('#check_all_monhoc').change(function() {
    if ($(this).is(':checked')) {
      $('#them_monhoc').prop('checked', true);
      $('#sua_monhoc').prop('checked', true);
      $('#xoa_monhoc').prop('checked', true);
    } else {
      $('#them_monhoc').prop('checked', false);
      $('#sua_monhoc').prop('checked', false);
      $('#xoa_monhoc').prop('checked', false);
    }
  });
});
</script>