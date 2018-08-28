@extends('layouts.app')
<link href="{{ asset('css/instance.css') }}" rel="stylesheet">
@section('create_instance')
  <div class="container">
      <div class="row justify-content-center">

          <div class="col-sm-8">
              <div class="card">
                  <div class="card-header">Formulario de nuevo caso</div>

                  <div class="card-body">
                      @if (session('status'))
                          <div class="alert alert-success" role="alert">
                              {{ session('status') }}
                          </div>
                      @endif

                      {!! Form::open(['url' => 'instance', 'method' => 'post']) !!}

                      {!! Form::token() !!}

                      <div class="form-group">
                        {!! Form::label('Customer', 'Cliente') !!}
                        <div class="row">
                          @if (empty($customer))
                            <div class="col-10">
                              {!! Form::text('customer', '',
                              ['placeholder' => 'Ingrese nombre, apellidos o cédula de cliente', 'id' => 'customer_input',
                              'class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}
                            </div>
                          @else
                            <div class="col-10">
                              {!! Form::text('customer', $customer->full_name,
                              ['placeholder' => 'Ingrese nombre, apellidos o cédula de cliente', 'id' => 'customer_input',
                              'class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}
                            </div>
                          @endif
                          <div class="col">
                            <button type="button" name="button" id="btn_refresh_customer"><i id="refresh_icon" class="fas fa-sync-alt"></i></button>
                          </div>
                        </div>
                      </div>
                      <div id="tblCustomers"></div>
                      <div class="form-group">
                        {!! Form::label('Subject', 'Nombre de asunto') !!}
                        {!! Form::text('subject', '', ['placeholder' => 'Nombre de asunto', 'class' => 'form-control', 'required']) !!}
                      </div>

                      <div class="form-group">
                        {!! Form::label('Recommendations', 'Recomendaciones') !!}
                        {!! Form::textarea('recommendations', '', ['placeholder' => 'Indique recomendaciones del caso', 'class' => 'form-control', 'rows' => '3']) !!}
                      </div>

                      <div class="form-group">
                        {!! Form::label('Honorarios', 'Honorarios') !!}
                        {!! Form::text('fee', '', ['placeholder' => '₡0.00', 'class' => 'form-control']) !!}
                      </div>

                      @if (empty($customer))
                        <div class="form-group">
                          {!! Form::text('current_customer', '', ['id' => 'current_customer', 'hidden']) !!}
                        </div>
                      @else
                        {!! Form::text('current_customer', $customer->id, ['id' => 'current_customer', 'hidden']) !!}
                      @endif

                      {!! Form::submit('Registrar nuevo caso', ['class' => 'btn btn-info', 'id' => 'btn_create_instance']) !!}

                      {!! Form::close() !!}

                  </div>
              </div>
          </div>

      </div>
  </div>
  <script src="{{ asset('js/instance.js') }}" defer></script>
@endsection
