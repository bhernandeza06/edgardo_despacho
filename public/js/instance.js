var pathname = window.location.pathname;
var parts = pathname.split('/');
var lastSegment = parts.pop() || parts.pop();  // handle potential trailing slash

var Customer = {
  getData: function(query) {
    return $.getJSON('/customer/'+ query + '/showByQuery');
  }
}

var ConcreteAction = {
  save: function(instance_id, action, reminder){
    return $.getJSON('/concrete/'+instance_id+'/'+action+'/'+reminder+'/save');
  },
  get: function(instance_id){
    return $.getJSON('/concrete/'+instance_id+'/get');
  },
  destroy: function(action_id){
    return $.getJSON('/concrete/'+action_id+'/destroy');
  }
}

var Reminder = {
  save: function(instance_id, reminder, reminder_date){
    return $.getJSON('/reminder/'+instance_id+'/'+reminder+'/'+reminder_date+'/save');
  },
  get: function(instance_id){
    return $.getJSON('/reminder/'+instance_id+'/get');
  },
  destroy: function(reminder_id){
    return $.getJSON('/reminder/'+reminder_id+'/destroy');
  }
}

var Cost = {
  save: function(instance_id, subject, amount){
    return $.getJSON('/cost/'+instance_id+'/'+subject+'/'+amount+'/save');
  },
  get: function(instance_id){
    return $.getJSON('/cost/'+instance_id+'/get');
  },
  destroy: function(cost_id){
    return $.getJSON('/cost/'+cost_id+'/destroy');
  }
}

var Doc = {
  save: function(instance_id, title, link){
    return $.getJSON('/doc/'+instance_id+'/'+title+'/'+link+'/save');
  },
  get: function(instance_id){
    return $.getJSON('/doc/'+instance_id+'/get');
  },
  destroy: function(doc_id){
    return $.getJSON('/doc/'+doc_id+'/destroy');
  }
}

$( document ).ready(function() {
    $('#edit_info').hide();
    $('#edit_instance_a').css('float', 'right');
    $('#btn_create_instance').prop('disabled', true);
    $('.picker__holder').hide();
    load_actions();
    load_reminders();
    load_costs();
    load_docs();
    user_verification();
    verify_on_ready();
    get_current_date();
});

function get_current_date(){
  var x = new Date();
  var y = x.getFullYear().toString();
  var m = (x.getMonth() + 1).toString();
  var d = x.getDate().toString();
  (d.length == 1) && (d = '0' + d);
  (m.length == 1) && (m = '0' + m);
  var date = d + '-' + m + '-' + y;
  $('#reminder').val(date);
  $('#reminder_date').val(date);
}

function user_verification(){
  if(typeof $('#current_customer') === 'undefined' || !$('#current_customer')){
    if($('#current_customer').val().length > 0){
      $('#btn_create_instance').prop('disabled', false);
    }
  }
}

var customers;

$( "#customer_input" ).keyup(function() {
  if($(this).val().length > 2){
    var result = '<table class="table"><tbody><th>Cédula</th><th>Nombre</th><th>Acción</th>';
    Customer.getData($(this).val()).done(function(json) {
      customers = json.customers;
      if(customers.length > 0){
        for(var i = 0; i < customers.length; i++){
          result += '<tr>' +
                      '<td>' + customers[i].id_card + '</td>' +
                      '<td>' + customers[i].full_name + '</td>' +
                      '<td><a href="#" onclick="fill_customer(' + customers[i].id + ')">Seleccionar</a></td>' +
                    '</tr>';
        }
        result += '</tbody></table>';
        $('#tblCustomers').html(result);
      }else{
        $('#tblCustomers').html('<h5 style="color:blue">No se encuentraron resultados</h5>');
        $('#id_customer').val('');
        $('#btn_create_instance').prop('disabled', true);
      }
      });
  }else{
    $('#tblCustomers').html('');
  }
});

function verify_on_ready(){
  var customer = $( "#customer_input" ).val();
    if(customer.length > 2){
      Customer.getData(customer).done(function(json) {
        if(json.customers.length > 0){
          $('#id_customer').val(json.customers[0].id);
          $("input[name='subject']").focus();
          $('#customer_input').prop('disabled', true);
          $('#btn_create_instance').prop('disabled', false);
        }
      });
    }
}

