/* .ajax-content,  */
jQuery(document).ready(function($){
$(document).on('submit', 'form[form-data-pjax]', function(event) {
$('#pjax-container').html("<div class='alert alert-success' align='center'><b><i class='fa fa-circle-o-notch fa-spin'></i> Cargando, Espere un momento...</b></div>");
$.pjax.submit(event, '#pjax-container')
});

$(document).on('click', '[data-pjax]', function(event) {
$('#pjax-container').html("<div class='alert alert-success' align='center'><b><i class='fa fa-circle-o-notch fa-spin'></i> Cargando, Espere un momento...</b></div>");
$.pjax.click(event, '#pjax-container')
});

$(document).on('click', '[update-body]', function(event) {
$('.ajax-content').html("<div class='alert alert-success' align='center'><b><i class='fa fa-circle-o-notch fa-spin'></i> Cargando, espere un momento...</b></div>");
$.pjax.click(event, '.ajax-content')
});

});