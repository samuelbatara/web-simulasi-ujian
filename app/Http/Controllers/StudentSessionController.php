<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SessionController;

class StudentSessionController extends Controller
{
  private SessionController $sessionController;
  private $prefix = "student.";


  public function __construct(SessionController $sessionController) {
    $this->sessionController = $sessionController;   
  }

  public function saveSession($key, $value) {
    $this->sessionController->saveSession(
      $this->getKey($key),
      $value
    );
  }

  public function getSession($key) {
    return $this->sessionController->getSession(
      $this->getKey($key)
    );
  }

  public function updateSession($key, $value) {
    return $this->sessionController->updateSession(
      $this->getKey($key), 
      $value
    );
  }

  public function unsetSession($key) {
    return $this->sessionController->unsetSession(
      $this->getKey($key)
    );
  }

  public function unsetSessions() {
    return $this->sessionController->unsetSession(
      $this->prefix
    );
  }

  public function destroySession() {
    return $this->sessionController->destroySession();
  } 

  private function getKey($key) {
    return $this->prefix . $key;
  }
}
