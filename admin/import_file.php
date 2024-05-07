<?php
ob_start();
include '../includes/config.php';
include '../includes/database.php';
include '../includes/functionCauHoi.php';
include '../includes/functionCauTraLoi.php';
include '../includes/functionMonHoc.php';
include '../includes/functions.php';
require_once '../vendor/autoload.php';

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Style\Font;

if (isset($_FILES['fileToUpload'])) {
    $tmpFilePath = $_FILES['fileToUpload']['tmp_name'];
    // Load the Word file
    $phpWord = IOFactory::load($tmpFilePath);

    $questions = [];
    $answers = [];
    $currentQuestion = '';
    $currentAnswers = [];
    $currentCorrectAnswer = '';
    $difficultyLevels = [];
    $doKho = '';
    foreach ($phpWord->getSections() as $section) {
        foreach ($section->getElements() as $element) {
            if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                $fullText = '';
                foreach ($element->getElements() as $text) {
                    if ($text instanceof \PhpOffice\PhpWord\Element\Text) {
                        $fullText .= $text->getText();
                        $underlineStyle = $text->getFontStyle()->getUnderline();
                    }
                }
                if (preg_match('/^Câu \d+:/u', $fullText)) {
                    if (!empty($currentQuestion) && !empty($currentAnswers)) {
                        $questions[] = $currentQuestion;
                        $answers[] = $currentAnswers;
                        $currentCorrectAnswers[] = $currentCorrectAnswer;
                        $difficultyLevels[] = $doKho;
                    }

                    $currentQuestion = preg_replace('/^Câu \d+:/u', '', $fullText);
                  
                    $currentAnswers = [];
                    $currentCorrectAnswer = '';
                    $doKho = 'Dễ';
                    preg_match('/(\*\*|\*)\s*/', $currentQuestion, $matches);
                    $doKho = !empty($matches) ? ($matches[1] == '**' ? 'Khó' : 'Trung bình') : 'Dễ';
                } elseif (preg_match('/^[A-D]\./', $fullText)) {
                    $answer = str_replace(['A.', 'B.', 'C.', 'D.'], '', $fullText); // Thay thế ký tự "A.", "B.", "C.", "D." bằng chuỗi rỗng
                    $currentAnswers[] = $answer;
                    if ($underlineStyle != Font::UNDERLINE_NONE) {
                        $currentCorrectAnswer = $answer;
                    }
                }
            }
        }
    }
    if (!empty($currentQuestion) && !empty($currentAnswers)) {
        $questions[] = $currentQuestion;
        $answers[] = $currentAnswers;
        $currentCorrectAnswers[] = $currentCorrectAnswer;
        $difficultyLevels[] = $doKho;
    }
    $trang_thai = 1;
    $ma_nguoi_tao = $_SESSION['userId'];
    $ma_mon_hoc = $_POST['ma_mon_hoc'];
    $dap_an = 0;
    echo $ma_mon_hoc;
    foreach ($questions as $index => $question) {
        $difficulty = $difficultyLevels[$index];

        echo "<div class='question-div'><strong>Câu hỏi:</strong> $question</div>";
        echo "<div class='difficulty-div'><strong>Độ khó:</strong> $difficulty</div>";
        addCauHoi($connect, $question, $trang_thai, $ma_nguoi_tao, $ma_mon_hoc, $difficulty);
        foreach ($answers[$index] as $answer) {
            if ($answer === $currentCorrectAnswers[$index]) {
                echo "<div class='btn btn-success'>$answer</div><br>";
                $dap_an = 1;
            } else {
                echo "$answer<br>";
                $dap_an = 0;
            }
            $result = getLastCauHoi($connect);
            $record = $result->fetch_assoc();
            addCauTraLoi($connect, $record['ma_cau_hoi'], $answer, $dap_an);

        }
        echo "<br>";
    }
    $_SESSION['toastr'] = 'Thêm câu hỏi từ File thành công';
    echo "<script>window.location.href = 'cauhoi.php';</script>";
    exit();
}
ob_end_flush();
?>
