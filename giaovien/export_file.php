<?php
include('../includes/config.php');
include('../includes/database.php');
include('../includes/functionCauHoi.php');
include('../includes/functionCauTraLoi.php');

require_once '../vendor/autoload.php';

$phpWord = new \PhpOffice\PhpWord\PhpWord();

$section = $phpWord->addSection();

$questions = getCauHoi($connect);

$stt = 1;
while ($question = $questions->fetch_assoc()) {
    $section->addText("Câu " . $stt . ": " . $question['noi_dung']);
    $answers = getCauTraLoi($connect, $question['ma_cau_hoi']);
    $answerLetters = ['A.', 'B.', 'C.', 'D.']; 
    $index = 0; 
    while ($answer = $answers->fetch_assoc()) {
        $section->addText($answerLetters[$index] . " " . $answer['noi_dung']);
        if ($answer['la_dap_an'] == 1) {
            // Hiển thị thông tin nếu câu trả lời là đáp án
            $section->addText("", array('underline' => 'single'));
        }
        $index++;  
    }
    $stt++;
}

$filename = 'export.docx';
$phpWord->save($filename);

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . $filename);
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($filename));
ob_clean();
flush();
readfile($filename);
exit;
?>
