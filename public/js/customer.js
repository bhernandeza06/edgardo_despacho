$( document ).ready(function() {
    $('#edit_contact').hide();
    $('#edit_customer_a').css('float', 'right');
});

$('#edit_customer_a').click(function(e){
  e.preventDefault();
  if($(this).text() == 'Editar'){
    $('#show_contact').hide();
    $('#edit_contact').show();
    $(this).html('Cancelar');
  }else {
    $('#edit_contact').hide();
    $('#show_contact').show();
    $(this).html('Editar');
  }
});

$('#customer_li').css('border-bottom-style', 'solid');
$('#customer_li').addClass('active');
