@extends('layouts.app')

@section('customers')
  <div class="container">
      <div class="justify-content-center">
        <a href="{{ url('customer/create') }}"><button type="button" class="btn btn-secondary btn-lg">Agregar nuevo cliente</button></a>
        <br /><br />
        <div class="row">
          <div class="col">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-8">
                    Listado de clientes
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
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                  {{ session('status') }}
                </div>
                @endif
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Cédula</th>
                      <th scope="col">Nombre</th>
                      <th scope="col">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($customers as $key)
                      <tr>
                        <th scope="row">{{ $key->id_card }}</th>
                        <td>{{ $key->full_name }}</td>
                        <td>
                          <a href="customer/{{ $key->id }}">Ver</a>
                          | <a href="/instance/{{ $key->id }}/create_with_user">Crear caso</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                {{ $customers->links() }}
              </div>
            </div>
          </div>
        </div>

      </div>
  </div>
  <script src="{{ asset('js/home.js') }}" defer></script>
  <script src="{{ asset('js/customer.js') }}" defer></script>
@endsection
