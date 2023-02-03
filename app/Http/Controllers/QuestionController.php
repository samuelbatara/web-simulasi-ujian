<?php

namespace App\Http\Controllers;

use App\Models\MultipleOption;
use App\Models\Option;
use Exception;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class QuestionController extends Controller
{
  private $reader;
  private FileController $fileController;
  private $sheetName = "Pertanyaan";
  private $filename = "questions.json";

  public function __construct(Xlsx $xlsx,
                              FileController $fileController) {
    $this->reader = $xlsx;
    $this->fileController = $fileController;
  }

  public function saveQuestions(Request $request) {
    $spreadsheet = $this->getSpreadSheet($request);

    $questions = [];
    try {
      for ($i = 1; $i < count($spreadsheet); $i++) {
        $text = $spreadsheet[$i][0];
        $options = [];
        $options[0] = new Option("A", $spreadsheet[$i][1]);
        $options[1] = new Option("B", $spreadsheet[$i][2]);
        $options[2] = new Option("C", $spreadsheet[$i][3]);
        $options[3] = new Option("D", $spreadsheet[$i][4]);
        $answer = null;

        foreach ($options as $option) {
          if ($option->getCode() == $spreadsheet[$i][5]) {
            $answer = new Option($option->getCode(), $option->getText());
            break;
          }
        }

        $question = new MultipleOption($text, $options, $answer);
        $questions[$i-1] = $question;
      }
    } catch (Exception $e) {
      echo "Failed to get content of file with message " . $e->getMessage();
    }
    
    $questions_encoded = json_encode($questions, JSON_PRETTY_PRINT);
    try {
      $file = fopen(resource_path('data/' . $this->filename), 'w');
      fwrite($file, $questions_encoded);
      fclose($file);
    } catch (Exception $e) {
      echo "Failed to save the file with message " . $e->getMessage();
    }

    return count($questions);
  }

  public function getQuestion($number) {
    $path = resource_path('data/') . $this->filename;
    $questions = $this->fileController->getFile($path);
    
    return $this->convertToMultipleOption($questions[$number]);
  }

  public function getNumberOfQuestions() {
    $path = resource_path('data/') . $this->filename;
    $questions = $this->fileController->getFile($path);
    
    return count($questions);
  }

  private function convertToMultipleOption($question) {
    $text = $question->text;
    $options = [];
    for ($i = 0; $i < count($question->options); $i += 1) {
      $options[$i] = new Option(
        $question->options[$i]->code,
        $question->options[$i]->text
      );

    }
    $answer = new Option($question->answer->code, $question->answer->text);

    return new MultipleOption($text, $options, $answer);
  }

  private function getSpreadSheet(Request $request) {
    $file = $request->file('file');

    $spreadsheet = null;
    try {
      $spreadsheet = $this->reader
          ->load($file->getRealPath())
          ->getSheetByName($this->sheetName)
          ->toArray();
    } catch (Exception $e) {
      echo "Failed to load a file with message: " . $e->getMessage();
    }

    return $spreadsheet;
  }
}
