</div>
</main>
</div>
</div>
<footer class=< footer class="border-top footer bg-dark">
    <div class="container text-center text-light">
    </div>
</footer>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/script.js"></script>

</body>
</html>

<script>
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

$(document).on("click", "a.delete", function() {
  var id = $(this).attr('id');
  return confirm("Xóa người dùng " + id + "?");
});

</script>