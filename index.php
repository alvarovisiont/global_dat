<?php 
if(!isset($_SESSION))
{
    session_start();
}

if(isset($_GET['dologout']))
{
    $_SESSION = array();
}

include_once "clases/login.php";
$mensaje = "";

if(isset($_POST['nombreusuario']))
{
    $model = new Acceso();
    $model->usuario = $_POST['nombreusuario'];
	$model->contra = $_POST['claveusuario'];
    $model->from = "usuarios";
    $model->where = "WHERE usuario = :usuario and clave = :clave";
    $model->login();
    $mensaje = $model->mensaje;
}



?>
<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
  <link rel="stylesheet" type="text/css" href="css/sweetalert2.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="fonts/glyphicons-halflings-regular.eot">
	
<style type="text/css">
	body, html {
     width: 100%;
   height: 100%;
   alignment-baseline:baseline;
   background-color: darkgray;
   background-size: cover;
}

#contenedor
{
	padding-top:5%;
}

#contenedor_oculto
{
    padding-top:5%;
}

.card-container.card {
    max-width: 350px;
    padding: 40px 40px;
}

.btn {
    font-weight: 700;
    height: 36px;
    -moz-user-select: none;
    -webkit-user-select: none;
    user-select: none;
    cursor: default;
}

/*
 * Card component
 */
.card {
    background-color: #F7F7F7;
    /* just in case there no content*/
    padding: 20px 25px 30px;
    margin: 0 auto 25px;
    margin-top: 50px;
    /* shadows and rounded borders */
    -moz-border-radius: 2px;
    -webkit-border-radius: 2px;
    border-radius: 2px;
    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
}

.profile-img-card {
    width: 96px;
    height: 96px;
    margin: 0 auto 10px;
    display: block;
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
    border-radius: 50%;
}

/*
 * Form styles
 */
.profile-name-card {
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    margin: 10px 0 0;
    min-height: 1em;
}

.reauth-email {
    display: block;
    color: #404040;
    line-height: 2;
    margin-bottom: 10px;
    font-size: 14px;
    text-align: center;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
}

.form-signin #nombreusuario,
.form-signin #claveusuario {
    direction: ltr;
    height: 44px;
    font-size: 16px;
}

.form-signin input[type=email],
.form-signin input[type=password],
.form-signin input[type=text],
.form-signin button {
    width: 100%;
    display: block;
    margin-bottom: 10px;
    z-index: 1;
    position: relative;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
}

.form-signin .form-control:focus {
    border-color: rgb(104, 145, 162);
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
}

.btn.btn-signin {
    /*background-color: #4d90fe; */
    background-color: rgb(104, 145, 162);
    /* background-color: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33));*/
    padding: 0px;
    font-weight: 700;
    font-size: 14px;
    height: 36px;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    border-radius: 3px;
    border: none;
    -o-transition: all 0.218s;
    -moz-transition: all 0.218s;
    -webkit-transition: all 0.218s;
    transition: all 0.218s;
}

.btn.btn-signin:hover,
.btn.btn-signin:active,
.btn.btn-signin:focus {
    background-color: rgb(12, 97, 33);
}

.forgot-password {
    color: rgb(104, 145, 162);
}

.forgot-password:hover,
.forgot-password:active,
.forgot-password:focus{
    color: rgb(203, 040, 033);
}

</style>
</head>
<body>
 <div class="container" id="contenedor">
        <div class="card card-container">
            <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card"></p>
            <form class="form-signin" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="form_registro">
                <input type="text" id="nombreusuario" name="nombreusuario" class="form-control" placeholder="Usuario" required autofocus>
                <input type="password" id="claveusuario" name="claveusuario" class="form-control" placeholder="Clave" required>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Enviar&nbsp;&nbsp;<span class="glyphicon glyphicon-check"></span></button>
            </form><!-- /form -->
            <?php if($mensaje != ""){?> <p id="aviso" class="alert alert-info"><?php  echo $mensaje. "</p>";} ?> 
        </div><!-- /card-container -->
</div>
<div class="container" id="contenedor_oculto" style="display: none;">
        <div class="card card-container">
            <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card"></p>
            <form class="form-signin" action="" method="POST" id="form_email">
                <div class="form-group">
                        <input type="text" id="correousuario" name="correousuario" class="form-control" placeholder="Introduzca su correo electrónico" required autofocus>
                    <div id="aviso"></div>
                </div>
                <button class="btn btn-lg btn-danger btn-block btn-signin" type="submit">Enviar&nbsp;&nbsp;<span class="glyphicon glyphicon-check"></span></button>
            </form><!-- /form -->
            <?php if($mensaje != ""){?> <p id="aviso" class="alert alert-info"><?php  echo $mensaje. "</p>";} ?>
            <a href="#" class="forgot-password" id="volver">
                <-volver
            </a> 
        </div><!-- /card-container -->
</div>
<script src="js/sweetalert2.min.js"></script>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.js"></script> 
</body>
</html>

<script type="text/javascript">
    $(document).ready(function()
    {
        $("#recuperar").click(function(){
            $("#contenedor").slideUp('slow/400/fast');
            $("#contenedor_oculto").fadeIn('slow/400/fast');

        });

        $("#volver").click(function(){
            $("#contenedor_oculto").slideUp('slow/400/fast');
             $("#contenedor").fadeIn('slow/400/fast');
        });

        $("#form_email").submit(function(){
            var email = $("#correousuario").val();
                $.ajax({
                    url: "recuperar_contra.php",
                    data: {correo: email},
                    dataType: "JSON",
                    type: "POST",
                    success: function(data)
                    {
                        if(typeof(data.incorrecto) == "undefined")
                        {
                                swal({
                                title: "Contraseña recuperada con éxito, revise su correo",
                                type: "success",
                                showButtonCancel: false,
                                confirmButtonText: "Listo",
                                confirmButtonClass: "btn btn-danger",
                                closeOnConfirm: true
                            },
                            function(e){
                                if(e)
                                {
                                    window.location.reload();
                                }
                            });
                        
                        }
                        else
                        {

                            $("#aviso").append('<p class="alert alert-warning" style="font-weight: bold;">' + data.incorrecto + '</p>');    
                        }

                    }
                });
                        
            return false;
        });
    });
</script>