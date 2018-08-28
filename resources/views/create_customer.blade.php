@extends('layouts.app')

@section('create_customer')
  <div class="container">
      <div class="row justify-content-center">

          <div class="col-sm-8">
              <div class="card">
                  <div class="card-header">Formulario de contacto del cliente</div>

                  <div class="card-body">
                      @if (session('status'))
                          <div class="alert alert-success" role="alert">
                              {{ session('status') }}
                          </div>
                      @endif

                      {!! Form::open(['url' => 'customer']) !!}

                      {!! Form::token() !!}

                      <div class="form-group">
                        {!! Form::label('id_card', 'Cédula') !!}
                        {!! Form::text('id_card', '', ['placeholder' => '0-000-000', 'class' => 'form-control', 'required']) !!}
                      </div>

                      <div class="form-group">
                        {!! Form::label('Name', 'Nombre Completo') !!}
                        {!! Form::text('full_name', '', ['placeholder' => 'Nombre completo', 'class' => 'form-control', 'required']) !!}
                      </div>

                      <div class="form-group">
                        {!! Form::label('mobile', 'Teléfono móvil') !!}
                        {!! Form::text('mobile', '', ['placeholder' => '0000-0000', 'class' => 'form-control']) !!}
                      </div>

                      <div class="form-group">
                        {!! Form::label('phone', 'Teléfono de casa/oficina', ['class' => '']) !!}
                        {!! Form::text('phone', '', ['placeholder' => '0000-0000', 'class' => 'form-control']) !!}
                      </div>

                      <div class="form-group">
                        {!! Form::label('email', 'Correo electrónico') !!}
                        {!! Form::email('email', '', ['placeholder' => 'ejemplo@ejemplo.com', 'class' => 'form-control']) !!}
                      </div>

                      <div class="form-group">
                        {!! Form::label('address', 'Dirección', ['class' => '']) !!}
                        {!! Form::text('address', '', ['placeholder' => 'Señas, calle...', 'class' => 'form-control']) !!}
                      </div>

                      {!! Form::submit('Registrar', ['class' => 'btn btn-info']) !!}

                      {!! Form::close() !!}

                  </div>
              </div>
          </div>

      </div>
  </div>
@endsection
