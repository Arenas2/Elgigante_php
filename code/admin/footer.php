
<script type="text/javascript">
$(document).ready(function(){
$(".ver_info_pedido").click(function(){
var $input = $(this);
var id_pedido = $input.attr("id_pedido");
$(".modal-content").html('<div align="center"><i class="fa fa-share fa-spin" aria-hidden="true"></i></div>');
$(".modal-content").load('./inc/ajax.ver_info_pedido.php?id_pedido='+id_pedido);
});
});
</script>

<div class="modal fade bs-example-modal-lg" id="modal"  role="dialog" aria-hidden="true" >
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
</div>
</div>
</div>

</div>
<?php if($nojquery == "") { ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<?php } ?>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</body>
</html>