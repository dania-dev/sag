<!--<sectio<?php
session_start(); // Asegúrate de iniciar la sesión si no lo has hecho aún
$_SESSION['idcliente'] = $idtcliente; // Asigna el valor adecuadamente
?>n class="main row">-->

<section class="container-fluid">
    <article class="col-lg-12" style="margin-top:10px;">
      <table cellpadding="0" cellspacing="1" border="0" align="center" width="130%" id="table" class="sortable">
        <thead>
          <tr class="encabezado">
            <td width="25" height="10" align="center" valign="middle">#</td>
            <td width="25" align="center" valign="middle">Msj</td>
            <td width="30" align="center" valign="middle">Prioridad</td>
            <td width="100" align="center" valign="middle">Categor&iacute;a</td>
            <td width="150" align="center" valign="middle">Sub-Categor&iacute;a</td>
            <td width="90" align="center" valign="middle">Nombre Usuario </td>
            <td width="90" align="center" valign="middle">Asignado a</td>
            <td width="60" align="center" valign="middle">Estatus</td>
            <td width="70" align="center" valign="middle">Fecha Creado</td>
            <td width="25" align="center" valign="middle">Ver</td>
          </tr>
        </thead>
        <tbody>
        <?php
		error_reporting(E_PARSE);
    $idtcliente= $_SESSION['idtcliente']; 
		$filial = $_GET['Filial'];
		$id = $_SESSION["id"];
		$idrol = $_SESSION["rol"];
		$color=array("#ffffff","#F0F0F0");
		$contador=0;
		$suma=0;
		$num=0;
		if(($idrol == 3) || ($idrol == 4)){
			$hq = "SELECT count(*) as total FROM actividades.v_incidente where idestatus in (5,6,7,8)";
		}
		if(($idrol == 1) || ($idrol == 2)){
			$hq = "SELECT count(*) as total FROM actividades.v_incidente where (idcliente='$id' or idtecnico='$id') and idestatus in (5,6,7,8)";
		}
		$rhq = mysqli_query($link,$hq);
		$hqr = mysqli_fetch_array($rhq);
		$trhq = $hqr['total'];
		if ( $trhq > 0 ){
			if(($idrol == 3) || ($idrol == 4)){
				$qry1=mysqli_query($link,"SELECT * FROM actividades.v_incidente where idestatus in (5,6,7,8) order by inc_finicio asc"); 
			}
			if($idrol == 2){
				$qry1=mysqli_query($link,"select * from actividades.v_incidente where idcliente = '$id' and idestatus in (5,6,7,8) order by inc_finicio asc"); 
			}
			if($idrol == 1){
				$qry1=mysqli_query($link,"select * from actividades.v_incidente where (idcliente = '$id' or idtecnico='$id') and idestatus in (5,6,7,8) order by inc_finicio asc;"); 
      }
			
			while($row1=mysqli_fetch_array($qry1)){
			$cont++;
			$num++;
			// bgcolor="<?php echo $color[$cont%2]; 
		?>
          <tr bgcolor="<?php echo $color[$cont%2]; ?>">
            <td height="10" align="center"><?php echo $cont;?></td>
            <td align="center">
            	<span class="badge"><?php echo $row1['msj']; ?></span>
            </td>
			<td align="center">
    <?php
    // Obtener la categoría
    $categoria = $row1['categodesc'];

    // Inicializar la prioridad original
    $p_original = $row1['idprioridad'];
    $p_reasignada = $p_original;

    // Clasificar la prioridad según la categoría
    switch ($categoria) {
        case 'Software (Programas, Aplicaciones, Sistemas Operativos)':
            if ($p_original == 1) {
                $p_reasignada = 2; // Reasignar a Prioridad Baja (Verde)
            } else if ($p_original == 3) {
                $p_reasignada = 3; // Mantener Prioridad Media (Amarillo)
            } else if ($p_original == 3) {
                $p_reasignada = 1; // Reasignar a Prioridad Alta (Rojo)
            }
            break;
        case 'Hardware (Equipos, Computadoras, Impresoras)':
            if ($p_original == 1) {
                $p_reasignada = 1; // Reasignar a Prioridad Media (Amarillo)
            } else if ($p_original == 1) {
                $p_reasignada = 2; // Reasignar a Prioridad Alta (Rojo)
            } else if ($p_original == 3) {
                $p_reasignada = 3; // Mantener Prioridad Baja (Verde)
            }
            break;
        case 'Networking':
            if ($p_original == 1) {
                $p_reasignada = 1; // Mantener Prioridad Alta (Rojo)
            } else if ($p_original == 2) {
                $p_reasignada = 3; // Reasignar a Prioridad Baja (Verde)
            } else if ($p_original == 3) {
                $p_reasignada = 2; // Reasignar a Prioridad Media (Amarillo)
            }
            break;
        // Añadir más casos según las categorías
        case 'Requerimientos especiales':
          if ($p_original == 1) {
              $p_reasignada = 1; // Mantener Prioridad Alta (Rojo)
          } else if ($p_original == 2) {
              $p_reasignada = 3; // Reasignar a Prioridad Baja (Verde)
          } else if ($p_original == 3) {
              $p_reasignada = 2; // Reasignar a Prioridad Media (Amarillo)
          }
          break;
          case 'Usuarios, roles y accesos':
            if ($p_original == 1) {
                $p_reasignada = 2; // Mantener Prioridad Alta (Rojo)
            } else if ($p_original == 2) {
                $p_reasignada = 3; // Reasignar a Prioridad Baja (Verde)
            } else if ($p_original == 3) {
                $p_reasignada = 2; // Reasignar a Prioridad Media (Amarillo)
            }
            break;
            case 'Actividades Diarias (Solo Técnología)':
              if ($p_original == 1) {
                  $p_reasignada = 2; // Mantener Prioridad Alta (Rojo)
              } else if ($p_original == 2) {
                  $p_reasignada = 3; // Reasignar a Prioridad Baja (Verde)
              } else if ($p_original == 3) {
                  $p_reasignada = 2; // Reasignar a Prioridad Media (Amarillo)
              }
              break;
              case 'Internet(Navegación, vídeo, wifi) ':
                if ($p_original == 1) {
                    $p_reasignada = 1; // Mantener Prioridad Alta (Rojo)
                } else if ($p_original == 2) {
                    $p_reasignada = 3; // Reasignar a Prioridad Baja (Verde)
                } else if ($p_original == 3) {
                    $p_reasignada = 2; // Reasignar a Prioridad Media (Amarillo)
                }
                break;
                break;
                case 'Fallas en hardware o componentes del centro de datos ':
                  if ($p_original == 1) {
                      $p_reasignada = 1; // Mantener Prioridad Alta (Rojo)
                  } else if ($p_original == 2) {
                      $p_reasignada = 3; // Reasignar a Prioridad Baja (Verde)
                  } else if ($p_original == 3) {
                      $p_reasignada = 2; // Reasignar a Prioridad Media (Amarillo)
                  }
                  break;
        default:
            break;
    }

    // Definir la descripción de la prioridad reasignada
    $desc_prioridad = '';
    switch ($p_reasignada) {
        case 1:
            $desc_prioridad = 'Alta';
            break;
        case 2:
            $desc_prioridad = 'Media';
            break;
        case 3:
            $desc_prioridad = 'Baja';
            break;
        default:
            $desc_prioridad = 'Desconocida';
            break;
    }

    // Mostrar la descripción de la prioridad y el icono basado en el valor final de $p_reasignada
    echo $desc_prioridad;
    switch ($p_reasignada) {
        case 1:
            echo " <span class=\"glyphicon glyphicon-adjust\" style=\"color:#F00000; font-size:12px;\"></span>"; // Rojo
            break;
        case 2:
            echo " <span class=\"glyphicon glyphicon-adjust\" style=\"color:#F9ED06; font-size:12px;\"></span>"; // Amarillo
            break;
        case 3:
            echo " <span class=\"glyphicon glyphicon-adjust\" style=\"color:#0F0; font-size:12px;\"></span>"; // Verde
            break;
        default:
            echo " <span class=\"glyphicon glyphicon-adjust\" style=\"color:#000; font-size:12px;\"></span>"; // Negro (por defecto)
            break;
    }
    ?>
</td>



            <td><?php echo $row1['categodesc']; ?></td>
            <td><?php echo $row1['scategodesc']; ?></td>
            <td>
			<?php /*
            	$nombre = $row1['clinombres']; 
				$n = explode(" ", $nombre);
				$apellido = $row1['cliapellidos']; 
				$a = explode(" ", $apellido);
				$nom = $n[0] . " " . $a[0];
				$nu = ucwords(strtolower($nom));*/
				echo $nu = $row1['clinombres'].' '.$row1['cliapellidos'];
			?>
            </td>

            	<?php
            	if($row1['idestatus'] == 5){
            		echo "<td align=\"center\"><strong>".$row1['tecnicoasig']."</strong></td>";
            	} else{
            		echo "<td align=\"center\">".$row1['tecnicoasig']."</td>";
            	}
            	?>
            <td align="center">
            	<?php echo $row1['estdesc']; 
                $e=$row1['idestatus']; 
                if($e == 5){
                  echo "<span class=\"glyphicon glyphicon-list-alt\" style=\"color:#000; font-size:12px; margin-left:5px;\"></span>";
                }
                if($e == 6 || $e == 7){
                  echo "<span class=\"glyphicon glyphicon-user\" style=\"color:#000; font-size:12px; margin-left:5px;\"></span>";
                }
                if($e == 8){
                  echo "<span class=\"glyphicon glyphicon-cog\" style=\"color:#000; font-size:12px; margin-left:5px;\"></span>";
                }
              ?>		
            </td>
            <td align="center"><?php echo substr($row1['inc_finicio'], 0, -3); ?></td>
            <td align="center">
            	<form action="procesos.php" method="get">
            	<button type="submit" class="btn btn-default btn-xs">
                	<input type="hidden" value="<?php echo $row1['idincidente']; ?>" name="i" />
                	<input type="hidden" value="<?php echo md5(4);?>" name="a" />
  					<span class="glyphicon glyphicon-eye-open" title="Ver insidente" aria-hidden="true"></span>
				</button>
                </form>
            </td>
          </tr>
          <?php }
			} else { ?>
            <tr bgcolor="<?php echo $color[$cont%2]; ?>">
				<td colspan="10" align="center">*** No hay registros para mostrar ***</td>
          <?php      
			}
				?>
        </tbody>
      </table>
      <div id="controls">
        <div id="perpage">
          <select onchange="sorter.size(this.value)">
            <option value="10">10</option>
            <option value="15">15</option>
          </select>
          <span>Items por p&aacute;gina</span> </div>
        <div id="navigation"> <img src="img/first.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1,true)" /> <img src="img/previous.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1)" /> <img src="img/next.gif" width="16" height="16" alt="First Page" onclick="sorter.move(1)" /> <img src="img/last.gif" width="16" height="16" alt="Last Page" onclick="sorter.move(1,true)" /> </div>
        <div id="text">P&aacute;gina <span id="currentpage"></span> de <span id="pagelimit"></span></div>
      </div>
      <script type="text/javascript" src="js/sorter.js"></script> 
      <script type="text/javascript">
  			var sorter = new TINY.table.sorter("sorter");
				sorter.head = "head";
				sorter.asc = "asc";
				sorter.desc = "desc";
				sorter.even = "evenrow";
				sorter.odd = "oddrow";
				sorter.evensel = "evenselected";
				sorter.oddsel = "oddselected";
				sorter.paginate = true;
				sorter.currentid = "currentpage";
				sorter.limitid = "pagelimit";
				sorter.init("table",0);
  		</script> 
    </article>
  </section>