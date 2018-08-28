var pathname = window.location.pathname;
var parts = pathname.split('/');
var lastSegment = parts.pop() || parts.pop();  // handle potential trailing slash

var current_date = null;
var current_date_d_m_y = null;
$( document ).ready(function() {
  get_current_date();
  get_data_by_date();
  $('#rec_calendar').val(current_date_d_m_y);
  set_li_active();
});

function set_li_active(){
  if(lastSegment === 'home'){
    $('#reminders_li').css('border-bottom-style', 'solid');
    $('#reminders_li').addClass('active');
  }else{
    $('#actions_li').css('border-bottom-style', 'solid');
    $('#actions_li').addClass('active');
  }
}

// Format date --> yyyy-mm-dd
function get_current_date(){
  var x = new Date();
  var y = x.getFullYear().toString();
  var m = (x.getMonth() + 1).toString();
  var d = x.getDate().toString();
  (d.length == 1) && (d = '0' + d);
  (m.length == 1) && (m = '0' + m);
  current_date = y + '-' + m + '-' + d;
  if(!current_date_d_m_y) current_date_d_m_y = d + '-' + m + '-' + y;
}

var Reminders_By_Date = {
  getData: function(query) {
    return $.getJSON('/reminders_by_date/'+ query + '/showByDate');
  }
}

var Actions_By_Date = {
  getData: function(query) {
    return $.getJSON('/actions_by_date/'+ query + '/showByDate');
  }
}

function get_data_by_date(){
  if(lastSegment === 'home'){
    Reminders_By_Date.getData(current_date).done(function(json){
      var result = '<table class="table"><tr><th>Recordatorio</th><th>Cliente</th>'
      +'<th>Caso</th><th>Opción</th></tr><tbody>';
      for (var i = 0; i < json.reminders.length; i++) {
        result += '<tr><td>'+json.reminders[i].reminder+'</td><td>'+json.reminders[i].full_name+
        '</td><td>'+json.reminders[i].subject+'</td><td><a href="/instance/'+json.reminders[i].instance_id+'" target="blank">'+
        'Ver Caso</a></td></tr>';
      }
      result += '</tbody></table>';
      $('#data_div').empty();
      $('#data_div').append(result);
    });
  }else{
    Actions_By_Date.getData(current_date).done(function(json){
      var result = '<table class="table"><tr><th>Acción recomendada</th><th>Cliente</th>'
      +'<th>Caso</th><th>Opción</th></tr><tbody>';
      for (var i = 0; i < json.actions.length; i++) {
        result += '<tr><td>'+json.actions[i].action+'</td><td>'+json.actions[i].full_name+
        '</td><td>'+json.actions[i].subject+'</td><td><a href="/instance/'+json.actions[i].instance_id+'" target="blank">'+
        'Ver Caso</a></td></tr>';
      }
      result += '</tbody></table>';
      $('#data_div').empty();
      $('#data_div').append(result);
    });
  }
}

$('#rec_calendar').click(function(){
  $('.picker__holder').show();
});

$('#rec_calendar').pickadate({
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
          let date = $('#rec_calendar').val().split('-');
          current_date = date[2] + '-' + date[1] + '-' + date[0];
          get_data_by_date();
        }
      });
