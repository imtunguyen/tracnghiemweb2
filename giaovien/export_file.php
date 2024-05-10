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
    $output ="
				<h1> Câu " . $stt . ": " . $question['noi_dung']."</h1>
			";
    $answers = getCauTraLoi($connect, $question['ma_cau_hoi']);
    $answerLetters = ['A.', 'B.', 'C.', 'D.']; 
    $index = 0; 
    while ($answer = $answers->fetch_assoc()) {
        $answerTest = $answerLetters[$index] . " " . $answer['noi_dung'];
        if ($answer['la_dap_an'] == 1) {
            $output .= "<u>". $answerTest. "</u>";
        } else {
            $output .= " $answerTest ";
        }
        $index++;  
    }
    $stt++;

    $date = date("Y-m-d");
			
    header("Content-Type: application/vnd.msword");
	header("Expires: 0");//no-cache
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");//no-cache
	header("content-disposition: attachment;filename=".$date.".doc");
			
	echo "<html>";
	echo $output;
	echo "</html>";
}
			
?>
