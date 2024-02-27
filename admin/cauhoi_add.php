<?php
include('../includes/admin_header.php');
?>
<div class="w-100 card border-0 p-4">
    <div class="card-header bg-success bg-gradient ml-0 py-3">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="text-white py-2">Thêm câu hỏi</h2>
            </div>
        </div>
    </div>
    <div class="card-body border p-4">
        <form method="post" class="row">
            <div>
                <p>Câu hỏi</p>
            </div>
            <div class="p-3 pt-0">
                <div class="form-floating py-1 col-12">
                    <input class="form-control border shadow" />
                    <label class="ms-2">Nội dung</label>
                    <span></span>
                </div>
            </div>
            <div class="p-3">
                <p>Câu trả lời</p>
                <select class="form-select" name="" id="">
                    <option>--Chọn số câu trả lời--</option>
                    <option value="2">2</option>
                    <option value="4">4</option>
                </select>
            </div>
            <div class="p-3 pt-0">
                <div class="form-floating py-1 col-12">
                    <input class="form-control border shadow" />
                    <label class="ms-2">Câu A</label>
                </div>
                <input type="radio" name="answer" value="A" class="ms-2 mt-2"/>
            </div>
            <div class="p-3 pt-0">
                <div class="form-floating py-1 col-12">
                    <input class="form-control border shadow" />
                    <label class="ms-2">Câu B</label>
                </div>
            </div>
            <div class="p-3 pt-0">
                <div class="form-floating py-1 col-12">
                    <input class="form-control border shadow" />
                    <label class="ms-2">Câu C</label>
                </div>
            </div>
            <div class="p-3 pt-0">
                <div class="form-floating py-1 col-12">
                    <input class="form-control border shadow" />
                    <label class="ms-2">Câu D</label>
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-6 col-md-3">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-check-circle"></i> Thêm
                    </button>
                </div>
                <div class="col-6 col-md-3">
                    <a class="btn btn-secondary w-100" href="../admin/cauhoi.php">
                        <i class="bi bi-x-circle"></i> Trở về
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
include('../includes/admin_footer.php');
?>