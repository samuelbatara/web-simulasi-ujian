<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Result;
use Constant;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\Console\Question\Question;

class SimulationController extends Controller
{
  private FileController $fileController;
  private StudentSessionController $studentSessionController;
  private QuestionController $questionController;
  private AnswerSessionController $answerSessionController;
  private SimulationSessionCOntroller $simulationSessionController;
  private ReportController $reportController;

  private $simulationClockKey = "clock";

  public function __construct(FileController $fileController,
                              StudentSessionController $studentSessionController,
                              QuestionController $questionController,
                              AnswerSessionController $answerSessionController,
                              SimulationSessionCOntroller $simulationSessionCOntroller,
                              ReportController $reportController) {

    $this->fileController = $fileController;
    $this->studentSessionController = $studentSessionController;
    $this->questionController = $questionController;
    $this->answerSessionController = $answerSessionController;
    $this->simulationSessionController = $simulationSessionCOntroller;
    $this->reportController = $reportController;
  }

  public function index() {
    $student = $this->studentSessionController->getSession('');

    if ($student == null) {
      return redirect()->route('index');
    }

    return view('before_test', [
      "student" => $student
    ]);
  }

  public function getPage($page = 0) {
    $student = $this->studentSessionController->getSession('');

    if ($student == null) {
      return redirect()->route('index');
    }

    $isFinal = $this->simulationSessionController->getSession(
      $this->simulationClockKey
    );

    if ($isFinal) {
      return $this->calculateScore();
    }

    $question = $this->questionController->getQuestion($page);
    $nquestions = $this->questionController->getNumberOfQuestions();
    $answers = [];
    $numberofAnswers = 0;
    for ($i = 0; $i <= $nquestions; $i++) {
      $answers[$i] = $this->getAnswerIfExists($i);
      if ($answers[$i] != null) {
        $numberofAnswers += 1;
      }
    }

    return view('test', [
      'student' => $student,
      'question' => $question,
      'numberOfQuestions' => $nquestions,
      'page' => $page,
      'answers' => $answers,
      'numberOfAnswers' => $numberofAnswers
    ]);
  }

  private function getAnswerIfExists($questionNumber) {
    $value = $this->answerSessionController->getAnswer($questionNumber);

    return $value;
  }

  public function saveAnswer($questionNumber, $answer) {
    $value = null;

    if ($answer == 0) $value = 'A';
    else if ($answer == 1) $value = 'B';
    else if ($answer == 2) $value = 'C';
    else if ($answer == 3) $value = 'D';

    $result = $this->answerSessionController->saveAnswer(
      $questionNumber,
      $value
    );

    if (!$result) {
      return -1;
    }
    
    return $this->getNumberOfAnswers();
  }

  private function getNumberOfAnswers() {
    $numberOfAnswers = 0;
    $numberOfQuestions = $this->questionController->getNumberOfQuestions();
    
    for ($i = 0; $i < $numberOfQuestions; $i += 1) {
      if ($this->getAnswerIfExists($i) != null) $numberOfAnswers += 1;
    }

    return $numberOfAnswers;
  }
  
  public function displayAnswers() {
    $isFinal = $this->simulationSessionController->getSession(
      $this->simulationClockKey
    );

    if ($isFinal) {
      return $this->calculateScore();
    }

    $student = $this->studentSessionController->getSession('');
    $nquestions = $this->questionController->getNumberOfQuestions();
    $result = $this->getQuestoinsAndAnswers();

    return view('display_answers', [
      'student' => $student,
      'nquestions' => $nquestions,
      'questions' => $result['questions'],
      'answers' => $result['answers']
    ]);
  }

  public function calculateScore() {
    $this->simulationSessionController->saveSession(
      $this->simulationClockKey, true
    );

    $student = $this->studentSessionController->getSession('');
    $nquestions = $this->questionController->getNumberOfQuestions();
    $result = $this->getQuestoinsAndAnswers();
    $answers = $result["answers"];
    $questions = $result["questions"];

    $results = [];
    for ($i = 0; $i < $nquestions; $i++) {
      $results[$i] = new Result($answers[$i], $questions[$i]->getAnswer());
    }
    
    $final_score = 0;
    for ($i = 0; $i < $nquestions; $i += 1) {
      $final_score += $results[$i]->getPoint();
    }
    $final_score = ($final_score / $nquestions) * 100;

    // Create report
    $this->reportController->createReport($student, $final_score);

    return view('display_score', [
      'student' => $student,
      'nquestions' => $nquestions,
      'questions' => $questions,
      'results' => $results,
      'final_score' => $final_score
    ]);
  }

  private function getQuestoinsAndAnswers() {
    $nquestions = $this->questionController->getNumberOfQuestions();
    $questions = [];
    $answers = [];
    for ($i = 0; $i < $nquestions; $i += 1) {
      $answer = $this->answerSessionController->getAnswer($i);
      $answer = new Option($answer->getCode(), $answer->getText());

      $questions[$i] = $this->questionController->getQuestion($i);

      foreach ($questions[$i]->getOptions() as $option) {
        if ($option->getCode() == $answer->getCode()) {
          $answer->setText($option->getText());
        }
      }
      $answers[$i] = $answer;
    }

    return [
      "questions" => $questions,
      "answers" => $answers
    ];
  }
}
