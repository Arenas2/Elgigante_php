<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<![endif]-->

<meta name="viewport" content="width=device-width, initial-scale=1">
<title>El Gigante de los Azulejos y Marmoles</title>

<link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.6/flatly/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

<link rel="stylesheet" href="./css/estilos.css">

<?php if($nojquery == "") { ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<?php } ?>
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<script src="./js/header.js"></script>
<script src="<?php echo $url_server; ?>/js/jquery.pjax.js"></script>

<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.0.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.0.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.0.3/js/buttons.colVis.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.8/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.0.1/css/buttons.dataTables.min.css">

<script src="https://cdn.jsdelivr.net/select2/4.0.2/js/select2.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/select2/4.0.2/js/i18n/es.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/select2/4.0.2/css/select2.min.css">

</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
<div class="container-fluid">
<div class="navbar-header">
<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<a class="navbar-brand" href="./"><img height="40" src="../../../images/logo.png" title=""></a>
</div>

<div class="collapse navbar-collapse" id="navbar">
<ul class="nav navbar-nav">
<li class="active"><a >Administraci&oacute;n</a></li>
</ul>

<ul class="nav navbar-nav navbar-right">
<li class=""><a href="./Pedidos.php?estatus=Ingresado">Pedidos</a></li>
<li class=""><a href="./Categorias.php">Productos</a></li>
<li><a href="./Stock.php">Stock</a></li>
<!-- <li><a href="<?php echo $url_server; ?>/_a_d_m_i_n_/Categorias.php?tipo=pagina">Paginas</a></li> -->

<li><a href="./Entradas.php?tipo=slider_index">Slider</a></li>
<li><a href="./Entradas.php?tipo=galeria_imagenes">Galer&iacute;a</a></li>
<li><a href="./Entradas.php?tipo=promociones">Promociones</a></li>
<li><a href="./Entradas.php?tipo=catalogos">Cat&aacute;logos</a></li>
<li><a href="./Sucursales.php">Sucursales</a></li>
<li><a href="./Entradas.php?tipo=blog">Blog</a></li>

<!--
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Men&uacute; de Secciones <span class="caret"></span></a>
<ul class="dropdown-menu" role="menu">
<li class="divider"></li>
</ul>
</li>
-->
<!-- <li class=""><a href="<?php echo $url_server; ?>/_a_d_m_i_n_/Pedidos.php">Pedidos</a></li>-->
<!-- <li><a href="<?php echo $url_server; ?>/_a_d_m_i_n_/Usuarios.php">Usuarios</a></li> -->
<!--
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">Productos <b class="caret"></b></a>
<ul class="dropdown-menu">
<li class="divider"></li>
<li><a href="Listado_Productos.php">Listado de Productos</a></li>
</ul>
</li>
-->
</ul>

</div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>

<div class="container-fluid">

