


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