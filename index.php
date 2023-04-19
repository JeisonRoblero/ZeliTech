<?php
include "configs/config.php";
include "configs/funciones.php";

if(!isset($p)){
	$p = "principal";
}else{
	$p = $p;
}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="css/estilos.css"/>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"/>
	<script src="https://kit.fontawesome.com/a3c0bc2905.js" crossorigin="anonymous"></script>
	
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width"/>
	
	<meta name="theme-color" content="#000000"/>
	<meta name="MobileOptimized" content="width">
	<meta name="HandheldFriendly" content="true">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<link rel="apple-touch-icon" href="images/icono/1.svg">
	<link rel="apple-touch-startup-image" href="images/icono/1.svg">
	<link rel="manifest" href="./manifest.json">

	<meta property="og:image" content="images/cart.png"/>
	<meta property="og:image:secure_url" content="https://zeli.cf/images/cart.png"/> 
	<meta property="og:image:width" content="1024" /> 
	<meta property="og:image:height" content="1024" />

	<meta property="og:site_name" content="ZeliTech"/>
	<meta property="og:title" content="ZeliTech"/>
	<meta property="og:description" content="ZeliTech tus mejores productos al alcance de un clic"/>
	<meta property="og:url" content="https://zeli.cf/"/>
	<meta property="og:type" content="Tienda"/>

	<meta name="description" content="ZeliTech tus mejores productos al alcance de un clic">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
	
	<!--Scroll Reveal-->
	<script src="https://unpkg.com/scrollreveal"></script>
	<script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>

	<style>
	    section + div {
	        visibility: hidden;
	    }
  	</style>
