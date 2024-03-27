//pagination user
$(document).ready(function(){

    load_data(1);

    function load_data(page, query = '')
    {
        $.ajax({
            url:"fetchUsers.php",
            method:"POST",
            data:{page:page, query:query},
            success:function(data)
            {
            $('#dynamic_content').html(data);
            }
        });
    }

    $(document).on('click', '.page-link', function(){
        var page = $(this).data('page_number');
        var query = $('#search_box').val();
        load_data(page, query);
    });

    $('#search_box').keyup(function(){
        var query = $('#search_box').val();
        load_data(1, query);
    });

}); 

//thong bao xoa nguoi dung
$(document).on("click", "a.delete", function() {
    var id = $(this).attr('id');
    return confirm("Xóa người dùng " + id + "?");
});