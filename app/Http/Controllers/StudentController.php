<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class StudentController extends Controller
{
  private $reader;
  private FileController $fileController;
  private $sheetName = "Data";
  private $filename = "students.json";

  public function __construct(Xlsx $reader, FileController $fileController) {
    $this->reader = $reader;
    $this->fileController = $fileController;
  }

  public function index() {
    return view('add_students');
  }

  public function saveStudents(Request $request) {
    $spreadsheet = $this->getSpreadSheet($request);

    $students = [];
    for ($i = 1; $i < count($spreadsheet); $i += 1) {
      $nisn = $spreadsheet[$i][0];
      $name = $spreadsheet[$i][1];
      $class = $spreadsheet[$i][2];

      $student = new Student($nisn, $name, $class);
      $students[$i-1] = $student;
    }

    $students_encoded = json_encode($students, JSON_PRETTY_PRINT);
    // var_dump($students_encoded);
    try {
      $file = fopen(resource_path('data/' . $this->filename), 'w');
      fwrite($file, $students_encoded);
      fclose($file);
    } catch (Exception $e) {
      echo "Failed to save the file with message " . $e->getMessage();
    }

    return count($students);
  }

  public function getStudentByNisn($nisn) {
    $path = resource_path('data/' . $this->filename);
    $students = $this->fileController->getFile($path);

    $result = null;
    foreach ($students as $student) {
      if ($student->nisn == $nisn) {
        $result = new Student($student->nisn, $student->name, $student->class);
        break;
      }
    }
    
    return $result;
  }

  // public function upsertStudents(Request $request) {
  //   $spreadsheet = $this->getSpreadSheet($request);
    
  //   $results = [];
  //   for ($i = 1; $i < count($spreadsheet); $i += 1) {
  //     $student = null;
  //     try {
  //       $student = new Student();
  //       $student->nisn = $spreadsheet[$i][0];
  //       $student->name = $spreadsheet[$i][1];
  //       $student->class = $spreadsheet[$i][2];
  //     } catch (Exception $e) {
  //       echo "Failed to get variables with message: " . $e->getMessage();
  //     }
      
  //     try {
  //       $oldStudent = Student::where("nisn", $student->nisn)->first();
  //       if ($oldStudent == null) {
  //         $result = $student->save();
  //       } else {
  //         $student->id = $oldStudent->id;
  //         $result = $student->update();
  //       }
  //       $results[$i] = [$student->nisn, $result];
  //     } catch (Exception $e) {
  //       echo "Failed to upsert student with nisn=" 
  //           . $student->nisn 
  //           . ", with message: " 
  //           . $e->getMessage();
  //     }
  //   }

  //   return view('add_students', [
  //     "number_results" => count($results),  
  //   ]);
  // }

  private function getSpreadSheet(Request $request) {
    $file = $request->file('file');

    $spreadsheet = null;
    try {
      $spreadsheet = $this->reader
          ->load($file->getRealPath())
          ->getSheetByName($this->sheetName)
          ->toArray();
    } catch (Exception $e) {
      echo "Failed to load a file with message: " . $e->getMessage();
    }

    return $spreadsheet;
  }
}
