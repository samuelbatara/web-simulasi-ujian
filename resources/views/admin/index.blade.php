<?php
  $title = "Simulasi Ujian";
  $card_title = "Fitur Lainnya";
  $card_text = "Silahkan pilih salah satu fitur.";
  $simpan_data_text = [
    "text" => "Simpan Data",
    "detail" => "Untuk menyimpan data siswa/siswi dan data pertanyaan."
  ];
  $download_template_excel = [
    "text" => "Download template",
    "detail" => "Untuk download template excel untuk mengisi data siswa/siswi dan pertanyaan."
  ];
  $download_hasil = [
    "text" => "Download Hasil Simulasi",
    "detail" => "Untuk mendownload hasil simulasi."
  ];
  $clear_result = [
    "text" => "Hapus Data Simulasi",
    "detail" => "Untuk menghapus data hasil simulasi."
  ];
?>

@extends('layouts/template')

@section('content')
<div class="row-12">
  <div class="col-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title" style="font-weight: bold;">{{ $card_title }}</h5>
        <p class="card-text">{{ $card_text }}</p>
        <div class="row">
          <div class="col-4 mt-2">
            <div class="card" style="height: 120px;">
              <div class="card-body">
                <a href="/simpan-data" style="text-decoration: none; color: black;">
                  <h5 class="card-title">{{ $simpan_data_text['text'] }}</h5>
                  <p class="card-text" style="font-size: small;">{{ $simpan_data_text['detail'] }}</p>
                </a>
              </div>
            </div>
          </div>

          <div class="col-4 mt-2">
            <div class="card" style="height: 120px;">
              <div class="card-body">
                <a href="/download-template" style="text-decoration: none; color: black;">
                  <h5 class="card-title">{{ $download_template_excel['text'] }}</h5>
                  <p class="card-text" style="font-size: small;">{{ $download_template_excel['detail'] }}</p>
                </a>
              </div>
            </div>
          </div>

          <div class="col-4 mt-2">
            <div class="card" style="height: 120px;">
              <div class="card-body">
                <a href="/download-report" style="text-decoration: none; color: black;">
                  <h5 class="card-title">{{ $download_hasil['text'] }}</h5>
                  <p class="card-text" style="font-size: small;">{{ $download_hasil['detail'] }}</p>
                </a>
              </div>
            </div>
          </div>

          <div class="col-4 mt-2">
            <div class="card" style="height: 120px;">
              <div class="card-body">
                <a href="/clear-report" style="text-decoration: none; color: black;">
                  <h5 class="card-title">{{ $clear_result['text'] }}</h5>
                  <p class="card-text" style="font-size: small;">{{ $clear_result['detail'] }}</p>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    @if (Session::has('result'))
    <div class="row mt-3">
      <h5 style="font-weight: bold; font-size: medium;">{{ Session::get('result') }}</h5>
    </div>
    @endif
  </div>
</div>
@endsection
