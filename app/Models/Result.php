<?php

namespace App\Models;

use App\Models\Option;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Result {
  use HasFactory;

  private $answer;
  private $expected;
  private $point;

  public function __construct(Option $answer, Option $expected) {
    $this->answer = $answer;
    $this->expected = $expected;

    if ($answer->getCode() == $expected->getCode()) {
      $this->point = 1;
    } else {
      $this->point = 0;
    }
  }

  public function getAnswer() {
    return $this->answer;
  }

  public function getExpected() {
    return $this->expected;
  }

  public function getPoint() {
    return $this->point;
  }
}
