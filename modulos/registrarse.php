<head>
<title>ZeliTech | Sign up</title>
</head>
<body>
<section class="registrarsee">

<style>
	.register {
		background: green;
		color: black;
		text-decoration: none;
		margin-right: 5px;
	}

	@media screen and (max-width: 768px) {
		.register {
			margin-right: unset;
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

if (isset($_SESSION['id_cliente'])) {
	redir("./");
}

if (isset($enviar)) {
	$name = clear($name);
	$last_name = clear($last_name);
	$dia = clear($dia);
	$mes = clear($mes);
	$anio = clear($anio);
	$username = clear($username);
	$password = clear($password);
	$conf_password = clear($conf_password);

	$link = conectarse();
	$sql = "SELECT * FROM cliente WHERE username = '$username'";
	$q=mysqli_query($link, $sql);

	if (mysqli_fetch_array($q)>0) {
		alert("Ya existe un usuario con el mismo correo o nombre de usuario",0,'registrarse');
	}elseif ($dia<0 && $anio<0) {
		alert("Debe ingresar la fecha de nacimiento correctamente",0,'registrarse');
	}elseif($password<>$conf_password) {
		alert("Las contraseñas no coinciden!",0,'registrarse');
	}else{

		if (!empty($M) and empty($F)) {
			$link = conectarse();
			$sql = "INSERT INTO cliente (name,last_name,dia,mes,anio,username,password,fecha_registro,sexo) VALUES ('$name','$last_name','$dia','$mes','$anio','$username','$password',NOW(),'$M')";
			mysqli_query($link, $sql);

			$_SESSION['user_gender'] = $M;

		}elseif (!empty($F) and empty($M)) {
			$link = conectarse();
			$sql = "INSERT INTO cliente (name,last_name,dia,mes,anio,username,password,fecha_registro,sexo) VALUES ('$name','$last_name','$dia','$mes','$anio','$username','$password',NOW(),'$F')";
			mysqli_query($link, $sql);

			$_SESSION['user_gender'] = $F;
			
		}else{
			$link = conectarse();
			$sql = "INSERT INTO cliente (name,last_name,dia,mes,anio,username,password,fecha_registro) VALUES ('$name','$last_name','$dia','$mes','$anio','$username','$password',NOW())";
			mysqli_query($link, $sql);
		}

		$link = conectarse();
		$sql = "SELECT * FROM cliente WHERE username = '$username' AND password = '$password'";
		$ss = mysqli_query($link, $sql);

		$rss = mysqli_fetch_array($ss);

		$_SESSION['id_cliente'] = $rss['id'];
		$_SESSION['user_first_name'] = $rss['name'];
		$_SESSION['user_last_name'] = $rss['last_name'];
		$_SESSION['user_email_address'] = $rss['username'];

		//alert("Registro realizado con exito!",1,'principal');
		redir('?p=bienvenida');
	}

}

?>

<center>
	<form class="center-form-2" method="post" action="">
		<center><label><h2><i class="fa fa-key"></i> Registrar</h2></label></center>
		<div class="form-group">
			<label style="margin-top: 20px;"><b>¿Cómo te llamas?</b></label><br>
			<input type="text" required class="form" placeholder="Nombres" name="name" style="width:45%"/>
			<input type="text" required class="form" placeholder="Apellidos" name="last_name" style="width:45%"/>
		</div>
		<div class="form-group">
			<label style="margin-top: 20px;"><b>Fecha de nacimiento:</b></label><br>
			<input type="number" required class="form" placeholder="Día" name="dia" style="width: 25%" />
			<select name="mes" required class="form" style="width: 40%">
				<option value="">Mes</option>
				<option value="1">Enero</option>
				<option value="2">Febrero</option>
				<option value="3">Marzo</option>
				<option value="4">Abril</option>
				<option value="5">Mayo</option>
				<option value="6">Junio</option>
				<option value="7">Julio</option>
				<option value="8">Agosto</option>
				<option value="9">Septiembre</option>
				<option value="10">Octubre</option>
				<option value="11">Noviembre</option>
				<option value="12">Diciembre</option>
			</select>
			<input type="number" required class="form" placeholder="Año" name="anio" style="width: 25%"/>
		</div>
		<br>
		<div class="form-group" style="background: red; color:white; border-radius:20px; width:80%;">
			<label style="font-size:20px;margin-top:5px"><b>Sexo: </b></label>
			&nbsp; &nbsp; &nbsp;
			<label style="font-size:20px;margin-top:5px"><b>M</b></label> 
			<input type="checkbox" class="form" value="M" name="M" style="width: 10%;margin-top:5px"/> &nbsp;  &nbsp;
			<label style="font-size:20px;margin-top:5px"><b>F</b></label>
			<input type="checkbox" class="form" value="F" name="F" style="width: 10%;margin-top:5px"/>
		</div>

		<div class="form-group" style="margin-top: 20px;">
			<label><b>Correo electrónico:</b></label>
			<input type="email" required class="form2 form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="juanito@zeli.cf" name="username"/><br>
			<small id="emailHelp" class="form-text text-muted">Tu email está seguro, nunca lo compartiremos con nadie</small>
		</div>

		<div class="form-group" style="margin-top: 10px;">
			<label><b>Ingresa contraseña:</b></label>
			<input type="password" required class="form2" placeholder="contraseña" name="password"/>
		</div>
		<div class="form-group" style="margin-top: 10px;">
			<label><b>Confirma contraseña:</b></label>
			<input type="password" required class="form2" placeholder="confirmar contraseña" name="conf_password"/>
		</div>

		<div class="form-group" style="margin-top: 20px;">
			<button type="submit" class="btn btn-success" name="enviar"><i class="fa fa-check"></i> Registrarse</button>
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

		<!-- <?=$login_button?> -->

	</form>
</center>


<div class="fullscreen-container">
	<img src="images/fondo-signup.jpg" alt="fondo" class="object fondo-login" data-value="2" style="margin-left: -90px; width: 150%">	
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