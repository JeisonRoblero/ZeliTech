<?php
check_admin();

$id = clear($id);

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

<h2>Visualizando compra de <span style="color: #08f"><?=$nombre?></span> con ID: <span style="color: #08f"><?=$id?></span></h2><br>

<b>Fecha: </b><?=fecha($r['fecha'])?><br>
<b>Monto: </b><?=$divisa?><?=number_format((float)$r['monto'],2,'.',',')?><br>
<b>Estado: </b><?=estado($r['estado'])?><br><br>

<div class="table-responsive">
<table class="table table-striped">
	<tr>
		<th>Nombre</th>
		<th>Cantidad</th>
		<th>Monto</th>
		<th>Descuento</th>
		<th>Monto Final</th>
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
				<td style="text-align:center"><?=$rp['cantidad']?></td>
				<td style="text-align:center"><?=number_format((float)$rp['monto'],2,'.',',')?></td>

				<td style="text-align:center"><?php
					if ($rpro['oferta']>0) {
						echo $rpro['oferta']."%";
					}else{
						echo "No aplica";
					}
				?>
				</td>

				<td style="text-align:center"><?=$divisa?><?=number_format((float)$preciofinal,2,'.',',')?></td>

			</tr>
			<?php
		}
	?>
</table>
</div>
<br>

<h3>Contacto y dirección de envio de: <span style="color: #08f"><?=$nombre?> <?=$rc['last_name']?></span></h3><br>

<center><img src="<?=$rc['foto']?>" alt="😄 Foto de Perfil" style="border-radius:1000px;border:5px solid #3C8DBC"></center>

<br><br>

<div class="table-responsive">
<table class="table table-striped">

		
	<tr>
		<th>Correo eléctronico: </th>
		<td><?=$rc['username']?></td>
	</tr>

	<tr>
		<th>Teléfono: </th>
		<td><?=$rc['telefono']?></td>
	</tr>

	<tr>
		<th>País: </th>
		<td><?=$rc['pais']?></td>
	</tr>

	<tr>
		<th>Estado / Departamento: </th>
		<td><?=$rc['departamento']?></td>
	</tr>

	<tr>
		<th>Dirección: </th>
		<td><?=$rc['direccion1']?></td>
	</tr>

	<tr>
		<th>Más detalles de dirección: </th>
		<td><?=$rc['direccion2']?></td>
	</tr>

	<tr>
		<th>Código Postal: </th>
		<td><?=$rc['codigo_postal']?></td>
	</tr>

	<tr>
		<th>Notas del pedido: </th>
		<td><?=$r['notas']?></td>
	</tr>

</table>
</div>