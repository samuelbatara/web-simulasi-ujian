<?php 
  $title = "Simulasi Ujian"; 
  $card_title = "Simulasi Ujian";
  $card_text = "Silahkan pilih fitur yang tersedia";
  $faeture_add_student = "Tambah Siswa";
  $feature_test = "Simulasi Ujian";
?>

@extends('layouts/template')

@section('content')

<div class="col">
  <div class="card" style="width: 25%;">
    <div class="card-body">
      <h5 class="card-title" style="font-weight: bold;">{{ $card_title }}</h5>
      <form action="/masuk" method="post">
        @csrf
        <div class="form-group mb-3">
          <label for="nisn">NISN</label>
          <input type="text" class="form-control" id="nisn" name="nisn" placeholder="Masukan NISN" required>
        </div>

        <div class="form-group mb-3">
          <label for="nisn">Kata Sandi</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Masukan Kata Sandi" required>
        </div>

        <div class="d-flex justify-content-end">
          <button type="submit" class="btn btn-primary">Masuk</button>
        </div>
      </form>
    </div>
  </div>

  <div class="mt-3">
    <p style="font-weight: bold;">
      @if (isset($feedback))
      {{ $feedback }}
      @endif
    </p>
  </div>
</div>

@endsection
