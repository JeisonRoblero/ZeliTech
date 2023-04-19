<head>
<title>Checkout | ZeliTech </title>
</head>
<body>
<section data-index="6" class="checkout">

<style>
	.a:nth-child(4) {
		background: white;
		color: black;
		text-decoration: none;
	}
</style>

<script src="https://www.paypal.com/sdk/js?client-id=ASAhlTIhrTxTveLDQMVpNmg1hFYodWUtSGj308uBuEww5FMBpGaK_5Lev1sonXjAR6fqtIdJRbTsbM5q&currency=USD"></script>

<?php

if(!isset($_SERVER['HTTP_REFERER'])){
  // redirect them to your desired location
  redir('./');
  exit;
}

check_user("checkout");

if (isset($eliminar)) {
	$link = Conectarse();
	$sql = "DELETE FROM carrito WHERE id = '$eliminar'";
 	mysqli_query($link, $sql);

 	redir("?p=checkout");
}

if (isset($id) && isset($modificar)) {
	$id = clear($id);
	$modificar = clear($modificar);

	$link = Conectarse();
	$sql = "UPDATE carrito SET cant = '$modificar' WHERE id = '$id'";
 	mysqli_query($link, $sql);

 	redir("?p=checkout");

}

if (isset($finalizar) && $monto_total<=0) {
	alert("Debe agregar algo al carrito",2,'carrito');
	die();
}

function finalizarPedido(){

  if($monto_total<=0){
    alert("Debe agregar algo al carrito, para procesar la compra",2,'carrito');
	  die();
  }else{

    $monto = clear($monto_total);

    $id_cliente = clear($_SESSION['id_cliente']);

    $link = Conectarse();
    $query = "INSERT INTO compra (id_cliente,fecha,monto,estado) VALUES ('$id_cliente',NOW(),'$monto',0)";
    $q = mysqli_query($link, $query);

    $link = Conectarse();
    $query = "SELECT * FROM compra WHERE id_cliente = '$id_cliente' ORDER BY id DESC LIMIT 1";
    $sc = mysqli_query($link, $query);

    $rc = mysqli_fetch_array($sc);

    $ultima_compra = $rc['id'];

    $link = Conectarse();
    $query = "SELECT * FROM carrito WHERE id_cliente = '$id_cliente'";
    $q2 = mysqli_query($link, $query);

    while ($r2=mysqli_fetch_array($q2)) {

      $link = Conectarse();
      $query = "SELECT * FROM productos WHERE id = '".$r2['id_producto']."'";
      $sp = mysqli_query($link, $query);

      $rp = mysqli_fetch_array($sp);

      $monto = $rp['price'];
          
      $link = Conectarse();
      $query = "INSERT INTO productos_compra (id_compra,id_producto,cantidad,monto) VALUES ('$ultima_compra','".$r2['id_producto']."','".$r2['cant']."','$monto')";
      mysqli_query($link, $query);

    }

    $link = Conectarse();
    $query = "DELETE FROM carrito WHERE id_cliente = '$id_cliente'";
    mysqli_query($link, $query);
  }
}

