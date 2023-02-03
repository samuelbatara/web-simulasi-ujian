<?php 
  $title = "Simulasi Ujian";
  $card_title_question = "Pertanyaan";
  $card_title_navigator = "Navigasi";

  $previousPage = $page - 1;
  $nextPage = $page + 1;
  $question_text = ($page + 1) . ". " . $question->getText();

?>

@extends('layouts/template')

@section('content')
<div class="row">
  <div class="col-5">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title" style="font-weight: bold;">{{ $card_title_question }}</h5>
        <p class="card-text">{{ $question_text }}</p>
        
        @foreach ($question->getOptions() as $option)

        <div class="form-check mb-2">
          <input type="radio" class="form-check-input" name="answer" id="answer.{{ $option->getCode() }}" 
            onclick="saveAnswer({{ $numberOfQuestions }}, {{ $page }}, {{ $option->getAlias() }})"
            @if ($answers[$page] != null && $answers[$page]->getCode() == $option->getCode())
              checked
            @endif>
          <label class="form-check-label" for="text">{{ $option->getCode() }}. {{ $option->getText() }}</label>
        </div>
        @endforeach
        
        <div class="d-flex justify-content-end">
          <div class="row">
            
            <div class="col-5 mx-2">
              <form action="/mulai-ujian/{{ $previousPage }}" method="get">
                <button type="submit" class="btn btn-secondary"
                @if ($previousPage < 0)
                disabled
                @endif>Sebelumnya</button>
              </form>
            </div>

            <div class="col-5">
              <form action="/mulai-ujian/{{ $nextPage }}" method="get">
                <button type="submit" class="btn btn-secondary"
                @if ($nextPage >= $numberOfQuestions)
                  disabled
                @endif>Selanjutnya</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title" style="font-size: medium; font-weight: bold;">{{ $card_title_navigator }}</h5>

        <div class="row">
          @for ($i = 0; $i < $numberOfQuestions; $i += 1)
          <div class="col-2 mb-1 mx-1">
            <form action="/mulai-ujian/{{ $i }}">
              <button id="question.{{ $i }}" type="submit" class="btn 
              @if ($answers[$i] != null)
                btn-info
              @else
                btn-secondary
              @endif
              " style="width: 3rem;">{{ ($i + 1) }}</button>
            </form>
          </div>
          @endfor
        </div>

        <div class="row mt-2">
          <form action="/pastikan-jawaban" method="get" id="form.submit">
            <button type="submit" class="btn btn-primary"
            @if ($numberOfAnswers < $numberOfQuestions)
              disabled
            @endif>Selesai</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
