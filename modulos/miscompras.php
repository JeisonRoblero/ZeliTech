<head>
<title>Mis compras | ZeliTech </title>
</head>
<body>
<section data-index="4" class="miscomprass">

<style>
	.a:nth-child(5) {
		background: white;
		color: black;
		text-decoration: none;
	}
</style>

<?php
check_user('miscompras');

if (isset($eliminar)) {
	$eliminar = clear($eliminar);

	$link = conectarse();
	$sql = "SELECT * FROM compra WHERE id = '$eliminar'";
	$s = mysqli_query($link,$sql);
	$r = mysqli_fetch_array($s);

	$link = conectarse();
	$sql2 = "INSERT INTO compras_finalizadas (id,id_cliente,fecha,monto,estado) VALUES ('".$r['id']."','".$r['id_cliente']."','".$r['fecha']."','".$r['monto']."','".$r['estado']."')";
	mysqli_query($link,$sql2);

	$link = conectarse();
	$sql = "DELETE FROM compra WHERE id = '$eliminar'";
	mysqli_query($link,$sql);

	redir("?p=miscompras");
}

$link = conectarse();
$sql = "SELECT * FROM compra WHERE id_cliente = '".$_SESSION['id_cliente']."' ORDER BY fecha DESC";
$s = mysqli_query($link,$sql);

if (mysqli_num_rows($s)>0) {
	?>
	<h2>Mis Compras</h2><br>

	<table class="table table-stripe tabla-miscompras">
		<tr>
			<th>Fecha</th>
			<th>Monto</th>
			<th>Estado</th>
			<th>Acciones</th>
		</tr>

	<?php
	while ($r=mysqli_fetch_array($s)) {
		?>
		<tr>
			<td><?=fecha($r['fecha'])?></td>
			<td><?=$divisa?><?=number_format((float)$r['monto'],2,'.',',')?></td>
			<td><?=estado($r['estado'])?></td>
			<td>
				<a href="?p=ver_compra_cliente&id=<?=$r['id']?>" class="icono-visible">
					<i class="fa fa-eye"></i>
				</a>
				&nbsp; &nbsp;

				<?php
				if ($r['estado']==3) {
				?>
					<a href="?p=miscompras&eliminar=<?=$r['id']?>" class="icono-visible">
						<i class="fa fa-times"></i>
					</a>
				<?php
				}
				?>
			</td>
		</tr>

		<?php
	}
	?>
	</table>
	<?php
}else{
	?>
	<i>Ahora mismo no tienes ninguna compra</i>

	<?php
}

?>

</section>
</body>