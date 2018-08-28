@extends('layouts.app')

@section('customer')
  <div class="container">
      <div class="row justify-content-center">

          <div class="col-sm">
              <div class="card">
                  <div class="card-header">Información de contacto del cliente</div>

                  <div class="card-body">
                      @if (session('status'))
                          <div class="alert alert-success" role="alert">
                              {{ session('status') }}
                          </div>
                      @endif

                      <div id="show_contact">
                        <h3>Cliente: {{ $customer->full_name }}</h3>
                        <table class="table table-borderless">
                          <tr>
                            <td>Cédula: </td>
                            <td>{{ $customer->id_card }}</td>
                          </tr>
                          <tr>
                            <td>Teléfono móvil: </td>
                            <td>{{ $customer->mobile }}</td>
                          </tr>
                          <tr>
                            <td>Teléfono oficina/casa</td>
                            <td>{{ $customer->phone }}</td>
                          </tr>
                          <tr>
                            <td>Dirección: </td>
                            <td>{{ $customer->address }}</td>
                          </tr>
                        </table>
                      </div>
                      <a id="edit_customer_a" href="">Editar</a>

                      <div id="edit_contact">
                        {!! Form::open(['url' => 'customer/'.$customer->id, 'method' => 'PUT']) !!}

                        {!! Form::token() !!}

                        <div class="form-group">
                          {!! Form::label('id_card', 'Cédula') !!}
                          {!! Form::text('id_card', $customer->id_card, ['placeholder' => '0-000-000', 'class' => 'form-control', 'required']) !!}
                        </div>

                        <div class="form-group">
                          {!! Form::label('Name', 'Nombre') !!}
                          {!! Form::text('full_name', $customer->full_name, ['placeholder' => 'Nombre completo', 'class' => 'form-control', 'required']) !!}
                        </div>

                        <div class="form-group">
                          {!! Form::label('mobile', 'Teléfono móvil') !!}
                          {!! Form::text('mobile', $customer->mobile, ['placeholder' => '0000-0000', 'class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                          {!! Form::label('phone', 'Teléfono de casa/oficina', ['class' => '']) !!}
                          {!! Form::text('phone', $customer->phone, ['placeholder' => '0000-0000', 'class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                          {!! Form::label('email', 'Correo electrónico') !!}
                          {!! Form::email('email', $customer->email, ['placeholder' => 'Correo electrónico', 'class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                          {!! Form::label('address', 'Dirección', ['class' => '']) !!}
                          {!! Form::text('address', $customer->address, ['placeholder' => 'Señas, calle...', 'class' => 'form-control']) !!}
                        </div>

                        {!! Form::submit('Actualizar', ['class' => 'btn btn-info']) !!}

                        {!! Form::close() !!}
                      </div>

                  </div>
              </div>
          </div>

          <div class="col-sm">
              <div class="card">
                  <div class="card-header">Información relevante del cliente</div>

                  <div class="card-body">
                      @if (session('status'))
                          <div class="alert alert-success" role="alert">
                              {{ session('status') }}
                          </div>
                      @endif

                      Posteriormente casos del cliente en ésta sección
                  </div>
              </div>
          </div>

      </div>
  </div>
  <script src="{{ asset('js/customer.js') }}" defer></script>
@endsection
