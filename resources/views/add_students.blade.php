<?php 
  $title = "Tambah Data";
  $card_title = "Tambah Data Siswa";
  $card_text = "Silahkah pilih file";
?>

@extends('layouts/template')

@section('content')

<div class="card" style="width: 30rem;">
  <!-- <img src="..." class="card-img-top" alt="..."> -->
  <div class="card-body">
    <h5 class="card-title">{{ $card_title }}</h5>
    <p class="card-text">{{ $card_text }}</p>
    <form action="/add-students" method="post" enctype="multipart/form-data">
      @csrf
      <div class="input-group mb-3">
        <input class="form-control" type="file" name="file" id="file" required>
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>

<div class="row mt-2">
  <p id="results">
    @if (isset($number_results)) 
      {{ "Berhasil menyimpan " . $number_results . " data." }}
    @endif
  </p>
</div>

@endsection