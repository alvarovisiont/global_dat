<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

$MM_authorizedUsers = "1,2,3,4";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['user'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['user'], $_SESSION['nivel'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
$lista = explode("/", $_SERVER["REQUEST_URI"]);
require_once "clases/crud.php";
$crud = new Crud();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/glyphicons-halflings-regular.eot">
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="css/dataTables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/sweetalert2.css">
    <link rel="stylesheet" type="text/css" href="css/select2.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" type="text/css" href="css/personal.css">

</head>
    <div class="container-fluid display-table">
        <div class="row display-table-row">
            <div class="col-md-2 col-sm-1 hidden-xs display-table-cell v-align box" id="navigation">
                <div class="logo">
                    <h3 style="color: white">Sala Situacional</h3>
                    <?php
                      if($_SESSION['nivel'] == 1)
                      {?>
                    <h4 style="color: white">Regional</h4>
                    <?php
                      }
                      elseif($_SESSION['nivel'] == 2)
                      {
                      ?>
                        <h4 style="color: white; display: inline-block">Municipales</h4>
                      <?php
                      }
                      elseif($_SESSION['nivel'] == 3)

                      {
                      ?>
                        <h4 style="color: white; display: inline-block">
                          <?php  if($_SESSION['categoria'] == 3)
                            {
                              echo "UBCH"."_".$_SESSION['user']; 
                            }
                            elseif($_SESSION['categoria'] == 4)
                            {
                              echo "Consejo_Comunal"."_".$_SESSION['user'];  
                            }
                            elseif ($_SESSION['categoria'] == 5) 
                            {
                              echo "Misiones"."_".$_SESSION['user'];  
                            }
                            elseif ($_SESSION['categoria'] == 6) 
                            {
                              echo "Instituciones"."_".$_SESSION['user'];  
                            }
                            elseif($_SESSION['categoria'] == 7)
                            {
                              echo "Claps"."_".$_SESSION['user']; 
                            }
                            elseif ($_SESSION['categoria'] == 8) 
                            {
                              echo "Movimientos"."_".$_SESSION['user'];    
                            }
                            elseif ($_SESSION['categoria'] == 9) 
                            {
                              echo "Juventud"."_".$_SESSION['user'];    
                            }
                            elseif ($_SESSION['categoria'] == 10) 
                            {
                              echo "Otros"."_".$_SESSION['user'];    
                            }
                          ?>
                        </h4>
                      <?php
                      }
                      else
                      {
                        echo "Administrador";    
                      } 
                      ?>
                </div>
                <div class="navi">
                    <ul>
                    <?php
                      if($_SESSION['nivel'] == 1)
                      {?>

                        <li class="active"><a href="regionales.php"><i class="fa fa-home" aria-hidden="true"></i><span class="hidden-xs hidden-sm">INICIO&nbsp;</span></a></li>

                      <?php
                      }
                      elseif($_SESSION['nivel'] == 2)
                      {
                      ?>
                        <li class="active"><a href="municipales.php"><i class="fa fa-home" aria-hidden="true"></i><span class="hidden-xs hidden-sm">INICIO</span></a></li> 
                    <?php
                      }
                      elseif($_SESSION['nivel'] == 3)
                      {

                        if($_SESSION['categoria'] == 3)
                        {
                        ?>
                          <li class="active"><a href="ubch.php"><i class="fa fa-home" aria-hidden="true"></i><span class="hidden-xs hidden-sm">INICIO&nbsp;</span></a></li>
                          <li><a href="censo_ubch.php"><i class="fa fa-book" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Censo</span></a></li>  
                    <?php
                        }
                        elseif($_SESSION['categoria'] == 4)
                        {
                          ?>
                          <li class="active"><a href="consejo_comunal.php"><i class="fa fa-home" aria-hidden="true"></i><span class="hidden-xs hidden-sm">INICIO&nbsp;</span></a></li>
                          <li><a href="1x10_consejo.php"><i class="fa fa-book" aria-hidden="true"></i><span class="hidden-xs hidden-sm">1x10 Consejo</span></a></li>  
                        <?php
                        }
                        elseif($_SESSION['categoria'] == 5)
                        {
                        ?>
                          <li class="active"><a href="misiones.php"><i class="fa fa-home" aria-hidden="true"></i><span class="hidden-xs hidden-sm">INICIO&nbsp;</span></a></li>
                          <li><a href="1x10_mision.php"><i class="fa fa-book" aria-hidden="true"></i><span class="hidden-xs hidden-sm">1x10 Misión</span></a></li>
                        <?php
                        }
                        elseif($_SESSION['categoria'] == 6)
                        {
                          ?>
                          <li class="active"><a href="instituciones.php"><i class="fa fa-home" aria-hidden="true"></i><span class="hidden-xs hidden-sm">INICIO&nbsp;</span></a></li>
                          <li><a href="1x10_instituciones.php"><i class="fa fa-book" aria-hidden="true"></i><span class="hidden-xs hidden-sm">1x10 Institución</span></a></li>
                        <?php
                        }
                        elseif($_SESSION['categoria'] == 7)
                        {
                          ?>

                          <li class="active"><a href="clap.php"><i class="fa fa-home" aria-hidden="true"></i><span class="hidden-xs hidden-sm">INICIO&nbsp;</span></a></li>
                          <li><a href="1x15_clap.php"><i class="fa fa-book" aria-hidden="true"></i><span class="hidden-xs hidden-sm">1x15 Censo</span></a></li>  
                        <?php
                        }
                        elseif($_SESSION['categoria'] == 8)
                        {
                        ?>
                          <li class="active"><a href="movimientos.php"><i class="fa fa-home" aria-hidden="true"></i><span class="hidden-xs hidden-sm">INICIO&nbsp;</span></a></li>
                          <li><a href="1x10_movimientos.php"><i class="fa fa-book" aria-hidden="true"></i><span class="hidden-xs hidden-sm">1x10 Movimientos</span></a></li>  
                        <?php
                        }
                         elseif($_SESSION['categoria'] == 9)
                        {
                        ?>
                          <li class="active"><a href="juventud.php"><i class="fa fa-home" aria-hidden="true"></i><span class="hidden-xs hidden-sm">INICIO&nbsp;</span></a></li>
                          <li><a href="1x10_juventud.php"><i class="fa fa-book" aria-hidden="true"></i><span class="hidden-xs hidden-sm">1x10 Juventud</span></a></li>  
                        <?php
                        }
                         elseif($_SESSION['categoria'] == 10)
                        {
                        ?>
                          <li class="active"><a href="otros.php"><i class="fa fa-home" aria-hidden="true"></i><span class="hidden-xs hidden-sm">INICIO&nbsp;</span></a></li>
                          <li><a href="1x10_otros.php"><i class="fa fa-book" aria-hidden="true"></i><span class="hidden-xs hidden-sm">1x10 Otros</span></a></li>  
                        <?php
                        }
                      }
                    ?>                      
                        <li><a href="#">-</a></li>
                        <li><a href="#">-</a></li>
                        <li><a href="#">-</a></li>
                        <li><a href="#">-</a></li>
                        <li><a href="#">-</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-10 col-sm-11 display-table-cell v-align">
                <!--<button type="button" class="slide-toggle">Slide Toggle</button> -->
                <div class="row">
                    <header>
                        <div class="col-md-5">
                            <nav class="navbar-default pull-left">
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle collapsed" data-toggle="offcanvas" data-target="#side-menu" aria-expanded="false">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>
                            </nav>
                        </div>
                        <div class="col-md-7">
                          <?php 
                            if($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 4)
                            {
                            ?>
                               <div class="header-rightside">
                                <ul class="list-inline header-top pull-right">
                                    <li class="hidden-xs"><a href="#" class="add-project" data-toggle="modal" data-target="#add_project">Nuevo Usuario&nbsp;<span class="glyphicon glyphicon-user"></span><span class="glyphicon glyphicon-plus"></span></a></li>
                                    <li class="hidden-xs"><a href="#" class="add-project1" data-toggle="modal" data-target="#estadisticas">Estadísticas&nbsp;<span class="glyphicon glyphicon-search"></span></a></li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="imagenes/cuenta.png" alt="user">
                                            <b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <div class="navbar-content">
                                                    <span><?php echo strtoupper($_SESSION['user']); ?></span>
                                                    <?
                                                    if($_SESSION['nivel'] == 3)
                                                    {
                                                    ?>
                                                      <span><?php echo strtoupper($_SESSION['nombre']); ?></span>
                                                    <?
                                                    }
                                                    ?>
                                                    <div class="divider">
                                                    </div>
                                                    <a href="index.php?dologout=1" class="view btn-sm active">Salir</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                          <?php
                            }
                            elseif($_SESSION['nivel'] == 2)
                            {
                            ?>
                              <div class="header-rightside">
                                <ul class="list-inline header-top pull-right">
                                    <li class="hidden-xs"><a href="#" class="add-project" data-toggle="modal" data-target="#agregar_locales">Nuevo Usuario&nbsp;<span class="glyphicon glyphicon-user"></span><span class="glyphicon glyphicon-plus"></span></a></li>
                                    <li class="hidden-xs"><a href="#" class="add-project1" data-toggle="modal" data-target="#estadisticas">Estadísticas&nbsp;<span class="glyphicon glyphicon-search"></span></a></li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="imagenes/cuenta.png" alt="user">
                                            <b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <div class="navbar-content">
                                                    <span><?php echo strtoupper($_SESSION['user']); ?></span>
                                                    <?
                                                    if($_SESSION['nivel'] == 3)
                                                    {
                                                    ?>
                                                      <span><?php echo strtoupper($_SESSION['nombre']); ?></span>
                                                    <?
                                                    }
                                                    ?>
                                                    <div class="divider">
                                                    </div>
                                                    <a href="index.php?dologout=1" class="view btn-sm active">Salir</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <?php
                            }
                            elseif($_SESSION['nivel'] == 3)
                            {
                            ?>
                              <div class="header-rightside">
                                <ul class="list-inline header-top pull-right">
                                  <?php if($lista[2] == "misiones.php")
                                  {
                                    $crud->sql = "SELECT id from estructuras where id_mision = $_SESSION[id]";
                                    $crud->total();
                                    if($crud->total < 10)
                                    {
                                    ?>
                                      <li class="hidden-xs"><a href="#" class="add-project" data-toggle="modal" data-target="#agregar_estructura">Agregar Estructura&nbsp;<span class="glyphicon glyphicon-user"></span><span class="glyphicon glyphicon-plus"></span></a></li>
                                    <?php
                                    }
                                  }
                                  elseif($lista[2] == "instituciones.php")
                                  {
                                    $crud->sql = "SELECT id from estructuras where id_institucion = $_SESSION[id]";
                                    $crud->total();
                                    if($crud->total < 10)
                                    {
                                    ?>
                                      <li class="hidden-xs"><a href="#" class="add-project" data-toggle="modal" data-target="#agregar_estructura">Agregar Estructura&nbsp;<span class="glyphicon glyphicon-user"></span><span class="glyphicon glyphicon-plus"></span></a></li>
                                    <?php
                                    }

                                  }
                                  elseif($lista[2] == "consejo_comunal.php")
                                  {
                                    $crud->sql = "SELECT id from estructuras where id_consejo = $_SESSION[id]";
                                    $crud->total();
                                    if($crud->total < 10)
                                    {
                                    ?>
                                      <li class="hidden-xs"><a href="#" class="add-project" data-toggle="modal" data-target="#agregar_estructura">Agregar Estructura&nbsp;<span class="glyphicon glyphicon-user"></span><span class="glyphicon glyphicon-plus"></span></a></li>
                                    <?php
                                    }
                                  }
                                  elseif($lista[2] == "movimientos.php")
                                  {
                                    $crud->sql = "SELECT id from estructuras where id_movimientos = $_SESSION[id]";
                                    $crud->total();
                                    if($crud->total < 10)
                                    {
                                    ?>
                                      <li class="hidden-xs"><a href="#" class="add-project" data-toggle="modal" data-target="#agregar_estructura">Agregar Estructura&nbsp;<span class="glyphicon glyphicon-user"></span><span class="glyphicon glyphicon-plus"></span></a></li>
                                    <?php
                                    }
                                  }
                                    elseif($lista[2] == "juventud.php")
                                  {
                                    $crud->sql = "SELECT id from estructuras where id_juventud = $_SESSION[id]";
                                    $crud->total();
                                    if($crud->total < 10)
                                    {
                                    ?>
                                      <li class="hidden-xs"><a href="#" class="add-project" data-toggle="modal" data-target="#agregar_estructura">Agregar Estructura&nbsp;<span class="glyphicon glyphicon-user"></span><span class="glyphicon glyphicon-plus"></span></a></li>
                                    <?php
                                    }
                                  }
                                    elseif($lista[2] == "otros.php")
                                  {
                                    $crud->sql = "SELECT id from estructuras where id_otros = $_SESSION[id]";
                                    $crud->total();
                                    if($crud->total < 10)
                                    {
                                    ?>
                                      <li class="hidden-xs"><a href="#" class="add-project" data-toggle="modal" data-target="#agregar_estructura">Agregar Estructura&nbsp;<span class="glyphicon glyphicon-user"></span><span class="glyphicon glyphicon-plus"></span></a></li>
                                    <?php
                                    }
                                  }
                                  ?>
                                    <li class="hidden-xs"><a href="#" class="add-project1" data-toggle="modal" data-target="#estadisticas">Estadísticas&nbsp;<span class="glyphicon glyphicon-search"></span></a></li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="imagenes/cuenta.png" alt="user">
                                            <b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <div class="navbar-content">
                                                    <span><?php echo strtoupper($_SESSION['user']); ?></span>
                                                    <?
                                                    if($_SESSION['nivel'] == 3)
                                                    {
                                                    ?>
                                                      <span><?php echo strtoupper($_SESSION['nombre']); ?></span>
                                                    <?
                                                    }
                                                    ?>
                                                    <div class="divider">
                                                    </div>
                                                    <a href="index.php?dologout=1" class="view btn-sm active">Salir</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    </header>
                </div>
                <div class="user-dashboard">