</head>
<body>
    

	<div class="header">

		<div class="burger">
	  		<div class="linea1"></div>
			<div class="linea2"></div>
			<div class="linea3"></div>
		</div>

		<a href="./"><img src="images/icono/1.svg" alt="Logo Zeli" style="width: 50px"> ZeliTech</a>

		<?php if (isset($_SESSION['id_cliente'])) { ?>

		<div class="foto">
		<?php if(isset($_SESSION['user_image'])){
			?>
			<a class="cliente" href="?p=perfil">
			<img src="<?=$_SESSION['user_image']?>" alt="Foto_perfil" class="foto_perfil_google">
			</a>
			<?php 
			}else{
			?>
				<a class="cliente-movil" href="?p=perfil">
				<img src="images/profile.png" width="30px" alt="😀">
				</a>
			<?php } }else{ ?>
				<a class="cliente-movil" href="?p=perfil">
				<lord-icon
					src="https://cdn.lordicon.com/dxjqoygy.json"
					trigger="loop"
					colors="primary:#ffffff,secondary:#ffffff"
					style="width:30px;height:30px;margin-bottom:-1px">
				</lord-icon></a>
			<?php } ?>
		</div>
		
	</div> 
	

	<div class="menu">
		<a href="./" class="a" data-page="principal">
			
		
		Inicio</a>

		<a href="?p=productos" class="a" data-page="productos">
			 
		
		Productos</a>	

		<a href="?p=ofertas" class="a" data-page="ofertas">
			
		Ofertas</a>

		<?php
			if (!isset($_SESSION['id']) AND !isset($_SESSION['id_cliente']) AND !isset($_GET['code'])) {
		?>	

			<a class="fa-pull-right up login" href="?p=login" data-page="login">Iniciar Sesión</a>
			<a class="fa-pull-right up register" href="?p=registrarse" data-page="signup">Registrate</a>

		<?php  
			}
		?>

		<?php
			if (isset($_SESSION['id'])) {
		?>	
			<a href="?p=login" class="admin-menu" style="background: red; color: white" data-page="administrar">
			
			

			Administrar</a>

			<a class="fa-pull-right up red" href="?p=salir">
			
			
			
			Salir</a>

			<a class="fa-pull-right up register administrador" href="?p=perfil" data-page="perfil">
			
			
			
			<?=nombre_admin($_SESSION['id'])?></a>
		<?php  
			}
		?>

		<?php
			if (isset($_SESSION['id_cliente'])) {
		?>	
			<a href="?p=carrito" class="a" data-page="carrito">
			
			
			
			Carrito</a>

			<a href="?p=miscompras" class="a" data-page="miscompras">
				
			
			
			Mis Compras</a>
			
			
			<?php if(isset($_SESSION['user_image'])){
			?>
			<a class="fa-pull-right up register cliente" href="?p=perfil" data-page="imagen">
			<img src="<?=$_SESSION['user_image']?>" alt="Foto_perfil" class="foto_perfil_google">
			<?=$_SESSION['user_first_name']?></a>
			<?php 
			}else{
			?>
				<style>
					.register {
						right:15px
					}

					@media screen and (max-width: 768px) {
						.register {
							right: unset;
						}
					}
				</style>
				<a class="fa-pull-right up register cliente" href="?p=perfil" data-page="perfil-cliente">
				
			
				<?=$_SESSION['user_first_name']?></a>
			<?php } ?>
			
			<a class="fa-pull-right up red salir" style="margin-right:15px" href="?p=salir">
			
			
			
			Salir</a>
		<?php  
			}
		?>

		<div class="activo"></div>

	</div>

	<!-- <div class="contenedor-loader">
		<div class="loader">
		<lord-icon
			src="https://cdn.lordicon.com/nxaaasqe.json"
			trigger="loop"
			colors="primary:#121331,secondary:#3080e8"
			style="width:75px;height:75px">
		</lord-icon>
		</div>
	</div> -->

	<script src="js/app.js"></script>
	<div class="cuerpo">
		<?php
			if(file_exists("modulos/".$p.".php")){
				include "modulos/".$p.".php";
			}else{
				echo "<i>Aún estamos trabajando en el modulo <b>".$p."</b>, lo tendremos pronto listo para tí ;) <a href='./'>Regresar</a></i>"; 
			}
		?>
	</div>

	<?php
	if (isset($_SESSION['id_cliente']) && !isset($_SESSION['id'])) {
		$id_cliente = clear($_SESSION['id_cliente']);

		$link = Conectarse();
		$query = "SELECT * FROM carrito WHERE id_cliente = '$id_cliente'";

		if ($result=mysqli_query($link,$query)) {
			$rowcount=mysqli_num_rows($result);
		}
	?>
	<a class="carrito_tituloo" href="?p=carrito">
		<i class="fa fa-shopping-cart"></i>
		<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="width:35px;height:35px;font-size:13px;display:flex;justify-content:center;align-items:center">
		<?= $rowcount ?>
			<span class="visually-hidden">unread messages</span>
		</span>
	</a>
	<?php
	}
	?>

	<!-- carrito flotante -->
	
	<!-- //<?php
	//if (isset($_SESSION['id_cliente']) && !isset($_SESSION['id'])) {
	//?>
	<div class="carrito_titulo" onclick="minimizar()">
		<i class="fa fa-shopping-cart"></i>
		<b>Carrito</b>
		<input type="hidden" id="minimizado" value="0"/>
	</div>

	<div class="carrito_body">
		// <?php
			/* if(file_exists("modulos/carrito.php")){
				include "modulos/carrito.php";
			}else{
				echo "<i>Aún estamos trabajando en el modulo <b> Carrito </b>, lo tendremos pronto listo para tí ;) <a href='./'>Regresar</a></i>"; 
			} */
		// ?>
	</div>

	//<?php
	//}
	//?> -->

	<!-- fin carrito flotante -->

	<div class="footer">
		

		<div class="container">
			<div class="row">
			<div class="col-lg-6 mb-5 mb-lg-0">
				<div class="row">
				<div class="col-md-12">
					<h3 class="footer-heading mb-4" style="text-align:left">Navegación</h3>
				</div>
				<div class="col-md-6 col-lg-4">
					<ul class="list-unstyled" style="text-align:left;">
					<li style="margin-top:15px"><a href="#">Vender online</a></li>
					<li style="margin-top:15px"><a href="#">Caracteristicas</a></li>
					<li style="margin-top:15px"><a href="?p=carrito">Carrito de compras</a></li>
					<li style="margin-top:15px"><a href="#">Afiliarte</a></li>
					</ul>
				</div>
				<div class="col-md-6 col-lg-4">
					<ul class="list-unstyled" style="text-align:left;">
					<li style="margin-top:15px"><a href="#">Comercio móvil</a></li>
					<li style="margin-top:15px"><a href="#">Dropshipping</a></li>
					<li style="margin-top:15px"><a href="#">Desarrollo web</a></li>
					</ul>
				</div>
				<div class="col-md-6 col-lg-4">
					<ul class="list-unstyled" style="text-align:left;">
					<li style="margin-top:15px"><a href="#">Puntos de venta</a></li>
					<li style="margin-top:15px"><a href="#">Hardware</a></li>
					<li style="margin-top:15px"><a href="#">Software</a></li>
					</ul>
				</div>
				</div>
			</div>
			<div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
				<h3 class="footer-heading mb-4" style="text-align:left">Promoción especial</h3>
				<a href="?p=ofertas" class="block-6" style="text-align:left">
				<img src="images/forza5.jpg" alt="Image placeholder" class="img-fluid rounded mb-4">
				<h3 class="font-weight-light  mb-0">Encuentra tus VideoJuegos Favoritos con un Descuento Especial</h3>
				<p>Promoción valida desde el 23 de enero &mdash; 30, 2022</p>
				</a>
			</div>
			<div class="col-md-6 col-lg-3">
				<div class="block-5 mb-5">
				<h3 class="footer-heading mb-4" style="text-align:left">Información de Contacto</h3>
				<ul class="list-unstyled" style="text-align:left">
					<li class="address">10011 Guatemala, Guatemala</li>
					<li class="phone"><a href="tel://50212457896">+502 1245 7896</a></li>
					<li class="email">contacto@zeli.cf</li>
				</ul>
				</div>

				<div class="block-7" style="text-align:left">
				<form action="#" method="post">
					<label for="email_subscribe" class="footer-heading">Suscribete</label>
					<div class="form-group">
					<input type="text" class="form-control py-1" id="email_subscribe" placeholder="Email"><br>
					<input type="submit" class="btn btn-sm btn-primary" value="Enviar">
					</div>
				</form>
				</div>
		</div>

		<div class="row pt-4 mt-4 text-center">
          <div class="col-md-12">
            <p>Copyright &copy;
            <script>document.write(new Date().getFullYear());</script> All rights reserved | 
            Wilian Roblero | ZeliTech <i class="fas fa-heart"></i></p>
          </div>
          
        </div>
		
		
	</div>
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

	<!-- para version movil -->
	<script src="./script.js"></script>

	<!-- iconos movibles -->
	<script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>

	<!-- bootstrap 4 -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	
	<!-- sweetalert -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<!-- fancy CDN para galerias -->
	<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>

	<!-- jquery -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	
	<!--Scroll Reveal-->
	<script src="https://unpkg.com/scrollreveal"></script>
	<script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>
	
	

	<div id="ultimo">
	    
	</div>
</body>
</html>


<script type="text/javascript">
	function minimizar(){
		var minimizado = $("#minimizado").val();

		if (minimizado==0) {
			//mostrar
			$(".carrito_titulo").css("bottom","470px");
			$(".carrito_titulo").css("right","960px");
			$(".chat_titulo").css("z-index","-1");
			$(".carrito_titulo").css("animation-name","left-up");
			$(".carrito_body").css("bottom","0px");
			$(".carrito_body").css("right","0px");
			$(".carrito_body").css("animation-name","slidein-up");
			$("#minimizado").val('1');
		}else{
			//minimizar
			$(".carrito_titulo").css("bottom","24px");
			$(".carrito_titulo").css("right","105px");
			$(".chat_titulo").css("z-index","0");
			$(".carrito_titulo").css("animation-name","right-down");
			$(".carrito_body").css("bottom","-500px");
			$(".carrito_body").css("right","-1000px");
			$(".carrito_body").css("animation-name","slidein-down");
			$("#minimizado").val('0');
		}
	}
</script>

