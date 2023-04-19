<head>
<title>Ver Compra | ZeliTech</title>
</head>
<body>
<section data-index="9" class="ver_compra">

<style>
	.a:nth-child(7) {
		background: white;
		color: black;
		text-decoration: none;
	}
</style>

<?php
check_user('ver_compra_cliente');

$id = clear($id);

$link = conectarse();
$sql = "SELECT * FROM compra WHERE id = '$id' AND id_cliente = '".$_SESSION['id_cliente']."'";
$s = mysqli_query($link,$sql);

if (mysqli_num_rows($s)>0) {

	$link = conectarse();
	$query = "SELECT * FROM compra WHERE id = '$id'";
	$s = mysqli_query($link,$query);
	$r = mysqli_fetch_array($s);

	$link = conectarse();
	$query = "SELECT * FROM cliente WHERE id = '".$r['id_cliente']."'";
	$sc = mysqli_query($link,$query);
	$rc = mysqli_fetch_array($sc);

	$nombre = $rc['name'];

	?>

	<h2 class="carrito-titulo">Visualizando compra con ID: <span style="color: #08f"><?=$r['id']?></span></h2><br>

	<b>Fecha: </b><?=fecha($r['fecha'])?><br>
	<b>Monto: </b><?=$divisa?><?=number_format((float)$r['monto'],2,'.',',')?><br>
	<b>Estado: </b><?=estado($r['estado'])?><br><br>

	<div class="table-responsive">
	<table class="table table-striped carrito-tabla">
		<tr>
			<th>Nombre</th>
			<th style="text-align:center">Cantidad</th>
			<th style="text-align:center">Monto</th>
			<th style="text-align:center">Descuento</th>
			<th style="text-align:center">Monto/F</th>
			<th style="text-align:center">Acciones</th>
		</tr>
		<?php
			$link = conectarse();
			$query = "SELECT * FROM productos_compra WHERE id_compra = '$id'";
			$sp = mysqli_query($link,$query);
			
			while ($rp=mysqli_fetch_array($sp)) {

				$link = conectarse();
				$query = "SELECT * FROM productos WHERE id = '".$rp['id_producto']."'";
				$spro = mysqli_query($link,$query);

				$rpro = mysqli_fetch_array($spro);
				$nombre_producto = $rpro['name'];

				if($rpro['oferta']>0){
					if (strlen($rpro['oferta'])==1) {
						$desc = "0.0".$rpro['oferta'];
					}else{
						$desc = "0.".$rpro['oferta'];
					}

					$preciofinal = $rpro['price'] - ($rpro['price'] * $desc);
					
				}else{
					$preciofinal = $rpro['price'];
				}

				?>
				<tr>
					<td><?=$nombre_producto?></td>
					<td style="vertical-align:middle;text-align:center"><?=$rp['cantidad']?></td>
					<td style="vertical-align:middle;text-align:center"><?=number_format((float)$rp['monto'],2,'.',',')?></td>

					<td style="vertical-align:middle;text-align:center"><?php
						if ($rpro['oferta']>0) {
							echo $rpro['oferta']."%";
						}else{
							echo "Sin descuento";
						}
					?>
					</td>

					<td style="vertical-align:middle;text-align:center"><?=$divisa?><?=number_format((float)$preciofinal,2,'.',',')?></td>

					<td style="vertical-align:middle;text-align:center">
						<?php
							if ($rpro['digital']!="") {
								?>
								<a href="productos/digitales/<?=$rpro['digital']?>" class="icono-visible"><i class="fa fa-eye"></i></a>
								&nbsp;
								<a href="productos/digitales/<?=$rpro['digital']?>" class="icono-visible" download><i class="fa fa-download"></i></a>
								<?php
							}else{
								?>
								<a href="#" onclick="ver('<?=$rpro['id']?>')" class="icono-visible"><i class="fa fa-eye"></i></a>
							<?php	
							}
						?>
					</td>

				</tr>
				<?php
			}
		?>
	</table>
	</div>

<?php

}else{
	alert('Ha ocurrido un error al conectarse al servidor',0,'miscompras');
}

?>


<script>
	function ver(idp){
		window.location="?p=descripcion_producto&idpp="+idp;
	}
</script>


</section>
</body>