function fill_customer(id){
  $(customers).each(function(i, el){
    if(id === el.id){
      $('#customer_input').val(el.full_name);
      $('#customer_input').prop('disabled', true);
      $('#tblCustomers').html('');
      $('#current_customer').val(el.id);
      $('#id_customer').val(el.id);
      $('#btn_create_instance').prop('disabled', false);
      return;
    }
  });
}

$('#edit_instance_a').click(function(e){
  e.preventDefault();
  if($(this).text() == 'Editar'){
    $('#show_contact').hide();
    $('#edit_info').show();
    $(this).html('Cancelar');
  }else {
    $('#edit_info').hide();
    $('#show_contact').show();
    $(this).html('Editar');
  }
});

$('#instance_li').css('border-bottom-style', 'solid');
$('#instance_li').addClass('active');

$('#btn_refresh_customer').click(function(){
  $('#customer_input').val('');
  $('#customer_input').prop('disabled', false);
  $('#current_customer').val('');
  $('#id_customer').val('');
  $('#btn_create_instance').prop('disabled', true);
});

$('#btn_save_action').click(function(){
  if($('#action').val().length > 0 && $('#reminder').val().length > 0){
    $('#actions_div').empty();
    ConcreteAction.save(lastSegment, $('#action').val(), $('#reminder').val()).done(function(json){
      if(json.code == 200 || json.code == 201){
        set_body_actions(json.actions);
      }
    });
    $('.bd-concrete-modal-lg').modal('hide')
  }else{
    alert('Acción o fecha no ingresados');
  }
});

function load_actions(){
  ConcreteAction.get(lastSegment).done(function(json){
    if(json.code == 200 || json.code == 201){
      set_body_actions(json.actions);
    }
  });
}

function set_body_actions(actions){
  var result = '<table class="table"><tbody>';
  for (var i = 0; i < actions.length; i++) {
    result += '<tr><td>'+actions[i].action+'</td><td>'+actions[i].reminder+'</td>'+
        '<td><span class="d-inline-block" tabindex="0" data-toggle="tooltip"'+
        'title="Eliminar"><a href="" onclick="return confirm_warn('+actions[i].id+', 1)">'+
        '<i class="far fa-trash-alt"></i></a></span></td></tr>';
  }
  result += '</tbody></table>';
  $('#actions_div').append(result);
}

$('#btn_save_reminder').click(function(){
  if($('#reminder_text').val().length > 0 && $('#reminder_text').val().length > 0){
    $('#reminders_div').empty();
    Reminder.save(lastSegment, $('#reminder_text').val(), $('#reminder_date').val()).done(function(json){
      if(json.code == 200 || json.code == 201){
        set_body_reminders(json.reminders);
      }
    });
    $('.bd-reminder-modal-lg').modal('hide')
  }else{
    alert('Recordatorio o fecha no ingresados');
  }
});

function load_reminders(){
  Reminder.get(lastSegment).done(function(json){
    if(json.code == 200 || json.code == 201){
      set_body_reminders(json.reminders);
    }
  });
}

function set_body_reminders(reminders){
  var result = '<table class="table"><tbody>';
  for (var i = 0; i < reminders.length; i++) {
    result += '<tr><td>'+reminders[i].reminder+'</td><td>'+reminders[i].reminder_date+'</td>'+
        '<td><span class="d-inline-block" tabindex="0" data-toggle="tooltip"'+
        'title="Eliminar"><a href="" onclick="return confirm_warn('+reminders[i].id+', 2)">'+
        '<i class="far fa-trash-alt"></i></a></span></td></tr>';
  }
  result += '</tbody></table>';
  $('#reminders_div').append(result);
}

$('#btn_save_cost').click(function(){
  if($('#cost_text').val().length > 0 && $('#amount').val().length > 0){
    if (!isNaN($('#amount').val())) {
      $('#costs_div').empty();
      Cost.save(lastSegment, $('#cost_text').val(), $('#amount').val()).done(function(json){
        if(json.code == 200 || json.code == 201){
          set_body_costs(json.costs);
        }
      });
      $('.bd-cost-modal-lg').modal('hide')
    }else{
      alert('Ha ingresado valores no permitidos en el campo "Monto"');
    }
  }else{
    alert('Detalle o costo no ingresados');
  }
});

