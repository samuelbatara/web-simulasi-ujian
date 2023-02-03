<?php

namespace App\Http\Controllers;

use GuzzleHttp\Cookie\SessionCookieJar;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{

  private $nisn = 'nisn';
  private $password = 'password';
  private $feedbacks = [
    "nisn" => "NISN tidak terdaftar.",
    "password" => "Password tidak sesuai.",
  ];
  private StudentController $studentController;
  private StudentSessionController $studentSessionController;
  private QuestionController $questionController;
  private AnswerSessionController $answerSessionController;
  private SimulationSessionCOntroller $simulationSessionController;
  private SessionController $sessionController;

  public function __construct(StudentController $studentController,
                              StudentSessionController $studentSessionController,
                              QuestionController $questionController,
                              AnswerSessionController $answerSessionController,
                              SimulationSessionCOntroller $simulationSessionCOntroller,
                              SessionController $sessionController) {
    $this->studentController = $studentController;
    $this->studentSessionController = $studentSessionController;
    $this->questionController = $questionController;
    $this->answerSessionController = $answerSessionController;
    $this->simulationSessionController = $simulationSessionCOntroller;
    $this->sessionController = $sessionController;
  }

  public function index() {
    $student = $this->studentSessionController->getSession('');
    if ($student != null) {
      return redirect()->route('sebelum-ujian');
    }

    return view('index');
  }

  public function login(Request $request) {
    $nisn = $request[$this->nisn];
    $password = $request[$this->password];

    $student = $this->studentController->getStudentByNisn($nisn);

    if ($student == null) {
      return view('index', [
        "feedback" => $this->feedbacks["nisn"]
      ]);
    }

    if ($nisn != $password) {
      return view('index', [
        "feedback" => $this->feedbacks["password"]
      ]);
    }

    $this->studentSessionController->saveSession('', $student);

    return redirect()->route('sebelum-ujian');
  }

  public function logout() {
    // Clear student session
    $this->studentSessionController->unsetSessions();
    $this->studentSessionController->destroySession();

    // Clear answer session
    $this->answerSessionController->clearAnswers();
    $this->answerSessionController->destroyAnswer();

    // Clear simulation session
    $this->simulationSessionController->unsetSessions();
    $this->simulationSessionController->destroySession();

    return redirect()->route('index');
  }
}
