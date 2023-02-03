<?php 
  $title = "Simulasi Ujian";
  $card_title = "Hasil Ujian"
?> 

@extends('layouts/template')

@section('content')
<div class="row-12">
  <div class="col-10">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title" style="font-weight: bold;">{{ $card_title }}</h5>
        <div class="row">
          <div class="col-6">
            <p style="font-weight: bold; font-size: medium;">Pertanyaan</p>
          </div>

          <div class="col-2">
            <p style="font-weight: bold; font-size: medium;">Jawaban Anda</p>
          </div>

          <div class="col-2">
            <p style="font-weight: bold; font-size: medium;">Jawaban Sebenarnya</p>
          </div>

          <div class="col-2">
            <p style="font-weight: bold; font-size: medium;">Hasil</p>
          </div>
        </div>

        <div class="row-12">
          <ol>
            @for ($i = 0; $i < $nquestions; $i += 1)
              <li>
                <div class="row">
                  <div class="col-6">
                    <p>{{ $questions[$i]->getText() }}</p>
                  </div>
                  <div class="col-2">
                    <p>{{ $results[$i]->getAnswer()->getCode() }}. {{ $results[$i]->getAnswer()->getText() }}</p>
                  </div>
                  <div class="col-2">
                    <p>{{ $results[$i]->getExpected()->getCode() }}. {{ $results[$i]->getExpected()->getText() }}</p>
                  </div>
                  <div class="col-2">
                    @if ($results[$i]->getPoint() == 1) 
                      <button disabled class="btn btn-success">Benar</button>
                    @else
                      <button disabled class="btn btn-danger">Salah</button>
                    @endif
                  </div>
                </div>
              </li>
            @endfor
          </ol>
        </div>

        <div class="row">
          <h5>Nilai: {{ $final_score }}</h5>
        </div>

        <div class="d-flex justify-content-end">
          <div class="row">
            <form action="/keluar" method="post">
              @csrf 
              <button type="submit" class="btn btn-primary">Keluar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection 
