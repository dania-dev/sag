<script type="text/javascript">
	function mostrarReferencia(){
		if (document.fcontacto.opcionkb[0].checked == true) {
			document.getElementById('file_kb').style.display='block';
			document.getElementById('url_kb').style.display='none';
		} else {
			if (document.fcontacto.opcionkb[1].checked == true) {
				document.getElementById('file_kb').style.display='block';
				document.getElementById('url_kb').style.display='none';
			} else { 
				document.getElementById('url_kb').style.display='block';
				document.getElementById('file_kb').style.display='none';
			}
		}
	}
</script>
<?php
error_reporting(E_PARSE);
$idcatego = $_GET['b'];
$idscatego = $_GET['c'];
$idproblema = $_GET['d'];
$id = $_GET['i'];
$a = $_GET['a'];
/* Categorias */
$qry1=mysqli_query($link,"SELECT idcatego, categodesc FROM actividades.man_categoria where idcatego='$idcatego'");
//$opciones = '<option value="0">Elige una categoria</option>'; 
while($row1=mysqli_fetch_array($qry1)){
	$opciones.='<option value="'.$row1["idcatego"].'">'.$row1["categodesc"].'</option>';
}
/* Sub-Categorias */
$qry1=mysqli_query($link,"SELECT idsubcatego, scategodesc FROM actividades.man_subcategoria where idcatego='$idcatego' and idsubcatego='$idscatego'");
//$opciones1 = '<option value="0">Elige una subcategoria</option>'; 
while($row1=mysqli_fetch_array($qry1)){
	$opciones1.='<option value="'.$row1["idsubcatego"].'">'.$row1["scategodesc"].'</option>';
}
/* Problemas */
$qry1=mysqli_query($link,"SELECT idproblema, descincidente FROM actividades.man_problema where idcatego='$idcatego' and idsubcatego='$idscatego' and idproblema='$idproblema'");
//$opciones2 = '<option value="0">Elige un problema</option>'; 
while($row1=mysqli_fetch_array($qry1)){
	$opciones2.='<option value="'.$row1["idproblema"].'">'.$row1["descincidente"].'</option>';
}
/* Tipos de documentos de solucion */
$qry1=mysqli_query($link,"SELECT idtkbsolucion, tkb_descrip FROM actividades.man_tsolucion;");
$opciones_t = '<option value="0">Elige un tipo de archivo de soluci&oacute;n</option>'; 
while($row1=mysqli_fetch_array($qry1)){
	$opciones_t.='<option value="'.$row1["idtkbsolucion"].'">'.$row1["tkb_descrip"].'</option>';
}
?>
<section class="main row" style="font-size:12px;">
	<article style="margin-top:10px; margin-left:15px;">
		<strong style="font-size:14px;">Knowledge Base</strong> ( Base de conocimientos )
    		<div class="recuadro">
        	Adjunta un documento, imagen o direccion url para crear la solucion a un incidente en especifico.
            <br/><strong>Nota:</strong> Recuerda siempre adicionar informaci&oacute;n que realmente ayud&oacute; a solventar el incidente.
            <div style="margin-top:10px;">
            	<form method="post" action="add_kbsolucion.php" name="fcontacto" enctype="multipart/form-data">
              		<!-- Categoria -->
              		<div class="input-group input-group-sm" style="margin-bottom:5px;"> 
                		<span class="input-group-addon" id="basic-addon1">
                  			<span class="glyphicon glyphicon-tag"></span>
                		</span>
                		<select name="idcategoria" id="categoria" class="form-control" aria-describedby="basic-addon1">
							<?php echo $opciones; ?>
                        </select>
              		</div>
              		<!-- Sub-categoria -->
              		<div class="input-group input-group-sm" style="margin-bottom:5px;">
                		<span class="input-group-addon" id="basic-addon1">
                  			<span class="glyphicon glyphicon-tags"></span> 
                		</span>
                		<select name="idsubcategoria" id="subcategoria" class="form-control" aria-describedby="basic-addon1">
                  			<?php echo $opciones1; ?>
                		</select>
              		</div>
                    <!-- Incidente -->
                    <div class="input-group input-group-sm" style="margin-bottom:5px;">
                    	<span class="input-group-addon" id="basic-addon1">
                        	<span class="glyphicon glyphicon-alert"></span> 
                      	</span>
                      	<select name="problema" id="problema" class="form-control" aria-describedby="basic-addon1">
                        	<?php echo $opciones2; ?>
                      	</select>
                    </div>
                    <!-- Descripcion -->
                    <div class="input-group input-group-sm" style="margin-bottom:5px;">
                      	<span class="input-group-addon" id="basic-addon1">
                        	<span class="glyphicon glyphicon-pencil"></span> 
                      	</span>
                      	<input type="text" name="kbtitulo" class="form-control"  placeholder="Escribe un t&iacute;tulo para la soluci&oacute;n" aria-describedby="basic-addon1">
              		</div>
                    <!-- Tipo de knowledge base -->
                    <div class="input-group input-group-sm" style="margin-bottom:5px;">
                      	<span class="input-group-addon" id="basic-addon1">
                        	<span class="glyphicon glyphicon-record"></span> 
                      	</span>
                      	<span class="form-control">
                      		<input type="radio" name="opcionkb" value="1" id="opcionkb_0" onclick="mostrarReferencia();" />
                        		<span style="margin-left:5px; margin-right:30px;">Documento</span> 
                      		<input type="radio" name="opcionkb" value="2" id="opcionkb_1" onclick="mostrarReferencia();" />
                        		<span style="margin-left:5px; margin-right:30px;">Imagen</span>
                      		<input type="radio" name="opcionkb" value="3" id="opcionkb_2" onclick="mostrarReferencia();" />
                        		<span style="margin-left:5px; margin-right:30px;">URL</span>
                      	</span>
              		</div>
                  <!-- Descripcion del adjunto -->
                    <div class="input-group input-group-sm" style="margin-bottom:5px;">
                        <span class="input-group-addon" id="basic-addon1">
                          <span class="glyphicon glyphicon-file"></span> 
                        </span>
                        <input type="text" name="kbdtitulo" class="form-control"  placeholder="Escribe un t&iacute;tulo para el documento" aria-describedby="basic-addon1">
                  </div>
 			  		      <!-- Documento adjunto -->
                    <div id="file_kb" style="display:none;">
                      	<div class="input-group input-group-sm" style="margin-bottom:5px;">
                      		<span class="input-group-addon" id="basic-addon1"> 
                        		<span class="glyphicon glyphicon-paperclip"></span> 
                      		</span>
                      		<input type="file" name="documento" class="form-control" aria-describedby="basic-addon1">
                      	</div>
                    </div>
                    <!-- Documento adjunto -->
                    <div id="url_kb" style="display:none;">
                      	<div class="input-group input-group-sm" style="margin-bottom:5px;">
                      		<span class="input-group-addon" id="basic-addon1"> 
                        		<span class="glyphicon glyphicon-share"></span> 
                      		</span>
                      		<input type="text" placeholder="Escriba una URL valida" name="documento" class="form-control" aria-describedby="basic-addon1">
                      	</div>
                    </div>
              		<div class="botones_i">
                    	<input type="hidden" name="i" value="<?php echo $id; ?>">
                        <input type="hidden" name="a" value="<?php echo md5(4)?>">
              			<button type="submit" class="btn btn-default btn-sm">
                      <span class="glyphicon glyphicon-floppy-save" style="margin-right:7px;"></span>Guardar
                    </button> 
                    <button type="reset" class="btn btn-default btn-sm" style="margin-left:5px;">
                      <span class="glyphicon glyphicon-repeat" style="margin-right:7px;"></span>Limpiar
                    </button>
              		</div>
            	</form>
            </div>
    	</div>
	</article>
</section>