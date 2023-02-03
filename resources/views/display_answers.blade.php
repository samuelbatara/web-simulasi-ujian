<?php 
  $title = "Simulasi Ujian";
  $card_title = "Pastikan jawaban Anda";

  $previous_page = $nquestions - 1;
?>

@extends('layouts/template')

@section('content')
<div class="row-12">
  <div class="col-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title" style="font-weight: bold;">{{ $card_title }}</h5>
        <div class="row">
          <div class="col-8">
            <p style="font-weight: bold; font-size: medium;">Pertanyaan</p>
          </div>

          <div class="col-4">
            <p style="font-weight: bold; font-size: medium;">Jawaban Anda</p>
          </div>
        </div>
        <div class="row-12">
          <ol>
            @for ($i = 0; $i < $nquestions; $i += 1)
              <li>
                <div class="row">
                  <div class="col-8">
                    <p>{{ $questions[$i]->getText() }}</p>
                  </div>
                  <div class="col-4">
                    <p>{{ $answers[$i]->getCode() }}. {{ $answers[$i]->getText() }}</p>
                  </div>
                </div>
              </li>
            @endfor
          </ol>
        </div>

        <div class="d-flex justify-content-end">
          <div class="row">
            <div class="col-5 mx-2">
              <form action="/mulai-ujian/{{ $previous_page }}" method="GET">
                <button type="submit" class="btn btn-secondary">Kembali</button>
              </form>
            </div>

            <div class="col-5">
              <form action="/kunci-jawaban" method="get">
                <button type="submit" class="btn btn-primary">Selesai</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
