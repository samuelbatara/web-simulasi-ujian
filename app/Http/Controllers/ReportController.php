<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;

class ReportController extends Controller
{
  private FileController $fileController;
  private Xlsx $reader;
  private StudentSessionController $studentSessionController;
  private AnswerSessionController $answerSessionController;
  private $header = ["NISN", "Nama", "Kelas", "Nilai"];
  private $filename = 'report.xlsx';
  private $template_filename = "template-report.xlsx";
  
  public function __construct(Xlsx $reader, 
                              FileController $fileController,
                              StudentSessionController $studentSessionController,
                              AnswerSessionController $answerSessionController) {
    $this->reader = $reader;
    $this->fileController = $fileController;
  }

  public function createReport($student, $final_score) {
    $file = $this->reader->load($this->getPathOfReportFile($this->filename));
    $sheet = $file->getSheetByName('Hasil Ujian');
    $nrow = count($sheet->toArray()) + 1;

    // Set number
    $sheet->setCellValue([1, $nrow], $nrow - 1);

    // Set nisn
    $sheet->setCellValue([2, $nrow], $student->getNisn());

    // Set name
    $sheet->setCellValue([3, $nrow], $student->getName());

    // Set kelas
    $sheet->setCellValue([4, $nrow], $student->getClass());

    // Set score
    $sheet->setCellValue([5, $nrow], $final_score);

    $writer = new WriterXlsx($file);
    $writer->save($this->getPathOfReportFile($this->filename));
  }

  public function initializeReport() {
    try {
      $file = $this->reader->load($this->getPathOfReportFile($this->template_filename));
      $writer = new WriterXlsx($file);
      $writer->save($this->getPathOfReportFile($this->filename));
    } catch (Exception $e) {
      echo "Failed to initialize report with message " . $e->getMessage();
    }
    
    return true;
  }

  private function getPathOfReportFile($filename) {
    return resource_path('data/') . $filename;
  }
}
