<head>
<title><?=$_SESSION['user_first_name']?> | ZeliTech</title>
</head>
<body>
<section data-index="5" class="perfill">

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
check_user("login");
?>

<div class="perfil">

<div class="titulo">Perfil</div><br>

<?php if(isset($_SESSION['user_image'])){ ?>
	<a href="?p=perfil"><img src="<?=$_SESSION['user_image']?>" alt="Foto_perfil" class="foto_perfil_google_grande"></a></td>
<?php }else{ ?>

<script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>
<lord-icon
    src="https://cdn.lordicon.com/dxjqoygy.json"
    trigger="loop"
    colors="primary:#121331,secondary:#08a88a"
    style="width:250px;height:250px;">
</lord-icon>
<?php } ?>


<div class="contenido">
	<center>
<?php
			if (isset($_SESSION['id'])) {
		?>	
			<a href="?p=login" style="background: red" >Administrar</a>
			<a class="register administrador" href="?p=perfil"><?=nombre_admin($_SESSION['id'])?></a>
            <a class="red salir" href="?p=salir">Cerrar Sesión</a>
		<?php  
			}
		?>

		<?php
			if (isset($_SESSION['id_cliente'])) {
				$id_cliente = $_SESSION['id_cliente'];
				$link = Conectarse();
				$query = "SELECT * FROM cliente WHERE id = '$id_cliente'";
				$q = mysqli_query($link, $query);

				$r = mysqli_fetch_array($q);
				
		?>	
            <table>
				
				<tr>
					<td class="atributo-perfil">Nombre: </td>
					<td><a class="name" href="?p=perfil"><?=$_SESSION['user_first_name']?></a></td>
				</tr>

				<tr>
					<td class="atributo-perfil">Apellido: </td>
					<td><a class="name" href="?p=perfil"><?=$_SESSION['user_last_name']?></a></td>
				</tr>

				<tr>
					<td class="atributo-perfil">Correo Electrónico: </td>
					<td><a class="name" href="?p=perfil"><?=$_SESSION['user_email_address']?></a></td>
				</tr>

				<tr>
					<td class="atributo-perfil">Sexo: </td>
					<?php
						if(!empty($r['sexo'])){
					?>	
						<td><a class="name" href="?p=perfil"><?=$r['sexo']?></a></td>
					<?php  
						} else {
					?>
						<td><a class="name" href="?p=perfil">No definido</a></td>
					<?php  
						}
					?>
				</tr>
            </table>
			</div>
			<br>
			<strong><a class="cerrar1" href="?p=salir">Cerrar Sesión</a></strong>
			<br>

		<?php  
			}
		?>
	</center>
</div>

</section>
</body>