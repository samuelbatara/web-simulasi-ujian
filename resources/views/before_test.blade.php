<?php 
$title = "Simulasi Ujian";
$card_title = "Data Murid";
?>

@extends('layouts/template')

@section('content')

<div class="col">
  <div class="card" style="width: 25%;">
    <div class="card-body">
      <h5 class="card-title" style="font-weight: bold;">{{ $card_title }}</h5>
      <p class="card-text">Pastikan data Anda benar!</p>
      <div class="row">
        <div class="col-3">
          <label for="NISN" style="font-weight: bold;">NISN</label>
        </div>
        <div class="col-8">
          <p>{{ $student->getNisn() }}</p>
        </div>
      </div>

      <div class="row">
        <div class="col-3">
          <label for="NAMA" style="font-weight: bold;">NAMA</label>
        </div>
        <div class="col-8">
          <p>{{ $student->getName() }}</p>
        </div>
      </div>

      <div class="row">
        <div class="col-3">
          <label for="KELAS" style="font-weight: bold;">KELAS</label>
        </div>
        <div class="col-8">
          <p>{{ $student->getClass() }}</p>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-end mb-3 mx-3">
      <form action="/mulai-ujian/0" method="get" class="mx-3">
        <button type="submit" class="btn btn-primary">Mulai Ujian</button>
      </form>

      <form action="/keluar" method="post">
        @csrf 
        <button type="submit" class="btn btn-warning">Keluar</button>
      </form>
    </div>
  </div>
</div>

@endsection