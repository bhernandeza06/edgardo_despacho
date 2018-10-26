@extends('layouts.app')

@section('instances')
  <div class="container">
      <div class="justify-content-center">
        <a href="{{ url('instance/create') }}"><button type="button" class="btn btn-secondary btn-lg">Agregar nuevo caso</button></a>
        <br /><br />
        <div class="row">
          <div class="col">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-8">
                    Listado de casos finalizados
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
                      <th scope="col">Caso</th>
                      <th scope="col">Cliente</th>
                      <th scope="col">Fecha de cierre</th>
                      <th scope="col">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($instances as $key)
                      <tr>
                        <td scope="row">{{ $key->subject }}</td>
                        <td>{{ $key->wildcard }}</td>
                        <td style="font-weight: bold">{{ $key->updated_at }}</td>
                        <td>
                          <a href="instance/{{ $key->id }}">Ver caso</a> |
                          <a href="/customer/{{ $key->customer_id }}">Ver cliente</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                {{ $instances->links() }}
              </div>
            </div>
          </div>
        </div>

      </div>
  </div>
  <script src="{{ asset('js/home.js') }}" defer></script>
@endsection
