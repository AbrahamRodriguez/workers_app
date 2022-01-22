<?php 

require_once('connection.php');
 $objsql = new connection();
 $conexion = $objsql->get_connection();
 $_POST = json_decode(file_get_contents("php://input"), true);

 $identificador = $_GET["proc"];
    switch ($identificador) {
    	case "nvo_usuario":
    	if (isset($_POST["q"]) && isset($_POST["s"]) && isset($_POST["t"]) ) {
       $nm = $_POST["q"];
       $pass = md5($_POST["s"]);
       $tipoc = $_POST["t"];
	    $sentencia = $conexion->query("CALL INGRESAR_USUARIO('".$nm."','".$pass."',".$tipoc.")");
	        if ($sentencia)
	        	echo "1";
	        else
	        	printf("Errormessage: %s\n", $conexion->error);
    	}else{ 
    		echo "Faltan algunos atributos";
    	}
        break;
	    case "cuentas":
	        if (isset($_POST["id"])) {
		        $sentencia = $conexion->query("CALL RELACIONAR_CUENTA(".$_POST["id"].")");
		        //$molde = $sentencia->execute();
		        $array =[];
		        if ($sentencia->num_rows > 0) {
		        	while ($row = $sentencia->fetch_assoc()) {
		        		array_push($array, $row);
		        	}
		        }
		        echo json_encode($array);
		    }
	        break;
	    break;
	    case "consultar_deptos":
	           $sentencia = $conexion->query("CALL DESCRIBIR_CATALOGO()");
		        //$molde = $sentencia->execute();
		        $array =[];
		        if ($sentencia->num_rows > 0) {
		        	while ($row = $sentencia->fetch_assoc()) {
		        		array_push($array, $row);
		        	}
		        }

		        echo json_encode($array);
	        break;
	    break;
	    case "log_in":
	        if (isset($_POST["name"]) && isset($_POST["ps"])) {
	        	  $trad =md5($_POST["ps"]);
		        $sentencia = $conexion->query("CALL LOG_IN('".$_POST["name"]."' , '".$trad."')");
		        $array =[];
		        $tipog = 0;
		        $nameg = "";
		        $contador = 0;
		        if ($sentencia->num_rows > 0){
				        	while ($row = $sentencia->fetch_assoc()) {
				        		array_push($array, $row);
				        	}
				        	foreach ($array as $value) {
				        		$tipog = $value["TipoUsusario"];
				        		$nameg = $value["NombreUsuario"];

				        	}

			        		session_start();
			        		unset($_SESSION['name']);
			        		unset($_SESSION['tipo']);

			        	   $_SESSION['name'] = $nameg;
			        	   $_SESSION['tipo'] = $tipog;

		        	//echo "Credenciales Actuales : ".  $_SESSION['name']. " " .  $_SESSION['tipo'] ;
			        	   echo "1";
		        }
		        else {
		        	printf("Errormessage: %s\n", $conexion->error);

		        }
		        	
		    }
	    break;
	    case "nuevo_prod":
			  session_start();
	        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 1) {
	        	   echo "Credenciales de Usuario no Vigentes : ".(isset($_SESSION['tipo']) ? ($_SESSION['tipo'] == 2 ? "Cajero" : "No Autorizado" ) : "N/E"  ) ;
	        }else{   
	          if (isset($_POST["prices"]) && isset($_POST["depto"]) && isset($_POST["label"])) {
	          	$pri = $_POST["prices"];
	          	$depto = $_POST["depto"];
	          	$label = $_POST["label"];

		        $sentencia = $conexion->query("CALL AGREGAR_NUEVO_PROD(".$pri." , ".$depto." , '".$label."' )");
		        if ($sentencia)
		        	echo "1";
		        else
		        	echo "No llega a insertar";
		        	//printf("Errormessage: %s\n", $conexion->error);
		        	
		    }
		 }
	   
	    break;
	    case "disb_emp":
	        if (isset($_POST["idd"])) {
		        $sentencia = $conexion->query("CALL ELIMINAR_USUARIO(".$_POST["idd"].")");
		        
		        if ($sentencia)
		        	echo "1";
		        else
		        	printf("Errormessage: %s\n", $conexion->error);
		        	
		    }
	    break;
	    case "catalogo_prod":
	     $sentencia = $conexion->query("SELECT * FROM employees WHERE active = 1 ;");
	     $array =[];
	        if ($sentencia->num_rows > 0) {
	        	while ($row = $sentencia->fetch_assoc()) {
	        		array_push($array, $row);
	        	}
	        }
	        echo json_encode($array);
	    break;
	    case "mod_job":
	    if (isset($_POST["idu"])) {
	    	$sentencia = $conexion->query("CALL BUSCAR_EMPLEADO(".$_POST["idu"].")");
	        $array =[];
	        if ($sentencia->num_rows > 0) {
	        	while ($row = $sentencia->fetch_assoc()) {
	        		array_push($array, $row);
	        	}
	        }
	        echo json_encode($array);
	    }else{
			echo "No reconoció el id";
		}
	    break;
		case "nuevo_registro":
			$argument = "";
	        if ($_POST["idu"] != '') {
		        $argument = "CALL  MODIFICAR_NOMINA(".$_POST["idu"].", '" .$_POST["new_last_name"] ."' , '".$_POST['new_name']."' , '".$_POST['new_phone']."' , '".$_POST['new_mail']."');";
		        	
		    }else{
		        $argument = "CALL  AGREGAR_TRABAJADOR('" .$_POST["new_last_name"] ."' , '".$_POST['new_name']."' , '".$_POST['new_phone']."' , '".$_POST['new_mail']."');";

			}

			$sentencia = $conexion->query($argument);
		        
		        if ($sentencia)
		        	echo "1";
		        else
		        	printf("Errormessage: %s\n", $conexion->error);
	    break;

		case "busqueda_filtros":
			$argument = "SELECT * FROM employees WHERE active = 1 ";
			$lq = "";
			$la = "";
	        if (!empty($_POST["xlast_name"])) {
		      $lq = " last_name like '%".$_POST["xlast_name"] ."%' ";  	
		    }

			$la = (!empty($_POST["xlast_name"]) ) ? " AND " : "" ;
			$nq = (!empty($_POST["xname"])) ? " name like '%".$_POST["xname"] ."%' " : "" ;
			$na = (!empty($_POST["xname"])  ) ? " AND " : "" ;
			$pq = (!empty($_POST["xphone"])) ? " phone = '".$_POST["xphone"] ."' " : "" ;
			$ea = (!empty($_POST["xemail"])  ) ? " AND " : "" ;
			$eq = (!empty($_POST["xemail"])) ? " email = '".$_POST["xemail"] ."' " : "" ;
			$pa = (!empty($_POST["xphone"])  ) ? " AND " : "" ;



			
            $s = $argument.$la.$lq.$na.$nq.$pa.$pq.$ea.$eq." ; ";


			$sentencia = $conexion->query($s);
		     if(!$sentencia){
				echo $s;

			 }   
			$array =[];
	        if ($sentencia->num_rows > 0) {
	        	while ($row = $sentencia->fetch_assoc()) {
	        		array_push($array, $row);
	        	}
	        }
	        echo json_encode($array);
	    break;

	}
?>