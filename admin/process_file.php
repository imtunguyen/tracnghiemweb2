<?php
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
    $currentCorrectAnswers = []; 
    $isQuestion = false;
    $isAnswer = false;

    foreach ($phpWord->getSections() as $section) {
        foreach ($section->getElements() as $element) {
            if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                foreach ($element->getElements() as $text) {
                    if ($text instanceof \PhpOffice\PhpWord\Element\Text) {
                        if (strpos($text->getText(), "Câu ") === 0) {
                            // Save the previous question, answers, and difficulty level
                            if (!empty($currentQuestion) && !empty($currentAnswers)) {
                                $questions[] = $currentQuestion;
                                $answers[] = $currentAnswers;
                                $currentCorrectAnswers[] = $currentCorrectAnswer; // Add the correct answer to the array
                            }
                            $isQuestion = true;
                            // Reset the new question, answers, and difficulty level
                            $currentQuestion = $text->getText();
                         
                            $currentAnswers = [];
                            $currentCorrectAnswer = ''; // Reset the correct answer
                            $isAnswer = false;
                        } elseif (preg_match('/^[A-D]\./', $text->getText())) {
                            $isAnswer = true;
                            $currentAnswers[] = $text->getText();
                        } elseif ($isAnswer) {
                            // If we are currently processing an answer, append the text to the last answer
                            $currentAnswers[count($currentAnswers) - 1] .= ' ' . $text->getText();
                        }

                        $underlineStyle = $text->getFontStyle()->getUnderline();
                        if ($underlineStyle != Font::UNDERLINE_NONE) {
                            // If the text is underlined, add it to the correct answer
                            $currentCorrectAnswer = end($currentAnswers);
                        }
                    }
                }
            }
        }
    }

    // Add the last answer and difficulty level to the array if needed
    if (!empty($currentQuestion) && !empty($currentAnswers)) {
        $questions[] = $currentQuestion;
        $answers[] = $currentAnswers;
        $currentCorrectAnswers[] = $currentCorrectAnswer; // Add the correct answer to the array
    }
    foreach ($questions as $index => $question) {
        echo "<div class='btn btn-primary custom-div'>$question</div><br>";
        foreach ($answers[$index] as $answer) {
            if ($answer === $currentCorrectAnswers[$index]) {
                echo "<div class='btn btn-success'>$answer</div><br>"; // Display the correct answer in a div tag
            } else {
                echo "$answer<br>";
            }
        }
        echo "<br>";
    }
}
?>
