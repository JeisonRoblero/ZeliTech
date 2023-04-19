<?php
check_admin();

if(isset($enviar)){
	$name = clear($name);
	$price = clear($price);
	$descripcion = clear($descripcion);
	$oferta = clear($oferta);
	$categoria = clear($categoria);

	$imagen = clear($imagen);
	$video = clear($video);
	$descargable = "";

	if (is_uploaded_file($_FILES['descargable']['tmp_name'])) {
		$descargable = rand(0,1000).$_FILES['descargable']['name'];
		move_uploaded_file($_FILES['descargable']['tmp_name'], "../productos/digitales/".$descargable);
	}

	$link = Conectarse();
 	$sql = "INSERT INTO productos (name,price,imagen,video,descripcion,id_categoria,oferta,digital) VALUES ('$name','$price','$imagen','$video','$descripcion','$categoria','$oferta','$descargable')";
 	mysqli_query($link, $sql);

 
	alert("Producto Agregado Exitosamente!",1,'agregar_productos');
}

if (isset($eliminar)) {
	$link = Conectarse();
	$sql = "DELETE FROM productos WHERE id = '$eliminar'";
 	mysqli_query($link, $sql);

 	redir("?p=agregar_productos");
}

?>

<form method="post" action="" enctype="multipart/form-data">
	<center>
		<div class="subir" >
		<div class="titulo-ingreso">Ingreso de Producto</div><br>
		<div class="form-group">
			<input type="text" class="form-control" name="name" placeholder="Nombre del Producto"/>
		</div>
		
		<div class="form-group">
			<input type="text" class="form-control" name="price" placeholder="Precio del Producto"/>
		</div>

		<div class="form-group">
            <textarea class="form-control textarea" name="descripcion" placeholder="Descripción del Producto" rows="6"></textarea>
        </div>

		<!-- <div class="form-group">
			<label><b>Imagen del Producto:</b></label>
			<input type="file" required class="form-control" name="imagen" title="Imagen del Producto" placeholder="Imagen del Producto"/>
		</div> -->

		<div class="form-group">
		<label><b>Imagen del producto:</b></label>
			<input type="text" class="form-control" name="imagen" placeholder="Agrega el url de la imagen"/>
		</div>

		<div class="form-group">
			<label><b>Video del Producto (opcional):</b></label>
			<input type="text" class="form-control" name="video" placeholder="Agrega el link del video con embed. Ejemplo: https://www.youtube.com/embed/BvdrrLtUWs8"/>
		</div>

		<div class="form-group">
			
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
				 			<option value="<?=$r['id']?>"><?=$r['nombre_categoria']?></option>

				 		<?php
				 	}
				?>

			</select>

		</div>

		<div class="form-group">
			<select name="oferta" class="form-control">
				<option value="0">0% de Descuento</option>
				<option value="5">5% de Descuento</option>
				<option value="10">10% de Descuento</option>
				<option value="15">15% de Descuento</option>
				<option value="20">20% de Descuento</option>
				<option value="25">25% de Descuento</option>
				<option value="30">30% de Descuento</option>
				<option value="35">35% de Descuento</option>
				<option value="40">40% de Descuento</option>
				<option value="45">45% de Descuento</option>
				<option value="50">50% de Descuento</option>
				<option value="55">55% de Descuento</option>
				<option value="60">60% de Descuento</option>
				<option value="65">65% de Descuento</option>
				<option value="70">70% de Descuento</option>
				<option value="75">75% de Descuento</option>
				<option value="80">80% de Descuento</option>
				<option value="85">85% de Descuento</option>
				<option value="90">90% de Descuento</option>
				<option value="95">95% de Descuento</option>
				<option value="99">99% de Descuento</option>
			</select>
		</div>

		<div class="form-group">
			<label><b>Si es un producto digital como un libro pdf, archivo de software, etc... ingreselo en este campo:</b></label>
			<input class="form-control" type="file" name="descargable"/>
		</div>

		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-success" name="enviar"><i class="fa fa-check"></i> Agregar Producto</button>
		</div>
	</center>
</form>

<br><br>

<div class="table-responsive">
<table class="table table-striped admin-movil">
	<tr>
		<th style="text-align:center;"><i class="fa fa-image"></i></th>
		<th>Nombre</th>
		<th>Descripción</th>
		<th>Precio</th>
		<th>Descuento</th>
		<th>Precio/F</th>
		<th>Categoria</th>
		<th>Editar</th>
	</tr>

	<?php
		$link = Conectarse();
		$sql = "SELECT * FROM productos ORDER BY id DESC";
		$prod = mysqli_query($link, $sql);

		while ($rp=mysqli_fetch_array($prod)) {
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
				<tr>
					<td style="vertical-align:middle"><img src="<?=$rp['imagen']?>" class="imagen_carrito" style="width:70px;border-radius:1000px;"/></td>

					<td style="vertical-align:middle;max-width:50px;overflow: auto;"><?=$rp['name']?></td>

					<td style="vertical-align:middle;max-width:200px;overflow: auto;"><?=$rp['descripcion']?></td>

					<td style="vertical-align:middle;text-align:center"><?=$divisa?><?=number_format((float)$rp['price'],2,'.',',')?></td>

					<td style="vertical-align:middle;text-align:center">
						<?php
							if($rp['oferta']>0){
								echo $rp['oferta']."%";
							}else{
								echo "No aplica";
							}
						?>

					</td>

					<td style="vertical-align:middle;text-align:center"><?=$divisa?><?=number_format((float)$preciofinal,2,'.',',')?></td>

					<td style="vertical-align:middle;text-align:center"><?=$categoria?></td>
					<td style="vertical-align:middle;text-align:center">
						<a style="color: #08f" href="?p=modificar_producto&id=<?=$rp['id']?>"><i class="fa fa-edit"></i></a>
						&nbsp;
						<a style="color: #08f" href="?p=agregar_productos&eliminar=<?=$rp['id']?>"><i class="fa fa-times"></i></a>

					</td>

				</tr>

			<?php
		}

	?>

</table>
</div>