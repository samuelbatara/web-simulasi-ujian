<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SimulationSessionCOntroller extends Controller
{
  private $sessionController;
  private $prefix = 'simulation.';

  public function __construct(SessionController $sessionController) {
    $this->sessionController = $sessionController;
  }

  public function saveSession($key, $value) {
    return $this->sessionController->saveSession(
      $this->getKey($key),
      $value
    );
  }

  public function getSession($key) {
    return $this->sessionController->getSession(
      $this->getKey($key)
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
