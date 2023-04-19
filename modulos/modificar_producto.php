<?php
check_admin();

$id = clear($id);

$link = Conectarse();
$sql = "SELECT * FROM productos WHERE id = '$id'";
$q = mysqli_query($link, $sql);

$rq = mysqli_fetch_array($q);

if (isset($enviar)) {
	$idpro = clear($idpro);
	$name = clear($name);
	$price = clear($price);
	$descripcion = clear($descripcion);
	$categoria = clear($categoria);
	$oferta = clear($oferta);

	$imagen = clear($imagen);
	$video = clear($video);
	$descargable = "";

	if (is_uploaded_file($_FILES['descargable']['tmp_name'])) {
		$descargable = rand(0,1000).$_FILES['descargable']['name'];
		move_uploaded_file($_FILES['descargable']['tmp_name'], "../productos/digitales/".$descargable);
	}


	$link = Conectarse();
	$sql = "UPDATE productos SET name = '$name',price = '$price',descripcion = '$descripcion',id_categoria = '$categoria',oferta = '$oferta', imagen = '$imagen', video = '$video'  WHERE id = '$idpro'";
	mysqli_query($link, $sql);

	if (!empty($descargable)) {
		$link = Conectarse();
		$sql = "UPDATE productos SET digital = '$descargable' WHERE id = '$idpro'";
		mysqli_query($link, $sql);
	}

	redir("?p=agregar_productos");

}

?>

<form method="post" action="" enctype="multipart/form-data">
	<center>
		<div class="subir" >
		<div class="titulo-ingreso">Modificación de Producto</div>
		<div class="form-group">
			<input type="text" class="form-control" name="name" value="<?=$rq['name']?>" placeholder="Nombre del Producto"/>
		</div>
		
		<div class="form-group">
			<input type="text" class="form-control" name="price" value="<?=$rq['price']?>" placeholder="Precio del Producto"/>
		</div>

		<div class="form-group">
            <textarea class="form-control textarea" name="descripcion" placeholder="Descripción del Producto" rows="6">
			<?=$rq['descripcion']?></textarea>
		</div>

		<div class="form-group">
		<label><b>Imagen del producto:</b></label>
			<input type="text" class="form-control" name="imagen" value="<?=$rq['imagen']?>" placeholder="Agrega el url de la imagen"/>
		</div>

		<div class="form-group">
			<label><b>Video del Producto (opcional):</b></label>
			<input type="text" class="form-control" name="video" value="<?=$rq['video']?>" placeholder="Agrega el link del video con embed. Ejemplo: https://www.youtube.com/embed/BvdrrLtUWs8"/>
		</div>

		<div class="form-group">
			
			<select name="categoria" required class="form-control">
				<option value="">Seleccione una categoria</option> 

				<?php
					$link = Conectarse();
				 	$sql = "SELECT * FROM categorias ORDER BY nombre_categoria ASC";
				 	$q = mysqli_query($link, $sql);

				 	while ($r=mysqli_fetch_array($q)) {
				 		?>
				 			<option <?php if($rq['id_categoria'] == $r['id']){ echo "selected"; }  ?> value="<?=$r['id']?>"><?=$r['nombre_categoria']?></option>

				 		<?php
				 	}
				?>

			</select>

		</div>

		<div class="form-group">
			<select name="oferta" class="form-control">
				<option <?php if($rq['oferta'] == 0){ echo "selected"; } ?> value="0">0% de Descuento</option>
				<option <?php if($rq['oferta'] == 5){ echo "selected"; } ?> value="5">5% de Descuento</option>
				<option <?php if($rq['oferta'] == 10){ echo "selected"; } ?> value="10">10% de Descuento</option>
				<option <?php if($rq['oferta'] == 15){ echo "selected"; } ?> value="15">15% de Descuento</option>
				<option <?php if($rq['oferta'] == 20){ echo "selected"; } ?> value="20">20% de Descuento</option>
				<option <?php if($rq['oferta'] == 25){ echo "selected"; } ?> value="25">25% de Descuento</option>
				<option <?php if($rq['oferta'] == 30){ echo "selected"; } ?> value="30">30% de Descuento</option>
				<option <?php if($rq['oferta'] == 35){ echo "selected"; } ?> value="35">35% de Descuento</option>
				<option <?php if($rq['oferta'] == 40){ echo "selected"; } ?> value="40">40% de Descuento</option>
				<option <?php if($rq['oferta'] == 45){ echo "selected"; } ?> value="45">45% de Descuento</option>
				<option <?php if($rq['oferta'] == 50){ echo "selected"; } ?> value="50">50% de Descuento</option>
				<option <?php if($rq['oferta'] == 55){ echo "selected"; } ?> value="55">55% de Descuento</option>
				<option <?php if($rq['oferta'] == 60){ echo "selected"; } ?> value="60">60% de Descuento</option>
				<option <?php if($rq['oferta'] == 65){ echo "selected"; } ?> value="65">65% de Descuento</option>
				<option <?php if($rq['oferta'] == 70){ echo "selected"; } ?> value="70">70% de Descuento</option>
				<option <?php if($rq['oferta'] == 75){ echo "selected"; } ?> value="75">75% de Descuento</option>
				<option <?php if($rq['oferta'] == 80){ echo "selected"; } ?> value="80">80% de Descuento</option>
				<option <?php if($rq['oferta'] == 85){ echo "selected"; } ?> value="85">85% de Descuento</option>
				<option <?php if($rq['oferta'] == 90){ echo "selected"; } ?> value="90">90% de Descuento</option>
				<option <?php if($rq['oferta'] == 95){ echo "selected"; } ?> value="95">95% de Descuento</option>
				<option <?php if($rq['oferta'] == 99){ echo "selected"; } ?> value="99">99% de Descuento</option>
			</select>
		</div>

		<div class="form-group">
			<label><b>Si es un producto digital ingreselo en este campo:</b></label>
			<input class="form-control" type="file" name="descargable"/>
		</div>

		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-success" name="enviar"><i class="fa fa-check"></i> Modificar Producto</button>
		</div>

		<input type="hidden" name="idpro" value="<?=$id?>"/>
	</center>
</form>