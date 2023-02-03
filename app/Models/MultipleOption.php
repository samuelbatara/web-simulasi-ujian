<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultipleOption
{
  use HasFactory;

  public $text;
  public $options;
  public $answer;

  public function __construct($text, $options, $answer) {
    $this->text = $text;
    $this->options = $options;
    $this->answer = $answer;
  }

  public function getText() {
    return $this->text;
  }

  public function setText($text) {
    $this->text = $text;
  }

  public function getOptions() {
    return $this->options;
  }

  public function setOptions($options) {
    $this->options = $options;
  }

  public function getAnswer() {
    return $this->answer;
  }

  public function setAnswer($answer) {
    $this->answer = $answer;
  }
}
