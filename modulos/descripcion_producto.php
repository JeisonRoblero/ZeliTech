<?php 

$link = Conectarse();
$query = "SELECT * FROM productos WHERE id = $idpp";
$q = mysqli_query($link, $query);

$rp=mysqli_fetch_array($q);

?>

<head>
	<title><?=$rp['name']?> | ZeliTech</title>
</head>
<body>

<section data-index="10" class="descripcion_producto">
	

<?php
if(isset($agregar) && isset($cant)){

	check_user("productos");

	//Si es un administrador
	if (isset($_SESSION['id'])) {
		alert("Para agregar articulos al carrito debe iniciar sesión como cliente",2,'productos');
	}

	$idp = clear($agregar);
	$cant = clear($cant);
	$id_cliente = clear($_SESSION['id_cliente']);

	$link = Conectarse();
	$query = "SELECT * FROM carrito WHERE id_cliente = '$id_cliente' AND id_producto = '$idp'";
	$v = mysqli_query($link, $query);

	if (mysqli_num_rows($v)>0) {

		$link = Conectarse();
		$query = "UPDATE carrito SET cant = cant + $cant WHERE id_cliente = '$id_cliente' AND id_producto = '$idp'";
		$q = mysqli_query($link, $query);

	}else{
		
		$link = Conectarse();
		$query = "INSERT INTO carrito (id_cliente,id_producto,cant) VALUES ($id_cliente,$idp,$cant)";
		$q = mysqli_query($link, $query);

	}

	alert("Se ha agregado al carro de compras",1,'carrito');

}

?>

<table class="table table-striped movil-desc">

	<?php
		$link = Conectarse();
		$query = "SELECT * FROM productos WHERE id = $idpp";
		$q = mysqli_query($link, $query);

		while ($rp=mysqli_fetch_array($q)) {
			$preciofinal = 0; 

			$link = Conectarse();
			$sql = "SELECT * FROM categorias WHERE id = '".$rp['id_categoria']."'";
			$cat = mysqli_query($link, $sql);

			
			if (mysqli_num_rows($cat)>0) {
				$rcat = mysqli_fetch_array($cat);
				$categoria = $rcat['nombre_categoria'];
			}else{
				$categoria = "--";
			}

			if($rp['oferta']>0){
				if (strlen($rp['oferta'])==1) {
					$desc = "0.0".$rp['oferta'];
				}else{
					$desc = "0.".$rp['oferta'];
				}

				$preciofinal = $rp['price'] - ($rp['price'] * $desc);
				
			}else{
				$preciofinal = $rp['price'];
			}

			

			?>


	<div class="site-section blurdescripcion">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <img src="<?=$rp['imagen']?>" alt="Image" class="img-fluid img-round">
          </div>
          <div class="col-md-6">
            <h2><?=$rp['name']?></h2>
            <p><?=$rp['descripcion']?></p>
            <p><strong class="text-primary h4"><?=$divisa?><?=number_format((float)$preciofinal,2,'.',',')?></strong></p>
			<center><button type="button" class="btn btn-success" onclick="comprar_ahora('<?=$rp['id']?>')"><i class="fa fa-shopping-bag"></i> COMPRAR AHORA</button></center>
			<center><button type="button" class="btn btn-warning" style="margin-top:10px" onclick="agregar_carro('<?=$rp['id']?>')"><i class="fa fa-shopping-cart"></i> Agregar al carrito</button></center>

            </div>
			

          </div>
        </div>
      </div>
    </div>


<br>

				


				<tr>
					<?php
					if (!empty($rp['video'])) {
					?>
					<tr>
					<td colspan="2"><center><h2 id="nombre-prod"><b><i><?=$rp['name']?></i></b></h2></center></td>
					</tr>
						<td class="deeesc"><center><iframe width="560" height="315" src="<?=$rp['video']?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></center></td>
					<?php
					}
					?>
				</tr>
</table>


<table class="table table-striped movil-desc">
				<tr class="contenedor-imagen">

					<td class="imagen-centrada"><img class="img_prod" id="imagen-prod" src="<?=$rp['imagen']?>"/></td>

					<td><h3><b>Precio</b></h3><h5 style="color:white"><?=$divisa?><?=number_format((float)$rp['price'],2,'.',',')?></h5>

					<b><h3><b>Descuento:</b></h3></b>
					<h5 style="color:red">
					<?php
						if($rp['oferta']>0){
							echo $rp['oferta']."%";
						}else{
							echo "Sin descuento";
						}
					?></h5>


					<b><h3><b>Precio Final:</b></h3></b> <b> <h5 style="color: yellowgreen"><?=$divisa?><?=number_format((float)$preciofinal,2,'.',',')?><h5> </b>
					<br><center><button type="button" class="btn btn-success" onclick="comprar_ahora('<?=$rp['id']?>')"><i class="fa fa-shopping-bag"></i> COMPRAR AHORA</button></center>
					<center><button type="button" class="btn btn-warning" style="margin-top:10px" onclick="agregar_carro('<?=$rp['id']?>')"><i class="fa fa-shopping-cart"></i> Agregar al carrito</button></center>


					</td>			

					

					<?php
						if (isset($_SESSION['id'])) {
					?>	
						<td>
							<a href="?p=modificar_producto&id=<?=$rp['id']?>"><i class="fa fa-edit"></i></a>
							&nbsp;
							<a href="?p=agregar_productos&eliminar=<?=$rp['id']?>"><i class="fa fa-times"></i></a>

						</td>
					<?php  
						}
					?>	
					
				</tr>

				<div class="fullscreen-container">
					<img src="<?=$rp['imagen']?>" alt="fondo" style="width:100%; filter: blur(4px);" class="fullscreen-video">
				</div>

			<?php
		}

	?>

</table>



<script type="text/javascript">
	
	async function agregar_carro(idp){
		
		const { value: text } = await Swal.fire({
		input: 'number',
		html: `¿Cuántos desea agregar al carrito?`,
		inputPlaceholder: 'Escribe un numero',
		inputAttributes: {
			'aria-label': 'Escribe un numero'
		},
		showCancelButton: true
		})

		//var cant = prompt("¿Cuántos articulos desea agregar al carrito?",1);
		var cant = text;

		if (cant.length>0 && cant>0) {
			window.location = "?p=descripcion_producto&agregar="+idp+"&cant="+cant+"&idpp="+idp;
		}else{
			alert("Ingrese algo al carrito",2,'descripcion_producto&idpp=<?=$idpp?>');
		}
	}


	function comprar_ahora(idp){
		
		//var cant = prompt("¿Cuántos articulos desea agregar al carrito?",1);
		var cant = '1';

		if (cant.length>0 && cant>0) {
			window.location = "?p=productos&comprar="+idp+"&cant="+cant;
		}else{
			alert("Ingrese algo al carrito",2,'descripcion_producto&idpp=<?=$idpp?>');
		}
	}




</script>

</section>
</body>


	



