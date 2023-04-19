<head>
<title>ZeliTech | Login</title>
</head>
<body>
<section class="loginn">

<style>
	.login {
		background: rgb(0, 140, 255);
		color: black;
		text-decoration: none;
		margin-left: 5px;
	}

	@media screen and (max-width: 768px) {
		.login {
			margin-left: unset;
		}
	}

</style>

<?php

//Include Configuration File
/* include('config.php');

$login_button = "";

if(isset($_GET["code"])){
 	$token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

	if(!isset($token['error'])){
		$google_client->setAccessToken($token['access_token']);
		$_SESSION['access_token'] = $token['access_token'];
		$google_service = new Google_Service_Oauth2($google_client);
		$data = $google_service->userinfo->get();

		if(!empty($data['given_name'])){
			$_SESSION['user_first_name'] = $data['given_name'];
		}

		if(!empty($data['family_name'])){
			$_SESSION['user_last_name'] = $data['family_name'];
		}

		if(!empty($data['email'])){
			$_SESSION['user_email_address'] = $data['email'];
		}

		if(!empty($data['gender'])){
			$_SESSION['user_gender'] = $data['gender'];
		}

		if(!empty($data['picture'])){
			$_SESSION['user_image'] = $data['picture'];
		}

		$link = conectarse();
		$sql = "SELECT * FROM cliente WHERE username = '".$_SESSION['user_email_address']."'";
		$qg=mysqli_query($link, $sql);

		$rqg = mysqli_fetch_array($qg);

		if (mysqli_fetch_array($qg)==0) {
			$link = conectarse();
			$sql = "INSERT INTO cliente (name,last_name,username,fecha_registro,foto) VALUES ('".$_SESSION['user_first_name']."','".$_SESSION['user_last_name']."','".$_SESSION['user_email_address']."',NOW(),'".$_SESSION['user_image']."')";
			mysqli_query($link, $sql);
		}
		
	}

		$link = conectarse();
		$sql = "SELECT * FROM cliente WHERE username = '".$_SESSION['user_email_address']."'";
		$qg=mysqli_query($link, $sql);

		$rqg = mysqli_fetch_array($qg);
		$_SESSION['id_cliente'] = $rqg['id'];

		if (mysqli_fetch_array($qg)>=2){
			$link = conectarse();
			$sql = "DELETE FROM cliente WHERE username = '".$_SESSION['user_email_address']."' ORDER BY id DESC LIMIT 1";
			mysqli_query($link, $sql);
		}
}

if(!isset($_SESSION['access_token'])){
 	$login_button = "<a href='".$google_client->createAuthUrl()."' class='google-button'><img src='./images/google_icono.svg' alt='google logo'><div><span>Iniciar con Google</span></span></div></a>";
} */

//Ingresando como administrador
if(isset($enviar)){
	$username = clear($username);
	$password = clear($password); 

   $link = Conectarse();
 
   $query = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
 
   $q = mysqli_query($link, $query); 

	if(mysqli_num_rows($q)>0){
		$r = mysqli_fetch_array($q);
		$_SESSION['id'] = $r['id'];
		
		redir("?p=login");
	}else{
		alert("Los datos no son validos",0,'login');
	}
}

if (isset($_SESSION['id_cliente'])) {
	redir("./");
}

//Ingresando como cliente
if(isset($enviar1)){
	$username = clear($username);
	$password = clear($password); 

   $link = Conectarse();
   $query = "SELECT * FROM cliente WHERE username = '$username' AND password = '$password'";
   $q = mysqli_query($link, $query); 

	if(mysqli_num_rows($q)>0){
		$r = mysqli_fetch_array($q);

		$_SESSION['id_cliente'] = $r['id'];
		$_SESSION['user_first_name'] = $r['name'];
		$_SESSION['user_last_name'] = $r['last_name'];
		$_SESSION['user_email_address'] = $r['username'];

		if(!empty($r['sexo'])){
			$_SESSION['user_gender'] = $r['sexo'];
		}else {
			$_SESSION['user_gender'] = 'No definido';
		}

		if(!empty($r['foto'])){
			$_SESSION['user_image'] = $r['foto'];
		}

		if (isset($return)) {
			redir("?p=".$return);
		}else{
			redir("?p=bienvenida");
		}
	}else{
		alert("Los datos no son validos",0,'login');
	}
}

if(isset($_SESSION['id'])){

	redir("admin");

	?>


	<a href="?p=agregar_productos">
		<button class="btn btn-primary"><i class="fa fa-plus-circle"></i> Agregar Productos</button>
	</a>

	<a href="?p=agregar_categoria">
		<button class="btn btn-warning"><i class="fa fa-plus-circle"></i> Agregar Categoria</button>
	</a>

	<a href="?p=manejar_traking">
		<button class="btn btn-info"><i class="fa fa-plus-circle"></i> Monitorear Trakings</button>
	</a>

	<?php
}else{
	?>
		<center>
			<form class="center-form-1" method="post" action="">
				<br>
				<center><label style="color: #fff;"><h2><i class="fa fa-key"></i> Iniciar Sesión</h2></label></center>
				<br>
				<div class="form-group">
					<input type="email" required class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Correo" name="username">
				</div>

				<div class="form-group">
					<input type="password" required class="form-control tam-input" placeholder="Contraseña" name="password" style="margin-top: 10px;"/>
					<i><a href='./'>Olvidé mi contraseña <b>:(</b> </a></i>
				</div>
				<label style="margin-top: 20px;">Ingresar como:</label>
				<div class="form-group">
					<button class="btn btn-primary" name="enviar1" type="submit" style="margin-top: 20px;"><i class="fa fa-sign-in"></i>  CLIENTE</button>
				</div>

				<div class="form-group">
					<button class="btn btn-secundary" name="enviar" type="submit" style="background: #FF0000;margin-top:10px;"><i class="fa fa-sign-in"></i>  ADMINISTRADOR</button>
				</div>

				<div class="linea" style="margin-top: 10px;">
				_______o_______
				</div>

				<br>

				
				<a href='#' class='google-button'>
					<img src='./images/google_icono.svg' alt='google logo'>
					<div>
						<span>
							Iniciar con Google
						</span>
					</div>
				</a>


				<!-- <?=$login_button?>		 -->

			</form>

			<div>
				<br>
				<a href="?p=registrarse">
					<button class="btn btn-reg"><i class="fa fa-plus-circle"></i> Crear cuenta nueva</button>
				</a>
			</div>

			<br>

		</center>

	<?php
}
?>

<div class="fullscreen-container">
	<img src="images/fondo-login.jpg" alt="fondo" class="object fondo-login" data-value="2" style="margin-left: -90px; width: 150%">
</div>

<script type="text/javascript">
        document.addEventListener("mousemove", parallax)
        function parallax(e) {
            document.querySelectorAll(".object").forEach(function (move) {
                var moving_value = move.getAttribute("data-value");
                var x = (e.clientX * moving_value) / 250;
                var y = (e.clientY * moving_value) / 250;
                move.style.transform = "translateX(" + x + "px) translateY(" + y + "px)";
            });
        }
</script>

</section>
</body>