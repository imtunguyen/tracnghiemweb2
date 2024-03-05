<?php

function thongBao(){
    if (isset($_SESSION['toastr'])) { ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script type="text/javascript">
        toastr.success("<?php echo $_SESSION['toastr']; ?>");
        </script>"
        <?php
        unset($_SESSION['toastr']);
    }
}
function secure() {
    if(!isset($_SESSION['id'])){
        $_SESSION['message'] = "Please login first to view this page.";
        header('Location: /');
        die();
    }
}
function docFile(){
    // Kiểm tra xem file đã được tải lên chưa
    if (!isset($_FILES['fileToUpload']['tmp_name']) || empty($_FILES['fileToUpload']['tmp_name'])) {
        return []; // Trả về mảng rỗng nếu không có file nào được tải lên
    }

    $tmpFilePath = $_FILES['fileToUpload']['tmp_name'];
    $phpWord = \PhpOffice\PhpWord\IOFactory::load($tmpFilePath);
    $questionsAndAnswers = [];
    $sections = $phpWord->getSections();

    foreach($sections as $section){
        $elements = $section->getElements();
        $currentQuestion = '';
        $currentAnswers = [];

        foreach($elements as $element){
            if($element instanceof \PhpOffice\PhpWord\Element\TextRun){
                $text = $element->getText();
                // Kiểm tra nếu đây là câu hỏi
                if (strpos($text, "Câu") === 0 && strpos($text, "Câu ") !== false && strpos($text, ":") !== false) {
                    // Nếu có câu hỏi và câu trả lời trước đó, thêm vào mảng
                    if (!empty($currentQuestion) && !empty($currentAnswers)) {
                        $questionsAndAnswers[] = [
                            'question' => $currentQuestion,
                            'answers' => $currentAnswers
                        ];
                    }
                    // Đặt lại câu hỏi và câu trả lời cho câu hỏi mới
                    $currentQuestion = $text;
                    $currentAnswers = [];
                } 
                // Kiểm tra nếu đây là câu trả lời
                elseif (preg_match('/^[A-D]\./', $text)) {
                    // Thêm câu trả lời vào mảng
                    $currentAnswers[] = $text;
                }
            }
        }
        // Thêm câu hỏi và câu trả lời cuối cùng vào mảng
        if (!empty($currentQuestion) && !empty($currentAnswers)) {
            $questionsAndAnswers[] = [
                'question' => $currentQuestion,
                'answers' => $currentAnswers
            ];
        }
    }
    return $questionsAndAnswers; // Trả về mảng câu hỏi và câu trả lời
}
