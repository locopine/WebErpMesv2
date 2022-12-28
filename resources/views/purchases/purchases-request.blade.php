@extends('adminlte::page')

@section('title', 'Purchases Request')

@section('content_header')
  <div class="row mb-2">
    <div class="col-sm-6">
        <h1>Purchases Request</h1>
    </div>
  </div>
@stop

@section('right-sidebar')

@section('content')

<div class="card">
  @livewire('purchases-request')
<!-- /.card -->
</div>

@stop

@section('css')
@stop

@section('js')
@stop