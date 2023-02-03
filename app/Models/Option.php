<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option
{
  use HasFactory;

  public $code;
  public $alias;
  public $text;

  public function __construct($code, $text) {
    $this->code = $code;
    $this->text = $text;
    $this->setAlias($code);
  }

  public function getCode() {
    return $this->code;
  }

  public function setCode($code) {
    $this->code = $code;
    $this->setAlias($code);
  }

  public function getText() {
    return $this->text;
  }

  public function setText($text) {
    $this->text = $text;
  }

  public function getAlias() {
    return $this->alias;
  }

  private function setAlias($code) {
    if ($code == "A") $this->alias = 0;
    else if ($code == "B") $this->alias = 1;
    else if ($code == "C") $this->alias = 2;
    else if ($code == "D") $this->alias = 3;
  }
}
