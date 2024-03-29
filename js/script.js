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
    $(this).one("click", function() {
        return confirm("Xóa Người Dùng " + id + "?");
    });
});

//thong bao xoa quyen
$(document).on("click", "a.delete_role", function() {
    var id = $(this).attr('id');
    $(this).one("click", function() {
        return confirm("Xóa Quyền " + id + "?");
    });
});



document.getElementById('answerCount').addEventListener('change', function(){
    var count = this.value;
    var container = document.getElementById('answerContainer');
    container.innerHTML = '';
     for(var i=0;i<count;i++){
        container.innerHTML +=`
        <div class="p-3 pt-0">
            <div class="input-group ">
                <div class="input-group-text btn">
                    <input class="form-check-input" type="radio" value="${i+1}" name="flexRadioDefault" id="flexRadioDefault${i+1}">
                </div>
                <input type="text" class="form-control" name="cau_tra_loi[]" id="cau_tra_loi${i+1}">
                <div class="input-group-text ">
                    <i class="bi bi-card-image"></i>
                </div>
            </div>
        </div>
        `;
     }
});