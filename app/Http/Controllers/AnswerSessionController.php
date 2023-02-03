<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Exception;
use Illuminate\Http\Request;

class AnswerSessionController extends Controller
{
  private SessionController $sessionController;
  private $prefix = "answer.";

  public function __construct(SessionController $sessionController) {
    $this->sessionController = $sessionController;
  }

  public function saveAnswer($questionNumber, $answer) {
    if ($answer == null) {
      return false;
    }

    $option = new Option($answer, "");

    return $this->sessionController->saveSession(
      $this->getKey($questionNumber),
      $option
    );
  }

  public function getAnswer($questionNumber) {
    return $this->sessionController->getSession(
      $this->getKey($questionNumber)
    );
  }

  public function updateAnswer($questionNumber, $answer) {
    $option = $this->getAnswer($questionNumber);
    $option->setCode($answer);
    return $this->sessionController->updateAnswer(
      $this->getKey($questionNumber),
      $option
    );
  } 

  public function clearAnswer($questionNumber) {
    return $this->sessionController->unsetSession(
      $this->getKey($questionNumber)
    );
  }

  public function clearAnswers() {
    return $this->sessionController->unsetSession(
      $this->prefix
    );
  }

  public function destroyAnswer() {
    return $this->sessionController->destroySession();
  }

  private function getKey($key) {
    return $this->prefix . $key;
  }
}
