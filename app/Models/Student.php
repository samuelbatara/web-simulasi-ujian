<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student
{
  use HasFactory;

  public $nisn;
  public $name;
  public $class;

  public function __construct($nisn, $name, $class) {
    $this->nisn = $nisn;
    $this->name = $name;
    $this->class = $class;
  }

  public function getNisn() {
    return $this->nisn;
  }

  public function getName() {
    return $this->name;
  }

  public function getClass() {
    return $this->class;
  }

  protected $fillable = [
    'nisn',
    'name',
    'class',
  ];

  protected $hidden = [
    'id',
  ];
}
