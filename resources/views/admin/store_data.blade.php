<?php 
  $title = "Simpan Data";
  $card_title = "Simpan Data Siswa dan Pertanyaan";
  $card_text = "Silahkah pilih file";
?>

@extends('layouts/template')

@section('content')
<div class="row-12">
  <div class="col-6">
    <div class="card" style="width: 30rem;">
      <!-- <img src="..." class="card-img-top" alt="..."> -->
      <div class="card-body">
        <h5 class="card-title" style="font-weight: bold;">{{ $card_title }}</h5>
        <p class="card-text">{{ $card_text }}</p>
        <form action="/simpan-data" method="post" enctype="multipart/form-data">
          @csrf
          <div class="input-group mb-3">
            <input class="form-control" type="file" name="file" id="file" required>
          </div>

          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>

    <div class="row mt-2">
      <p id="students" style="font-weight: bold;">
        @if (isset($number_students)) 
          {{ "Berhasil menyimpan " . $number_students . " murid." }}
        @endif
      </p>
      <p id="questions" style="font-weight: bold;">
        @if (isset($number_questions))
          {{ "Berhasil menyimpan " . $number_questions . " pertanyaan."}}
        @endif
      </p>
    </div>
  </div>
</div>

@endsection