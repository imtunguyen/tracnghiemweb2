<?php
require_once '../vendor/autoload.php';


if(isset($_FILES['fileToUpload'])) {
    $questions = [];
      $answers = [];
  
      $currentQuestion = '';
      $currentAnswers = [];
      // Get the temporary file path
      $tmpFilePath = $_FILES['fileToUpload']['tmp_name'];
  
      // Load the Word file
      $phpWord = \PhpOffice\PhpWord\IOFactory::load($tmpFilePath); 
  
             // Get the document sections
      $sections = $phpWord->getSections();
      foreach($sections as $section) {
          $elements = $section->getElements();
          foreach($elements as $element) {
              if($element instanceof \PhpOffice\PhpWord\Element\TextRun){
                $text = $element->getText();

                
                if (strpos($text, "Câu") === 0 && strpos($text, "Câu ") !== false && strpos($text, ":") !== false) {
                    // Nếu đã có câu hỏi trước đó, lưu vào mảng câu hỏi và câu trả lời
                    if (!empty($currentQuestion) && !empty($currentAnswers)) {
                        $questions[] = $currentQuestion;
                        $answers[] = $currentAnswers;
                    }
                    // Đặt lại câu hỏi và câu trả lời hiện tại
                    $currentQuestion = $text;
                    $currentAnswers = [];
                } elseif (strpos($text, "A.") === 0 || strpos($text, "B.") === 0 || strpos($text, "C.") === 0 || strpos($text, "D.") === 0) {
                    // Thêm câu trả lời vào mảng câu trả lời của câu hỏi hiện tại
                    $currentAnswers[] = $text;
                  
                }
               
            }
          }
      } 
      foreach ($questions as $index => $question) {
        ?> <div class="btn btn-primary custom-div"><?php echo $question; ?></div><br>
         <?php
         foreach ($answers[$index] as $answer) {
             echo "$answer  <br>";
         }
         echo "<br>";
     }
}
  
