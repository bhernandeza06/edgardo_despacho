@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
      @if (session('status'))
          <div class="alert alert-success" role="alert">
              {{ session('status') }}
          </div>
      @endif

      <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col-md-8">
                  Acciones recomendadas del día
                </div>
                <div class="col-md-4">
                  <div class="input-group mb-3">
                    <input id="rec_calendar" type="text" class="form-control" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12" id="data_div">
                  </div>
                </div>
              </div>
          </div>
      </div>

    </div>
</div>
<script src="{{ asset('js/home.js') }}" defer></script>
@endsection
