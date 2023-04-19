<?php
check_admin();

$link = conectarse();
$query = "SELECT * FROM compra WHERE id = '$id'";
$s = mysqli_query($link,$query);
$r = mysqli_fetch_array($s);

if (isset($modificar)) {
	
	$estado = clear($estado);

	$link = conectarse();
	$query = "UPDATE compra SET estado = '$estado' WHERE id = '$id'";
	mysqli_query($link,$query);
	
	redir("?p=manejar_traking");

}

?>

<h2>Manejar Estado de Compra</h2>
<br>

<form method="post" action="">
	<div class="form-group">
	<select class="form-control" name="estado">
		<option <?php if($r['estado'] == 0) { echo "selected"; } ?> value="0">Iniciando</option>
		<option <?php if($r['estado'] == 1) { echo "selected"; } ?> value="1">Preparando</option>
		<option <?php if($r['estado'] == 2) { echo "selected"; } ?> value="2">Despachando</option>
		<option <?php if($r['estado'] == 3) { echo "selected"; } ?> value="3">Finalizado</option>
	</select>
	</div>

	<div class="form-group">
		<button type="submit" class="btn btn-success" name="modificar"><i class="fa fa-check"></i> Establecer estado</button>
	</div>
</form>