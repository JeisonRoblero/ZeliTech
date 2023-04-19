<head>
<title>ZeliTech | Thank you</title>
</head>
<body>
<section data-index="7" class="thank_you">

<?php

if(!isset($_SERVER['HTTP_REFERER'])){
    // redirect them to your desired location
    redir('./');
    exit;
}

check_user("thank_you");

$id_cliente = clear($_SESSION['id_cliente']);

$link = Conectarse();
$query = "SELECT * FROM carrito WHERE id_cliente = '$id_cliente'";
$q = mysqli_query($link, $query);

$monto_total = 0;

while ($r = mysqli_fetch_array($q)) {

    $link = Conectarse();
    $query = "SELECT * FROM productos WHERE id = '".$r['id_producto']."'"; 
    $q2 = mysqli_query($link, $query);

    $r2 = mysqli_fetch_array($q2);

    $preciofinal = 0;

    if($r2['oferta']>0){
        if (strlen($r2['oferta'])==1) {
            $desc = "0.0".$r2['oferta'];
        }else{
            $desc = "0.".$r2['oferta'];
        }

        $preciofinal = $r2['price'] - ($r2['price'] * $desc);
                                
    }else{
        $preciofinal = $r2['price'];
    }


	$cantidad = $r['cant'];

	$precio_unidad = $r2['price'];

	$precio_total = $cantidad * $preciofinal;

	$monto_total = $monto_total + $precio_total;
}

if($monto_total<=0){
    alert("Debe agregar algo al carrito, para procesar la compra",2,'carrito');
    die();
}else{
  
    $monto = clear($monto_total);

	$id_cliente = clear($_SESSION['id_cliente']);

    $notas = clear($_SESSION['notas']);

	$link = Conectarse();
	$query = "INSERT INTO compra (id_cliente,fecha,monto,estado,notas) VALUES ('$id_cliente',NOW(),'$monto',0,'$notas')";
	$q = mysqli_query($link, $query);

	$link = Conectarse();
	$query = "SELECT * FROM compra WHERE id_cliente = '$id_cliente' ORDER BY id DESC LIMIT 1";
	$sc = mysqli_query($link, $query);

	$rc = mysqli_fetch_array($sc);

	$ultima_compra = $rc['id'];

	$link = Conectarse();
	$query = "SELECT * FROM carrito WHERE id_cliente = '$id_cliente'";
	$q2 = mysqli_query($link, $query);

	while ($r2=mysqli_fetch_array($q2)) {

		$link = Conectarse();
		$query = "SELECT * FROM productos WHERE id = '".$r2['id_producto']."'";
		$sp = mysqli_query($link, $query);

		$rp = mysqli_fetch_array($sp);

		$monto = $rp['price'];
				
		$link = Conectarse();
		$query = "INSERT INTO productos_compra (id_compra,id_producto,cantidad,monto,notas) VALUES ('$ultima_compra','".$r2['id_producto']."','".$r2['cant']."','$monto','$notas')";
		mysqli_query($link, $query);

	}

	$link = Conectarse();
	$query = "DELETE FROM carrito WHERE id_cliente = '$id_cliente'";
	mysqli_query($link, $query);

    //alert("Se ha finalizado la compra con éxito!",1,'thank_you');
	  
	alertnor("Se ha finalizado la compra con éxito!",1);
}


?>

<br><br><br><br>
<div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <span class="icon-check_circle display-3 text-success"></span>
            <i style="font-size:50px" class="fa fa-check-circle"></i>
            <h2 class="display-3 text-white">¡Gracias!</h2>
            <p class="lead mb-5">Tu orden ha sido completada exitosamente <br>
			<small>Para más detalles de tu compra como el estado de la entrega <a href="?p=miscompras" style="color:blue">haz clic aquí</a></small></p>
            <p><a href="?p=principal" class="btn btn-sm btn-primary"><i class="fas fa-arrow-circle-left"></i> Regresar a la tienda</a></p>
          </div>
        </div>
      </div>
</div>

</section>
</body>