?>

  
  <div class="site-wrap">

    <div class="site-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-12">
            <div class="border p-4 rounded" role="alert">
            ¿Soy cliente mayorista? <a href="#modalcliente" style="color:blue" data-bs-toggle="modal" data-bs-target="#exampleModal">Haga clic aquí</a> para ingresar
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">CLIENTE MAYORISTA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    Lo sentimos, aún no es cliente mayorista, solicite su cuenta mayorista al correo: <a href="https://mail.google.com/mail/u/0/#inbox?compose=new" target="_blank" style="color:blue"><b>contacto@zeli.cf</b></a>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entiendo</button>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>


        <?php 
    
        $link = conectarse();
        $sql = "SELECT * FROM cliente WHERE username = '".$_SESSION['user_email_address']."'";
        $q=mysqli_query($link, $sql);
        $r = mysqli_fetch_array($q);
        
        ?>

        <div class="row">
          <div class="col-md-6 mb-5 mb-md-0">
            <h2 class="h3 mb-3 text-white">Detalles de facturación</h2>
            <form method="POST" class="p-3 p-lg-5 border">
              <div class="form-group">
                <label for="c_country" class="text-white">País <span class="text-danger">*</span></label>
                <select id="c_country" class="form-control" name="pais">  
                  <option value="<?=$r['pais']?>" selected disabled hidden><?=$r['pais']?></option>
                  <option value="Guatemala">Guatemala</option>  
                  <option value="México">México</option>    
                  <option value="Estados Unidos">Estados Unidos</option>    
                  <option value="El Salvador">El Salvador</option>    
                  <option value="Nicaragua">Nicaragua</option>  
                  <option value="Honduras">Honduras</option>    
                  <option value="Costa Rica">Costa Rica</option>    
                  <option value="Colombia">Colombia</option>    
                  <option value="República Dominicana">República Dominicana</option>    
                </select>
              </div>
              <div class="form-group row" style="margin-top:10px" >
                <div class="col-md-6">
                  <label for="c_fname" class="text-white">Nombre <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="c_fname" name="c_fname" value="<?=$r['name']?>">
                </div>
                <div class="col-md-6">
                  <label for="c_lname" class="text-white">Apellido <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="c_lname" name="c_lname" value="<?=$r['last_name']?>">
                </div>
              </div>

              <div class="form-group row" style="margin-top:10px">
                <div class="col-md-12">
                  <label for="c_address" class="text-white">Dirección <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="c_address" name="c_address" placeholder="Dirección" value="<?=$r['direccion1']?>">
                </div>
              </div>

              <div class="form-group" style="margin-top:10px">
                <input type="text" class="form-control" name="c_address2" placeholder="Más detalles de la dirección (opcional)" value="<?=$r['direccion2']?>">
              </div>

              <div class="form-group row" style="margin-top:10px">
                <div class="col-md-6">
                  <label for="c_state_country" class="text-white">Estado / Departamento <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="c_state_country" name="c_state_country" value="<?=$r['departamento']?>">
                </div>
                <div class="col-md-6">
                  <label for="c_postal_zip" class="text-white">Código Postal <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="c_postal_zip" name="c_postal_zip" value="<?=$r['codigo_postal']?>">
                </div>
              </div>

              <div class="form-group row mb-5" style="margin-top:10px">
                <div class="col-md-6">
                  <label for="c_email_address" class="text-white">Correo Eléctronico <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="c_email_address" name="c_email_address" value="<?=$r['username']?>">
                </div>
                <div class="col-md-6">
                  <label for="c_phone" class="text-white">Teléfono <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="c_phone" name="c_phone" placeholder="Número de teléfono" value="<?=$r['telefono']?>">
                </div>
              </div>

              <div class="form-group">
                <label for="c_create_account" class="text-white" data-toggle="collapse" href="#create_an_account" role="button" aria-expanded="false" aria-controls="create_an_account"><input type="checkbox" checked value="1" id="c_create_account" name="guardar"> ¿Guardar esta información en mi cuenta?</label>
                <div class="collapse" id="create_an_account">
                  <div class="py-2">
                    <p class="mb-3">Guarde esta información como su dirección, estado/departamento, teléfono en su cuenta para que en próximas compras le sea mucho más fácil realizar sus pedidos.</p>
                  </div>
                </div>
              </div>

              <div class="form-group" style="margin-top:10px">
                <label for="c_order_notes" class="text-white">Notas del pedido</label>
                <textarea name="c_order_notes" id="c_order_notes" cols="30" rows="5" class="form-control" placeholder="Puedes escribir algunas notas del pedido aquí..."><?=$_SESSION['notas']?></textarea>
              </div>

            </form>
          </div>
          <div class="col-md-6" id="pay">

            <div class="row mb-5">
              <div class="col-md-12">
                <h2 class="h3 mb-3 text-white">Código promocional</h2>
                <div class="p-3 p-lg-5 border">
                  
                  <label for="c_code" class="text-white mb-3">Ingrese su código de cupón si tiene uno</label>
                  <div class="input-group w-75">
                    <input type="text" class="form-control" id="c_code" placeholder="Código de promoción" aria-label="Coupon Code" aria-describedby="button-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary btn-sm" style="height:40px" type="button" id="button-addon2">Aplicar</button>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            
            <div class="row mb-5" style="overflow:hidden" id="orden">
              <div class="col-md-12">
                <h2 class="h3 mb-3 text-white">Su orden</h2>
                <div class="p-3 p-lg-5 border">
                  <table class="table site-block-order-table mb-5">
                    <thead>
                      <th>Cant</th>
                      <th>Productos</th>
                      <th>Total</th>
                      <th></th>
                    </thead>
                    <tbody>
                      

                      <?php
                        $id_cliente = clear($_SESSION['id_cliente']);

                        $link = Conectarse();
                        $query = "SELECT * FROM carrito WHERE id_cliente = '$id_cliente'";
                        $q = mysqli_query($link, $query);

                        $monto_total = 0;

                        while ($r = mysqli_fetch_array($q)) {

                          $link = Conectarse();
                          $query = "SELECT * FROM productos WHERE id = '".$r['id_producto']."'"; 
                          $q2 = mysqli_query($link, $query);

                          $r2 = mysqli_fetch_array($q2);

                          $preciofinal = 0;

                          if($r2['oferta']>0){
                                if (strlen($r2['oferta'])==1) {
                                  $desc = "0.0".$r2['oferta'];
                                }else{
                                  $desc = "0.".$r2['oferta'];
                                }

                                $preciofinal = $r2['price'] - ($r2['price'] * $desc);
                                
                              }else{
                                $preciofinal = $r2['price'];
                              }

                          $nombre_producto = $r2['name'];

                          $cantidad = $r['cant'];

                          $precio_unidad = $r2['price'];

                          $precio_total = $cantidad * $preciofinal;

                          $monto_total = $monto_total + $precio_total;


                          ?>
                            <tr>
                              <td style="width:30px;text-align:center"><?=$cantidad?></td>
                              <td><?=$nombre_producto?></td>
                              <td><?=$divisa?><?=number_format((float)$precio_total,2,'.',',')?></td>

                              <td>
                                <a onclick="modificar('<?=$r['id']?>')" href="#" style="color:blue"><i class="fa fa-edit" title="Modificar cantidad en carrito"></i></a>
                              
                                <a href="?p=checkout&eliminar=<?=$r['id']?>" style="color:red"><i class="fa fa-times" title="Eliminar del carrito"></i></a>
                              </td>

                            </tr>
                          <?php
                        }

                        //Para el pago en dólares
                        $monto_a_dolares = $monto_total*0.13;

                        $monto_dolar = round($monto_a_dolares, 2);

                      ?>
                      </tbody>
                      <br>
                      
                      <table class="table site-block-order-table mb-5">
                      <tbody>
                      <tr>
                        <td class="text-white font-weight-bold"><strong>Subtotal del carrito</strong></td>
                        <td class="text-white"><?=$divisa?><?=number_format((float)$monto_total,2,'.',',')?></td>

                      </tr>
                      <tr>
                        <td class="text-white font-weight-bold"><strong>Total de orden</strong></td>
                        <td class="text-white font-weight-bold"><strong><?=$divisa?><?=number_format((float)$monto_total,2,'.',',')?></strong></td>
                      </tr>
                      </tbody>
                      
                  </table>
                  <div align='center'><span>Equivalente a: <b style="color:green">$<?= number_format((float)$monto_dolar,2,'.',',') ?> USD</b></span><br><br></div>
                  
                  <h3>Escoge un método de pago</h3>
                  <div class="border p-3 mb-3">
                    <h3 class="h6 mb-0"><a class="d-block" style="color:blue" data-toggle="collapse" href="#collapsebank" role="button" aria-expanded="false" aria-controls="collapsebank">Transferencia bancaria directa</a></h3>

                    <div class="collapse" id="collapsebank">
                      <div class="py-2">
                        <p class="mb-0">Realice su pago directamente en nuestra cuenta bancaria. Utilice su ID de pedido como referencia de pago. Su pedido no se enviará hasta que los fondos se hayan liquidado en nuestra cuenta.</p>
                      </div>
                    </div>
                  </div>

                  <div class="border p-3 mb-3">
                    <h3 class="h6 mb-0"><a class="d-block" style="color:blue" data-toggle="collapse" href="#collapsecheque" role="button" aria-expanded="false" aria-controls="collapsecheque">Pago con cheque</a></h3>

                    <div class="collapse" id="collapsecheque">
                      <div class="py-2">
                        <p class="mb-0">Realice su pago directamente en nuestra cuenta bancaria. Utilice su ID de pedido como referencia de pago. Su pedido no se enviará hasta que los fondos se hayan liquidado en nuestra cuenta.</p>
                      </div>
                    </div>
                  </div>

                  <div class="border p-3 mb-5">
                    <h3 class="h6 mb-0"><a class="d-block" style="color:blue" data-toggle="collapse" href="#collapsepaypal" role="button" aria-expanded="false" aria-controls="collapsepaypal">Paypal o Tarjeta de Crédito / Débito</a></h3>

                    <div class="collapse" id="collapsepaypal">
                      <div class="py-2">
                        <p class="mb-0">Realice su pago directamente en nuestra cuenta bancaria. Utilice su ID de pedido como referencia de pago. Su pedido no se enviará hasta que los fondos se hayan liquidado en nuestra cuenta.</p>
                      </div>

                      
                      <div id="paypal-button-container"></div>
                    

                    </div>
                  </div>

                  <div class="form-group">
                    <button class="btn btn-primary btn-lg py-3 btn-block" style="height: 70px;" onclick="procesar_compra()">Realizar pedido</button>
                  </div>

                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- </form> -->
      </div>
    </div>
  </div>

  <script type="text/javascript">
	
	async function modificar(idc){

		const { value: text } = await Swal.fire({
		input: 'number',
		inputLabel: `¿Cuántos desea agregar?`,
		inputPlaceholder: 'Escribe un numero',
		inputAttributes: {
			'aria-label': 'Escribe un numero'
		},
		showCancelButton: true
		})

		//var new_cant = prompt("¿Cuántos articulos desea agregar al carrito?",1);
		var new_cant = text;

		if (new_cant>0) {
			window.location = "?p=checkout&id="+idc+"&modificar="+new_cant;
		}
	}
