<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToolController extends Controller
{
  private $excel_template_filename = "template.xlsx";
  private $report_filename = "report.xlsx";

  private DownloadController $downloadController;
  private ReportController $reportController;

  public function __construct(DownloadController $downloadController,
                              ReportController $reportController) {
    $this->downloadController = $downloadController;
    $this->reportController = $reportController;
  }

  public function index() {
    return view('admin/index');
  }

  public function downloadTemplate() {
    return $this->downloadController->getDownload($this->getPath($this->excel_template_filename));
  }

  public function downloadReport() {
    return $this->downloadController->getDownload($this->getPath($this->report_filename));
  }

  public function clearReport() {
    $result = $this->reportController->initializeReport();
    $value = 'Berhasil menghapus data hasil simulasi.';
    if (!$result) {
      $value = "Tidak berhasil menghapus data hasil simulasi.";
    }

    return redirect()->route('fitur-lainnya')->with([
      'result' => $value
    ]);
  }

  private function getPath($filename) {
    return resource_path('data/') . $filename;
  }
}
