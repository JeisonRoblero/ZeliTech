<?php
check_admin();

//0 recien comprado
//1 preparando compra
//2 en camino
//3 despachado

$link = conectarse();
$query = "SELECT * FROM compra WHERE estado != 3";
$s = mysqli_query($link,$query);

if (isset($eliminar)) {
	$eliminar = clear($eliminar);

	$link = conectarse();
	$query = "DELETE FROM productos_compra WHERE id_compra = '$eliminar'";
	mysqli_query($link,$query);

	$link = conectarse();
	$query = "DELETE FROM compra WHERE id = '$eliminar'";
	mysqli_query($link,$query);

	redir("?p=manejar_traking");
}

?>

<h2>Trakings</h2>

<div class="table-responsive">
<table class="table table-stripe">
	<tr>
		<th>Cliente</th>
		<th>Fecha</th>
		<th>Monto</th>
		<th>Status</th>
		<th>Acciones</th>
	</tr>

<?php
	while ($r=mysqli_fetch_array($s)) {

		$link = conectarse();
		$query = "SELECT * FROM cliente WHERE id = '".$r['id_cliente']."'";
		$sc = mysqli_query($link,$query);

		$rc = mysqli_fetch_array($sc);

		$cliente = $rc['name'];


		if ($r['estado'] == 0) {
			$status = "Iniciando";
		}elseif ($r['estado'] == 1) {
			$status = "Preparando";
		}elseif ($r['estado'] == 2) {
			$status = "Despachando";
		}elseif ($r['estado'] == 3) {
			$status = "Finalizado";
		}else{
			$status = "Indefinido";
		}

		$fecha = fecha($r['fecha']);

		?>
		<tr>
			<td><?=$cliente?></td>
			<td><?=$fecha?></td>
			<td><?=$divisa?><?=number_format((float)$r['monto'],2,'.',',')?></td>
			<td><?=$status?></td>

			<td>

				<a style="color: #08f" href="?p=ver_compra&id=<?=$r['id']?>">
					<i class="fa fa-eye"></i>
				</a>

				&nbsp; &nbsp;

				<a style="color: #08f" href="?p=manejar_status&id=<?=$r['id']?>">
					<i class="fa fa-edit"></i>
				</a>

				&nbsp; &nbsp;

				<a style="color: #08f" href="?p=manejar_traking&eliminar=<?=$r['id']?>">
					<i class="fa fa-times"></i>
				</a>

			</td>

		</tr>
		<?php

	}


?>
</table>
</div>