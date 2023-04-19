<head>
<title>Carrito | ZeliTech</title>
</head>
<body>
<section data-index="3" class="carritoo">


<style>
	.a:nth-child(4) {
		background: white;
		color: black;
		text-decoration: none;
	}
</style>

<?php
check_user("carrito");
if (isset($eliminar)) {
	$link = Conectarse();
	$sql = "DELETE FROM carrito WHERE id = '$eliminar'";
 	mysqli_query($link, $sql);

 	redir("?p=carrito");
}

if (isset($id) && isset($modificar)) {
	$id = clear($id);
	$modificar = clear($modificar);

	$link = Conectarse();
	$sql = "UPDATE carrito SET cant = '$modificar' WHERE id = '$id'";
 	mysqli_query($link, $sql);

 	redir("?p=carrito");

}

if (isset($finalizar) && $monto_total>0) {

	redir('?p=factura');
}

if (isset($finalizar) && $monto_total<=0) {
	alert("Antes de continuar debes agregar algun producto al carrito...",2,'carrito');
}

?>

<center><h3 class="carrito-titulo"><script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>
			<lord-icon
				src="https://cdn.lordicon.com/slkvcfos.json"
				trigger="loop"
				colors="primary:#ffffff,secondary:#08a88a"
				style="width:60px;height:60px">
			</lord-icon>
			
			Carrito de Compras</h3></center>
<br><br>

<div class="table-responsive">
<table class="table table-striped carrito-tabla">
	<tr style="vertical-align:middle;text-align:center;">
		<th style="color:white"><i class="fa fa-image"></i></th>
		<th style="text-align:left;color:white">Nombre</th>
		<th style="color:white">Cant</th>
		<th style="color:white">Precio/U</th>
		<th style="color:white">Desc</th>
		<th style="color:white">Precio/F</th>
		<th></th>
	</tr>


<?php
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


	$nombre_producto = $r2['name'];

	$cantidad = $r['cant'];

	$precio_unidad = $r2['price'];

	$precio_total = $cantidad * $preciofinal;

	$imagen_producto = $r2['imagen'];

	$monto_total = $monto_total + $precio_total;



	?>
		<tr style="vertical-align:middle;text-align:center">
			<td><img src="<?=$imagen_producto?>" class="imagen_carrito"/></td>
			<td style="text-align:left"><?=$nombre_producto?></td>
			<td><?=$cantidad?></td>
			<td><?=$divisa?><?=number_format((float)$precio_unidad,2,'.',',')?></td>
			
			<td><?php
				if ($r2['oferta']>0) {
					echo $r2['oferta']."%";
				}else{
					echo "No aplica";
				}
			?>
			</td>
			<td><?=$divisa?><?=number_format((float)$precio_total,2,'.',',')?></td>

			<td>
				<a onclick="modificar('<?=$r['id']?>','<?=$nombre_producto?>')" href="#" class="icono-visible"><i class="fa fa-edit" title="Modificar cantidad en carrito"></i></a>
				<a href="?p=carrito&eliminar=<?=$r['id']?>" style="margin-top:5px" class="icono-visible"><i class="fa fa-times" title="Eliminar del carrito"></i></a>
			</td>

		</tr>
	<?php
}

?>
</table>
</div>
<br>
<h2 class="carrito-monto" id="monto_total">Monto Total: <b class="txtg"><?=$divisa?><?=number_format((float)$monto_total,2,'.',',')?></b></h2>

<br><br>

<center>

<br>

<form method="post" action="">
	<input type="hidden" name="monto_total" value="<?=$monto_total?>"/>
<button class="btn btn-success" type="submit" name="finalizar"><i class="fa fa-check"></i> Finalizar Compra</button>
</form>


<br>

</center>

<script type="text/javascript">
	
	async function modificar(idc,nombre){

		const { value: text } = await Swal.fire({
		input: 'number',
		html: `Ingrese la cantidad de ${nombre}'s que desea agregar al carrito:`,
		inputPlaceholder: 'Escribe un numero',
		inputAttributes: {
			'aria-label': 'Escribe un numero'
		},
		showCancelButton: true
		})

		//var new_cant = prompt("¿Cuántos articulos desea agregar al carrito?",1);
		var new_cant = text;

		if (new_cant>0) {
			window.location = "?p=carrito&id="+idc+"&modificar="+new_cant;
		}
	}
</script>

</section>
</body>

