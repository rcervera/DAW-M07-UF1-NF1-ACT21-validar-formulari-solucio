<html lang="en">
<head>
  <title>Validar formulari</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">

<?php

  error_reporting(E_ALL);
  ini_set('display_errors', 1);

 // Amb include el codi del fitxer funcionsValidacio.php s'incrusta aquí!
  include 'funcionsValidacio.php';
  
  // Valors per defecte dels controls del formulari
  $nomDirectori="";
  $tipus="";
  $longitudMaxima="";
   $atributs=array();
  $permisos=array();
  
  $errors=array();
  
  if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
         
    // Caixa de text nom del fitxer
    $nomDirectori = validarString('nomDirectori',$errors,15,true);          
    // Caixa de text quantitat
    $longitudMaxima = validarInteger('longitudMaxima',$errors,1,10000,true);      
    // checkbox
    $valors=array("ocult","lectura");
    $atributs=validarOpcionsMultiples('atributs',$errors,$valors,false);

    // llista seleccio 1 element 
    $opcions=array("img","vid","music","other");
    $tipus=validarOpcions('tipus',$errors,$opcions,true);      

    // llista seleccio multiple
    $opcions=array("read","write","mod","show","esp");
    $permisos=validarOpcionsMultiples('permisos',$errors,$opcions,false);
    
    if(count($errors)==0) { // Cap Error
         
        echo "TOT CORRECTE!!!!";
        echo '<table class="table">';
        echo '   <thead class="thead-dark">';
        echo '      <tr>';
        echo '           <th>Camp</th>';
        echo '          <th>Valor</th>';
        echo '     </tr>';
        echo '   </thead>';
        echo '   <tbody>';
            
        echo "<tr><td>Nom Directori</td><td>".$nomDirectori."</td></tr>";
    echo "<tr><td>Longitud Màxima</td><td>".$longitudMaxima."</td></tr>";
        echo "<tr><td>Tipus Fitxer</td><td>".$tipus."</td></tr>";
      
    echo "<tr><td>Atributs</td><td>";       
        foreach($atributs as $element) {
               echo $element." ";
        }
        echo "</td></tr>";
      
        echo "<tr><td>Permisos</td><td>"; 
         foreach($permisos as $element) {
                   echo $element." ";
        }
        echo "</td></tr>";
         
        exit;
     }
}
  
?>

<h2>Activitat validació i recuperació dades formulari</h2>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" >

  <div class="form-group">
    <label>Nom directori per defecte: (cadena obligatòria entre 1 i 25 caràcters)</label>  
    <input type="text" name="nomDirectori" class="form-control" value="<?php echo $nomDirectori; ?>"> 
    <?php    mostraError('nomDirectori', $errors); ?>
    
  </div>
  
  <div class="form-group">
    <label>Longitud Màxima (MBytes): (Enter obligatori entre 1 i 10000)</label>  
    <input type="text" name="longitudMaxima" class="form-control" value="<?php echo $longitudMaxima; ?>" >        
    <?php    mostraError('longitudMaxima', $errors); ?>
  </div>
  
  
  <div class="form-group">
      <label>Atributs:(Selecció múltiple No obligatòria)</label>   
  
      <div class="form-check-inline">
      <label class="form-check-label">
          <input type="checkbox" name="atributs[]" value="lectura" <?php if(in_array("lectura",$atributs)) echo "checked";?>> Només Lectura
      </label>
      </div>
      
      <div class="form-check-inline">
      <label class="form-check-label">
          <input type="checkbox" name="atributs[]" value="ocult" <?php if(in_array("ocult",$atributs)) echo "checked";?>> Ocult
      </label>
      </div>
      
       
     <?php    mostraError('atributs', $errors); ?>
 </div>

  <div class="form-group">
  <label>Tipus de fitxer: (Selecció única obligatòria)</label>
  <select name="tipus" class="form-control">    
     <option <?php if($tipus=="img") echo "SELECTED"; ?> value="img"  >Imatge</option>
     <option <?php if($tipus=="vid") echo "SELECTED";    ?> value="vid">Video</option>
     <option <?php if($tipus=="music") echo "SELECTED";   ?> value="music">Música</option>
     <option <?php if($tipus=="other") echo "SELECTED";   ?> value="other">Altre tipus</option>
  </select>
   <?php    mostraError('tipus', $errors); ?>
  </div>

  <div class="form-group">
  <label>Permisos (Selecció multiple no obligatòria):</label>
  <select name="permisos[]" multiple class="form-control">
     <option value="read" <?php if(in_array("read",$permisos)) echo "selected";?>>Lectura</option>
     <option value="write" <?php if(in_array("write",$permisos)) echo "selected";?>>Escriptura</option>
     <option value="mod" <?php if(in_array("mod",$permisos)) echo "selected";?>>Modificació</option>
     <option value="show" <?php if(in_array("show",$permisos)) echo "selected";?>>Mostrar contingut</option>
     <option value="esp" <?php if(in_array("esp",$permisos)) echo "selected";?>>Permisos especials</option>
  </select>
   <?php    mostraError('permisos', $errors); ?>
  </div>
  
  <br><input type="submit"  class="btn btn-primary" value="enviar" name="boto">


</form>

</div>

</body>
</html>
