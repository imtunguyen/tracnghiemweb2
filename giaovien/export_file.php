<html>
<?php

include('../includes/config.php');
include('../includes/database.php');
include('../includes/functionCauHoi.php');
include('../includes/functionCauTraLoi.php');
ob_start();
require_once '../vendor/autoload.php';

$phpWord = new \PhpOffice\PhpWord\PhpWord();

$section = $phpWord->addSection();

$questions = getCauHoi($connect,$_SESSION['userId']);
$output = '';
$stt = 1;
while ($question = $questions->fetch_assoc()) {
    $output ="
				<h5> Câu " . $stt . ": " . $question['noi_dung']."</h5><br>
			";
    $answers = getCauTraLoi($connect, $question['ma_cau_hoi']);
    $answerLetters = ['A.', 'B.', 'C.', 'D.']; 
    $index = 0; 
    while ($answer = $answers->fetch_assoc()) {
        $answerTest = $answerLetters[$index] . " " . $answer['noi_dung'];
        if ($answer['la_dap_an'] == 1) {
            $output .= "<u>". $answerTest. "</u><br>";
        } else {
            $output .= " $answerTest<br>";
        }
        $index++;  
    }
    $stt++;

    	
    echo $output;
}

$date = 'export';		
header("Content-Type: application/vnd.msword");
header("content-disposition: attachment;filename=".$date.".doc");

ob_end_flush();
?></html>