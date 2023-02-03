<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataController extends Controller
{
  public StudentController $studentController;
  public QuestionController $questionController;

  public function __construct(StudentController $studentController, 
                              QuestionController $questionController) {
    $this->studentController = $studentController;
    $this->questionController = $questionController;
  }

  public function index() {
    return view('admin/store_data');
  }

  public function saveStudentsAndQuestions(Request $request) {
    $results1 = $this->studentController->saveStudents($request);
    $results2 = $this->questionController->saveQuestions($request);
    
    return view('admin/store_data', [
      "number_students" => $results1,
      "number_questions" => $results2
    ]);
  }
}
