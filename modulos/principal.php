<head>
<title>Zeli | Home</title>
</head>
<body>

<section data-index="0" class="principall">

<style>
	.a:nth-child(1) {
		background: white;
		color: black;
		text-decoration: none;
	}
</style>

<div class="loader">

    <img src="images/cargando.gif" alt="Loader">
</div>


<?php
$link = Conectarse();
$query = "SELECT * FROM productos WHERE oferta > 0 ORDER BY id DESC LIMIT 4";
$q = mysqli_query($link, $query);

?>

<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
	<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
	<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4" aria-label="Slide 5"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
		<a href="?p=ofertas">
      <img src="images/black.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Ofertas de Black Friday</h5>
        <p>Conoce nuestros productos a precios irresistibles</p>
      </div>
	  </a>
    </div>

	<?php
	while($r=mysqli_fetch_array($q)){
	?> 

    <div class="carousel-item" style="max-height:50vh">
		<a href="#" onclick="ver('<?=$r['id']?>')">
      <img src="<?=$r['imagen']?>" class="d-block w-100" alt="..." onclick="ver('<?=$r['id']?>')">
      <div class="carousel-caption d-md-block color-fondo">
        <h5><?=$r['name']?></h5>
        <p>Llévatelo con un <b style="font-size: 20px;"><?=$r['oferta']?>%</b> de descuento...!</p>
      </div>
	  </a>
    </div>
	
	<?php
	}
	?>

  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<?php

	if (isset($_SESSION['id']) AND !isset($_SESSION['id_cliente'])) {
		$nombre = nombre_admin($_SESSION['id']);
		$link = conectarse();
		$query = "SELECT * FROM admin WHERE name = '$nombre'";
		$s = mysqli_query($link,$query);
		$r = mysqli_fetch_array($s);
		if ($r['sexo']=="F") {
			?>	
			<h4 class="admina2">Bienvenida <b><?=nombre_admin($_SESSION['id'])?></b>!! <br> Aquí encontrará los mejores productos</h4>
		<?php  
			}else{
		?>
			<h4 class="admin2">Bienvenido <b><?=nombre_admin($_SESSION['id'])?></b>!! <br> Aquí encontrará los mejores productos</h4>
		<?php
		}
	}
?>

<?php

	if (!isset($_SESSION['id']) AND isset($_SESSION['id_cliente'])) {
		$nombre_cliente = nombre_cliente($_SESSION['id_cliente']);
		$link = conectarse();
		$query = "SELECT * FROM cliente WHERE name = '$nombre_cliente' ";
		$s = mysqli_query($link,$query);
		$r = mysqli_fetch_array($s);
		if ($r['sexo']=="F") {
			?>	
			<h4 class="clienta2">Bienvenida <b><?=nombre_cliente($_SESSION['id_cliente'])?></b>!! <br> Aquí encontrará los mejores productos</h4>
		<?php  
			}else{
		?>
			<h4 class="cliente2">Bienvenid@ <b><?=nombre_cliente($_SESSION['id_cliente'])?></b>!! <br> Aquí encontrará los mejores productos</h4>
		<?php
		}
	}
?>

<?php
	if (!isset($_SESSION['id']) AND !isset($_SESSION['id_cliente'])) {
?>	
	<h4 class="invitado">Bienvenid@ <br> Aquí encontrará los mejores productos</h4>
<?php  
	}
?>

<br><br>

<?php

if(isset($agregar) && isset($cant)){

	check_user("productos");

	//Si es un administrador
	if (isset($_SESSION['id'])) {
		alert("Para agregar articulos al carrito debe iniciar sesión como cliente",2,'principal');
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

	alert("Se ha agregado al carro de compras",1,'principal');

}
?>

<h2 style="color:white">Ultimos 5 Productos Agregados</h2><br>
<?php
$link = Conectarse();
$query = "SELECT * FROM productos WHERE oferta = 0 ORDER BY id DESC LIMIT 5";
$q = mysqli_query($link, $query);

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
			<div><img class="img_producto" src="<?=$r['imagen']?>" onclick="ver('<?=$r['id']?>')"/></div>
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
?>

<br><br><br>
<h2 style="color:white">Ultimas 5 Ofertas Agregadas</h2><br>
<?php
$link = Conectarse();
$query = "SELECT * FROM productos WHERE oferta>0 ORDER BY id DESC LIMIT 5";
$q = mysqli_query($link, $query);

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
			<a href="#">
			<div><img class="img_producto" src="<?=$r['imagen']?>" onclick="ver('<?=$r['id']?>')"/></div>
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
			window.location = "?p=principal&agregar="+idp+"&cant="+cant;
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