</script>

<script>
      paypal.Buttons({

        // Sets up the transaction when a payment button is clicked
        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: '<?=$monto_dolar?>' // Can reference variables or functions. Example: `value: document.getElementById('...').value`
              }
            }]
          });
        },

        // Finalize the transaction after payer approval
        onApprove: function(data, actions) {
          return actions.order.capture().then(function(orderData) {
            console.log(orderData)
            // Successful capture! For dev/demo purposes:
                console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                var transaction = orderData.purchase_units[0].payments.captures[0];
                //alert('Transaction '+ transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');
                var estado = transaction.status;
                if(estado=='COMPLETED'){
                  location.href="?p=thank_you"
                }
            // When ready to go live, remove the alert and show a success message within this page. For example:
            // var element = document.getElementById('paypal-button-container');
            // element.innerHTML = '';
            // element.innerHTML = '<h3>Thank you for your payment!</h3>';
            // Or go to another URL:  actions.redirect('thank_you.html');
            
          });
        }
      }).render('#paypal-button-container');

</script>

<script>
  function procesar_compra(){
    Swal.fire({
      position: 'top-end',
      icon: 'warning',
      title: 'Debes agregar un método de pago y pagar para realizar el pedido',
      showConfirmButton: false,
      timer: 3000
    })
  }
</script>

</section>
</body>