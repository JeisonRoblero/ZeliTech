<?php
check_admin();

if (isset($enviar)) {
	$categoria = clear($categoria);

	$link = Conectarse();
 	$sql = "SELECT * FROM categorias WHERE nombre_categoria = '$categoria'";
 	$s = mysqli_query($link, $sql);

 	if (mysqli_num_rows($s)>0) {
 		alert("Esta categoria ya se encuentra agregada a la base de datos",2,'');
 	}else{
 		$link = Conectarse();
	 	$sql = "INSERT INTO categorias (nombre_categoria) VALUES ('$categoria')";
	 	mysqli_query($link, $sql);
 		alert("Categoria agregada con éxito!",1,'');
 	}
}

if (isset($eliminar)) {
	$link = Conectarse();
	$sql = "DELETE FROM categorias WHERE id = '$eliminar'";
	mysqli_query($link, $sql);

	alert("Categoria eliminada con éxito!",1,'agregar_categoria');
}

?>

<center>
<h1><b>Agregar Categoria</b></h1>

<form method="post" action="">
	<div class="form-group">
		<input type="text" class="form-control" name="categoria" placeholder="Categoria"/>
	</div>

	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="enviar" value="Agregar categoria"/>
	</div>

</form>
</center>

<div class="table-responsive">
<table class="table table-striped">
	<tr>
		<th style="text-align:center">ID</th>
		<th style="text-align:center">Categoria</th>
		<th style="text-align:center">Acciones</th>
	</tr>

		<?php
		$link = Conectarse();
	 	$sql = "SELECT * FROM categorias ORDER BY nombre_categoria ASC";
	 	$q = mysqli_query($link, $sql);

	 	while ($r=mysqli_fetch_array($q)) {
	 		?>
	 			<tr>
	 				<td style="text-align:center"><?=$r['id']?></td>
	 				<td style="text-align:center"><?=$r['nombre_categoria']?></td>
	 				<td style="text-align:center">
	 					<a style="color: #08f;" href="?p=agregar_categoria&eliminar=<?=$r['id']?>"><i class="fa fa-times"></i></a>
	 				</td>
	 			</tr>
	 		<?php
	 	}

		?>
</table>
</div>