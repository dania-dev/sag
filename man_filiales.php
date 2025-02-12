<?php
include("errores.php");
include("db_connection.php"); // Assuming you have a file for database connection

$id = isset($_GET['i']) ? $_GET['i'] : null;
$a = isset($_GET['a']) ? $_GET['a'] : null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestionar Oficinas y Agregar Oficina</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script type="text/javascript" src="js/sorter.js"></script>
  <script type="text/javascript" src="js/validacion.js"></script>
</head>
<body>
<section class="main row" style="font-size:12px;">
  <!-- AGREGAR OFICINA -->
  <article style="margin-top:10px; margin-left:15px;">
    <div class="row">
      <div class="col-md-7">
        <strong style="font-size:14px;">Informaci&oacute;n General</strong>
        <div class="recuadro">
          <form action="add_oficina.php" id="add_oficina" method="post" data-toggle="validator">
            <div class="input-group input-group-sm" style="margin-bottom:5px;">
              <span class="input-group-addon" id="basic-addon1">
                <span class="glyphicon glyphicon-tag"></span> 
              </span>
              <input type="text" name="oficina" id="oficina" class="form-control" placeholder="Escriba una oficina" aria-describedby="basic-addon1" required>
              <input type="hidden" name="pro" value="<?php echo md5('oficina'); ?>" >
            </div>
            <div class="botones_i">
              <button type="submit" id="agregar_oficina" class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-floppy-save" style="margin-right:7px;"></span>Agregar Oficina
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </article>
  <!-- TABLA DE OFICINAS -->
  <article class="col-lg-12" style="margin-top:10px;">
    <table cellpadding="0" cellspacing="1" border="0" align="center" width="130%" id="table" class="sortable">
      <thead>
        <tr class="encabezado">
          <td width="25" height="10" align="center" valign="middle">#</td>
          <td width="100" align="center" valign="middle">Oficina</td>
          <td width="25" align="center" valign="middle">Ver</td>
        </tr>
      </thead>
      <tbody>
      <?php
        error_reporting(E_PARSE);
        $color = array("#ffffff", "#F0F0F0");
        $cont = 0;

        $hq = "SELECT count(*) as total FROM actividades.man_oficinas";
        $rhq = mysqli_query($link, $hq);
        $hqr = mysqli_fetch_array($rhq);
        $trhq = $hqr['total'];

        if ($trhq > 0) {
          $qry1 = mysqli_query($link, "SELECT * FROM actividades.man_oficinas"); 
          while ($row1 = mysqli_fetch_array($qry1)) {
            $cont++;
      ?>
        <tr style="font-size:12px;" bgcolor="<?php echo $color[$cont % 2]; ?>">
          <td height="10" align="center"><?php echo $cont; ?></td>
          <td><?php echo $row1['ofidesc']; ?></td>
          <td align="center"> 
            <form action="procesos.php" method="get">
              <button type="submit" class="btn btn-default btn-xs">
                <input type="hidden" value="<?php echo $row1['idoficina']; ?>" name="i" />
                <input type="hidden" value="<?php echo md5(4); ?>" name="a" />
                <span class="glyphicon glyphicon-wrench" title="Ver oficina" aria-hidden="true"></span>
              </button>
            </form>
          </td>
        </tr>
      <?php }
        } else { ?>
        <tr bgcolor="<?php echo $color[$cont % 2]; ?>">
          <td colspan="3" align="center">*** No hay registros para mostrar ***</td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
    <div id="controls">
      <div id="perpage">
        <select onchange="sorter.size(this.value)">
          <option value="10">10</option>
          <option value="15">15</option>
        </select>
        <span>Items por p&aacute;gina</span> 
      </div>
      <div id="navigation"> 
        <img src="img/first.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1,true)" /> 
        <img src="img/previous.gif" width="16" height="16" alt="Previous Page" onclick="sorter.move(-1)" /> 
        <img src="img/next.gif" width="16" height="16" alt="Next Page" onclick="sorter.move(1)" /> 
        <img src="img/last.gif" width="16" height="16" alt="Last Page" onclick="sorter.move(1,true)" /> 
      </div>
      <div id="text">P&aacute;gina <span id="currentpage"></span> de <span id="pagelimit"></span></div>
    </div>
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
      sorter.init("table", 0); // Make sure 'table' is the correct ID
    </script> 
  </article>
</section>
</body>
</html>
