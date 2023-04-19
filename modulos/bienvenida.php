<head>
<title>ZeliTech | Bienvenida</title>
</head>
<body>
<section class="bienvenida">

<?php

include("principal.php")

?>


<script>
	window.addEventListener('load', () => {
		Swal.fire({
			title: '¡Bienvenido a ZeliTech!',
			text: 'Gracias por preferirnos 😀',
			imageUrl: 'https://unsplash.it/400/200',
			imageWidth: 400,
			imageHeight: 200,
			imageAlt: 'Imagen de Bienvenida',
            showConfirmButton: false,
            timerProgressBar: true,
			timer: 7000,
            backdrop: `
                rgba(0,0,123,0.4)
                left top
                no-repeat
            `,
		}).then((result) => {
		    if (result.dismiss === Swal.DismissReason.timer) {
						
		    }
		})
    });   
	


    setTimeout(function() {
        window.location = "./";
    },7000);

   
</script>

</section>
</body>