<head>
<title>ZeliTech | Productos</title>
</head>
<body>
	
<section data-index="1" class="productoss">

<style>
	.a:nth-child(2) {
		background: white;
		color: black;
		text-decoration: none;
	}
</style>

<?php

if (isset($idpp)) {
	global $idpp;
}

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

	alert("Se ha agregado al carro de compras",1,'productos');

}



if(isset($comprar) && isset($cant)){

	check_user("productos");

	//Si es un administrador
	if (isset($_SESSION['id'])) {
		alert("Para agregar articulos al carrito debe iniciar sesión como cliente",2,'productos');
	}

	$idp = clear($comprar);
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

	redir('?p=factura');

}




if (!empty($busqueda) && !empty($cat)) {
	$link = Conectarse();
	$query = "SELECT * FROM productos WHERE name like '%$busqueda%' OR descripcion like '%$busqueda%' AND id_categoria = '$cat' ";
	$q = mysqli_query($link, $query);
}elseif(!empty($cat) && empty($busqueda)){
	$link = Conectarse();
	$query = "SELECT * FROM productos WHERE id_categoria = '$cat' ORDER BY id DESC";
	$q = mysqli_query($link, $query);
}elseif (!empty($busqueda) && empty($cat)) {
	$link = Conectarse();
	$query = "SELECT * FROM productos WHERE name like '%$busqueda%' OR descripcion like '%$busqueda%'";
	$q = mysqli_query($link, $query);
}elseif (empty($busqueda) && empty($cat)) {
	$link = Conectarse();
	$query = "SELECT * FROM productos ORDER BY id DESC";
	$q = mysqli_query($link, $query);
}else{
	$link = Conectarse();
	$query = "SELECT * FROM productos ORDER BY id DESC";
	$q = mysqli_query($link, $query);
}

?>

<form class="buscador" method="post" action="">
	<div class="" style="display:flex;">
		<div class="">
			<div class="">

			<div class="busqueda">
				<img src="images/lupa.png" alt="🔎" class="lupa">

				<input type="search" class="form-control buscar" name="busqueda" id="texto" list="datalistOptions" id="exampleDataList" placeholder="Buscar..."
					style="border-radius: 10px; border: none;">
				<datalist id="datalistOptions">
					<option value="ZeliTech">
					<option value="Videojuegos">
					<option value="Codigos">
					<option value="Windows activación">
					<option value="Acerca de">
				</datalist>
			</div>

			</div>
		</div>

		<div class="">
			<div class="cat">
				<select id="categoria" name="cat" class="form-control">
					<option value="">Categorias</option>
					<?php
						$link = Conectarse();
						$query = "SELECT * FROM categorias ORDER BY nombre_categoria ASC";
						$cats = mysqli_query($link, $query);

						while ($rcat = mysqli_fetch_array($cats)) {
							?>
								<option value="<?=$rcat['id']?>"><?=$rcat['nombre_categoria']?></option>
							<?php
						}

					?>
				</select>
			</div>
		</div>

		<div class="">
			<button type="submit" class="btn btn-primary buscar-boton" id="buscar" name="buscar"><i class="fa fa-search"></i></button>
		</div>
		
	
	</div>
</form>


<?php

if (!empty($cat)) {
	$link = Conectarse();
	$query = "SELECT * FROM categorias WHERE id = '$cat'";
	$sc = mysqli_query($link, $query);
	$rc = mysqli_fetch_array($sc);
	?>
	<h2>Productos filtrados por: <?=$rc['nombre_categoria']?></h2>
	<?php
}

if (mysqli_num_rows($q)>0) {
while($r=mysqli_fetch_array($q)){
	$preciofinal = 0;

	if($r['oferta']>0){
				if (strlen($r['oferta'])==1) {
					$desc = "0.0".$r['oferta'];
				}else{
					$desc = "0.".$r['oferta'];
				}

				$preciofinal = $r['price'] - ($r['price'] * $desc);
				
			}else{
				$preciofinal = $r['price'];
			}


	?>

		<div class="producto">
			<div class="name_producto" onclick="ver('<?=$r['id']?>')"><?=$r['name']?></div>
			<a>
			<div class="contenedorimgpro"><img class="img_producto" src="<?=$r['imagen']?>" onclick="ver('<?=$r['id']?>')"/></div>
			</a>
			<?php
				if ($r['oferta']>0) {
					?>
					<del class="precio-ofer"><br><?=$divisa?><?=number_format((float)$r['price'],2,'.',',')?></del><span class="precio"><?=$divisa?><?=number_format((float)$preciofinal,2,'.',',')?></span>
					<?php
				}else{
					?>
						<span class="precio"><br><?=$divisa?><?=number_format((float)$r['price'],2,'.',',')?></span>
					<?php
				}
			?>

			<button class="btn btn-warning fa-pull-right carrito" onclick="agregar_carro('<?=$r['id']?>')"><i class="carrito2 fa fa-shopping-cart"></i></button>
		</div>

	<?php
}

}else{
	?>
	<script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>
	<br><br><br><br><center>
	<lord-icon
		src="https://cdn.lordicon.com/msoeawqm.json"
		trigger="loop"
		colors="primary:#ffffff,secondary:#08a88a"
		style="width:80px;height:80px">
	</lord-icon>
	<br>
	<i style="font-size:20px">Lo sentimos no hemos encontrado ninguna coincidencia</i>
	</center>
	<?php
}
?>









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
			window.location = "?p=productos&agregar="+idp+"&cant="+cant;
		}else{
			alert("Ingrese algo al carrito",2,'productos');
		}
	}

	function ver(idp){
		window.location="?p=descripcion_producto&idpp="+idp;
	}

</script>

</section>
</body>