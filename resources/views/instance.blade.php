@extends('layouts.app')
<link href="{{ asset('css/instance.css') }}" rel="stylesheet">
<!--Load the AJAX API-->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@section('instance')
  <div class="container">
      <div class="row justify-content-center">

          <div class="col-sm">
              <div class="card">
                <div class="card-header">Información del caso</div>

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
                          <td>Nombre del caso: </td>
                          <td>{{ $instance->subject }}</td>
                        </tr>
                        <tr>
                          <td>Recomendaciones: </td>
                          <td>{{ $instance->recommendations }}</td>
                        </tr>
                        <tr>
                          <td>Honorarios: </td>
                          <td id="fee_td">{{ $instance->fee }}</td>
                        </tr>
                        <tr>
                          <td>Estado: </td>
                          <td>{{ $instance->state }}</td>
                        </tr>
                      </table>
                    </div>
                    <a id="edit_instance_a" href="">Editar</a>

                    <div id="edit_info">
                      {!! Form::open(['url' => 'instance/'.$instance->id, 'method' => 'PUT']) !!}

                      {!! Form::token() !!}

                      <div class="form-group">
                        {!! Form::label('Customer', 'Cliente') !!}
                        <div class="row">
                          <div class="col-10">
                            {!! Form::text('customer', $customer->full_name,
                            ['placeholder' => 'Ingrese nombre, apellidos o cédula de cliente', 'id' => 'customer_input',
                            'class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}
                          </div>
                          <div class="col">
                            <button type="button" name="button" id="btn_refresh_customer"><i id="refresh_icon" class="fas fa-sync-alt"></i></button>
                          </div>
                        </div>
                      </div>
                      <div id="tblCustomers"></div>
                      <div class="form-group">
                        {!! Form::label('Subject', 'Nombre de asunto') !!}
                        {!! Form::text('subject', $instance->subject, ['placeholder' => 'Nombre de asunto', 'class' => 'form-control', 'required']) !!}
                      </div>

                      <div class="form-group">
                        {!! Form::label('Recommendations', 'Recomendaciones') !!}
                        {!! Form::textarea('recommendations', $instance->recommendations, ['placeholder' => 'Indique recomendaciones del caso', 'class' => 'form-control', 'rows' => '3']) !!}
                      </div>

                      <div class="form-group">
                        {!! Form::label('Honorarios', 'Honorarios') !!}
                        {!! Form::text('fee', $instance->fee, ['placeholder' => '₡0.00', 'class' => 'form-control']) !!}
                      </div>

                      <div class="form-group">
                        {!! Form::label('Estado', 'Estado del caso') !!}
                        {!! Form::select('state', array('Pendiente' => 'Pendiente', 'Finalizado' => 'Finalizado'), null, array('class' => 'form-control')) !!}
                      </div>

                      <div class="form-group">
                        {!! Form::text('id_customer', $customer->id, ['id' => 'id_customer', 'hidden']) !!}
                      </div>

                      {!! Form::submit('Editar caso', ['class' => 'btn btn-info', 'id' => 'btn_create_instance']) !!}

                      {!! Form::close() !!}
                    </div>

                </div>
              </div>
          </div>

          <div class="col-sm">
            <div class="card">
                <div class="card-header">Información relevante del caso</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                      <div class="accordion" id="accordionExample">

                        <div class="card">
                          <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                              <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <strong>Acciones recomendadas</strong>
                              </button>
                            </h5>
                          </div>
                          <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-10"></div>
                                <div class="col">
                                  <button type="button" id="btn_add_concrete" class="btn btn-primary" data-toggle="modal" data-target=".bd-concrete-modal-lg">
                                    <i class="fa fa-plus"></i>
                                  </button>

                                </div>
                              </div>
                              <br>
                              <div class="row">
                                <div class="col-12" id="actions_div">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="card">
                          <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <strong>Recordatorios</strong>
                              </button>
                            </h5>
                          </div>
                          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-10"></div>
                                <div class="col">
                                  <button type="button" id="btn_add_reminder" class="btn btn-primary" data-toggle="modal" data-target=".bd-reminder-modal-lg">
                                    <i class="fa fa-plus"></i>
                                  </button>

                                </div>
                              </div>
                              <br>
                              <div class="row">
                                <div class="col-12" id="reminders_div">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="card">
                          <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <strong>Lista de costos</strong>
                              </button>
                            </h5>
                          </div>
                          <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-10"></div>
                                <div class="col">
                                  <button type="button" id="btn_add_cost" class="btn btn-primary" data-toggle="modal" data-target=".bd-cost-modal-lg">
                                    <i class="fa fa-plus"></i>
                                  </button>

                                </div>
                              </div>
                              <br>
                              <div class="row">
                                <div class="col-12" id="costs_div">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="card">
                          <div class="card-header" id="headingFour">
                            <h5 class="mb-0">
                              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                <strong>Documentos</strong>
                              </button>
                            </h5>
                          </div>
                          <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-10"></div>
                                <div class="col">
                                  <button type="button" id="btn_add_doc" class="btn btn-primary" data-toggle="modal" data-target=".bd-doc-modal-lg">
                                    <i class="fa fa-plus"></i>
                                  </button>

                                </div>
                              </div>
                              <br>
                              <div class="row">
                                <div class="col-12" id="docs_div">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
            </div>
          </div>

      </div>
      <div class="row">
        <div class="col-sm">
          <div id="piechart_3d"></div>
        </div>
        <div class="col-sm">
          <div id="piechart_3d_effectiveness"></div>
        </div>
      </div>
  </div>

  <!-- Concrete Action Modal -->
<div class="modal fade bd-concrete-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="modal_concrete_content">
      <div class="modal-header">
        <h5 class="modal-title">Nueva acción concreta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          {!! Form::label('Action', 'Acción') !!}
          {!! Form::text('action', '', ['placeholder' => 'Acción concreta a ejecutar', 'class' => 'form-control', 'id' => 'action','required']) !!}
        </div>
        <div class="form-group">
          {!! Form::label('Reminder', 'Recordatorio') !!}
          {!! Form::text('reminder', '', ['placeholder' => '01-01-2019', 'class' => 'form-control', 'id' => 'reminder']) !!}
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btn_save_action">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- End Concrete Action Modal -->

<!-- Reminder Modal -->
<div class="modal fade bd-reminder-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
  <div class="modal-content" id="modal_reminder_content">
    <div class="modal-header">
      <h5 class="modal-title">Nuevo recordatorio</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <div class="form-group">
        {!! Form::label('Reminder', 'Recordatorio') !!}
        {!! Form::text('reminder_text', '', ['placeholder' => 'Ingrese recordatorio', 'class' => 'form-control', 'id' => 'reminder_text','required']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('ReminderDate', 'Fecha del recordatorio') !!}
        {!! Form::text('reminder_date', '', ['placeholder' => '01-01-2019', 'class' => 'form-control', 'id' => 'reminder_date']) !!}
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      <button type="button" class="btn btn-primary" id="btn_save_reminder">Guardar</button>
    </div>
  </div>
</div>
</div>
<!-- End Reminder Modal -->

<!-- Cost Modal -->
<div class="modal fade bd-cost-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
  <div class="modal-content" id="modal_cost_content">
    <div class="modal-header">
      <h5 class="modal-title">Nuevo costo</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <div class="form-group">
        {!! Form::label('Cost', 'Detalle de costo') !!}
        {!! Form::text('cost_text', '', ['placeholder' => 'Ingrese detalle de costo', 'class' => 'form-control', 'id' => 'cost_text','required']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('Monto', 'Monto') !!}
        {!! Form::text('amount', '', ['placeholder' => '₡0.00', 'class' => 'form-control', 'id' => 'amount']) !!}
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      <button type="button" class="btn btn-primary" id="btn_save_cost">Guardar</button>
    </div>
  </div>
</div>
</div>
<!-- End Cost Modal -->

<!-- Document Modal -->
<div class="modal fade bd-doc-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
  <div class="modal-content" id="modal_doc_content">
    <div class="modal-header">
      <h5 class="modal-title">Nuevo documento</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <div class="form-group">
        {!! Form::label('Title', 'Título') !!}
        {!! Form::text('title', '', ['placeholder' => 'Ingrese título o detalle de documento', 'class' => 'form-control', 'id' => 'title','required']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('Link', 'Link') !!}
        {!! Form::text('link', '', ['placeholder' => 'https://www.dropbox-example.com/example', 'class' => 'form-control', 'id' => 'link']) !!}
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      <button type="button" class="btn btn-primary" id="btn_save_doc">Guardar</button>
    </div>
  </div>
</div>
</div>
<!-- End Document Modal -->

<script src="{{ asset('js/instance.js') }}" defer></script>
@endsection