function load_costs(){
  Cost.get(lastSegment).done(function(json){
    if(json.code == 200 || json.code == 201){
      set_body_costs(json.costs);
    }
  });
}

function set_body_costs(costs){
  var result = '<table class="table"><tbody>';
  for (var i = 0; i < costs.length; i++) {
    result += '<tr><td>'+costs[i].subject+'</td><td>₡'+costs[i].amount+'</td>'+
        '<td><span class="d-inline-block" tabindex="0" data-toggle="tooltip"'+
        'title="Eliminar"><a href="" onclick="return confirm_warn('+costs[i].id+', 3)">'+
        '<i class="far fa-trash-alt"></i></a></span></td></tr>';
  }
  result += '</tbody></table>';
  $('#costs_div').append(result);
}

$('#btn_save_doc').click(function(){
  if($('#title').val().length > 0 && $('#link').val().length > 0){
    $('#docs_div').empty();
    let link = $('#link').val().replace('https://', '');
    link = link.replace(/[/]/g, '@.@');
    console.log(link);
    Doc.save(lastSegment, $('#title').val(), link).done(function(json){
      if(json.code == 200 || json.code == 201){
        set_body_docs(json.docs);
      }
    });
    $('.bd-doc-modal-lg').modal('hide')
  }else{
    alert('Título o link no ingresados');
  }
});

function load_docs(){
  Doc.get(lastSegment).done(function(json){
    if(json.code == 200 || json.code == 201){
      set_body_docs(json.docs);
    }
  });
}

function set_body_docs(docs){
  var result = '<table class="table"><tbody>';
  for (var i = 0; i < docs.length; i++) {
    let link = docs[i].link.replace(/@.@/gi, '/');
    result += '<tr><td>'+docs[i].title+'</td><td><a href="https://'+link+'"'+
        'target="blank">https://'+link+'</a></td>'+
        '<td><span class="d-inline-block" tabindex="0" data-toggle="tooltip"'+
        'title="Eliminar"><a href="" onclick="return confirm_warn('+docs[i].id+', 4)">'+
        '<i class="far fa-trash-alt"></i></a></span></td></tr>';
  }
  result += '</tbody></table>';
  $('#docs_div').append(result);
}

function confirm_warn(id, num){
  if(confirm('¿Seguro de confirmar acción?')){
    if(num === 1){
      ConcreteAction.destroy(id).done(function(json){
        if(json.code == 200){
          $('#actions_div').empty();
          load_actions();
        }
      });
    }else if(num === 2){
      Reminder.destroy(id).done(function(json){
        if(json.code == 200){
          $('#reminders_div').empty();
          load_reminders();
        }
      });
    }else if(num === 3){
      Cost.destroy(id).done(function(json){
        if(json.code == 200){
          $('#costs_div').empty();
          load_costs();
        }
      });
    }else{
      Doc.destroy(id).done(function(json){
        if(json.code == 200){
          $('#docs_div').empty();
          load_docs();
        }
      });
    }
  }
  return false;
}

$('#reminder').click(function(){
  $('.picker__holder').show();
});

$('#reminder_date').click(function(){
  $('.picker__holder').show();
});

$('#reminder').pickadate({
        labelMonthNext: 'Ir al siguiente mes',
        labelMonthPrev: 'Ir al mes anterior',
        labelMonthSelect: 'Seleccione un mes',
        labelYearSelect: 'Seleccione un año',
        selectMonths: true,
        selectYears: true,
        format: 'dd-mm-yyyy',
        formatSubmit: 'yyyy-mm-dd',
        hiddenName: true,
        onClose: function() {
          $('.picker__holder').hide();
        }
      });

$('#reminder_date').pickadate({
        labelMonthNext: 'Ir al siguiente mes',
        labelMonthPrev: 'Ir al mes anterior',
        labelMonthSelect: 'Seleccione un mes',
        labelYearSelect: 'Seleccione un año',
        selectMonths: true,
        selectYears: true,
        format: 'dd-mm-yyyy',
        formatSubmit: 'yyyy-mm-dd',
        hiddenName: true,
        onClose: function() {
          $('.picker__holder').hide();
        }
      });

$('.bd-concrete-modal-lg').on('hidden.bs.modal', function (e) {
  $('.picker__holder').hide();
});

$('.bd-reminder-modal-lg').on('hidden.bs.modal', function (e) {
  $('.picker__holder').hide();
});
