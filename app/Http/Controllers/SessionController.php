<?php

namespace App\Http\Controllers;

use Exception;

class SessionController extends Controller
{
  public function __construct() {
    try {
      session_start();
    } catch (Exception $e) {
      // Failed to start session because is already started.
    }
  }

  public function saveSession($key, $value) {
    try {
      $_SESSION[$key] = $value;
    } catch (Exception $e) {
      echo "Failed to save the session with key=$key, with message " . $e->getMessage();
    }
    
    return true;
  }

  public function getSession($key) {
    $value = null;
    if (isset($_SESSION[$key])) {
      $value = $_SESSION[$key];
    }

    return $value;
  }

  public function updateSession($key, $value) {
    try {
      $_SESSION[$key] = $value;
    } catch (Exception $e) {
      echo "Failed to update session with key=$key, with messagge " . $e->getMessage();
      return false;
    }

    return true;
  }

  public function unsetSession($key) {
    try {
      unset($_SESSION[$key]);
    } catch (Exception $e) {
      echo "Failed to unset session with key=$key, with message " . $e->getMessage();
      return false;
    }

    return true;
  }

  public function destroySession() {
    try {
      session_destroy();
    } catch (Exception $e) {
      echo "Failed to destroy session with message " . $e->getMessage();
      return false;
    }

    return true;
  }
}
