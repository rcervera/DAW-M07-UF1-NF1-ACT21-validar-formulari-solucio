<?php
// UnFormulari.php
 
function validar_entrada($valor) {
     $valor = trim($valor);
     $valor = stripslashes($valor);
     $valor = htmlspecialchars($valor);
     // futures accions de neteja...
     // ....
     return $valor;        
 }

 function mostraError($error) {
     global $errors;
     if(isset($errors[$error])) {  
       echo "<div class='alert alert-danger' role='alert'>";
       echo $errors[$error]; 
       echo "</div>";
     } 
 }

// Creem un array, que serà associatiu, per emmagatzemar els errors que es puguin produir
 $errors=array();

// guardarem els valors enviats en un array associatiu,
// per a per repintar posteriorment el formulari
// i que no es perdin els valors introduïts duran tla recàrrega de la pàgina.

$dades = array();

// inicialitzem l'array de dades amb valors per defecte
// per quan es carregui el formulari per primer cop.
$dades['edat'] = "";
$dades['password'] = "";
$dades['comentari'] = "";
$dades['titulacio'] = "ASIX";
$dades['formaAcces'] = "PROVA";
$dades['extres'] = array("futbol");  //marquem un element per defecte
$dades['idiomes'] = array(); // no marquem cap opció per defecte
$dades['data'] =  date('d/m/Y');

$valorsTitulacio = array(
            "DAM"=>"CFGS Desenvolupament aplicacions multiplataforma",
            "ASIX"=>"CFGS Administració de sistemes informàtics",
            "SMX"=>"CFGS Sistemes mutiplataforma i en xarxa",
            "DAW"=>"CFGS Desenvolupament aplicacions web");


if($_SERVER['REQUEST_METHOD']=="POST") {

  // Validacio edat: camp obligatori, enter i valors entre 1 i 120
  if(isset($_POST['edat'])) {     

    $dades['edat'] = validar_entrada($_POST['edat']); 

    if($dades['edat']!="") { // camp obligatori
        
        $options = array(
          'options' => array(        
          'min_range' => 0,
          'max_range' => 120)
        );
    
        if(filter_var($dades['edat'], FILTER_VALIDATE_INT,$options)===FALSE) {
              $errors['edat']="El paràmetre edat ha de ser un número entre 0 i 120";
        }
    }
    else $errors['edat']="El paràmetre edat és obligatori";
 }
 else $errors['edat']="El paràmetre edat no existeix";
 
 // Validacio password: camp obligatori i de llargada mínima 6 caràcters
 if(isset($_POST['password'])) {     
     
     $dades['password'] = validar_entrada($_POST['password']);    

     if($dades['password']!="") { // camp obligatori
        if(strlen($dades['password'])<6) {
            $errors['password']="El password és massa curt";
        }
     }
     else $errors['password']="El paràmetre password és obligatori";
 }
 else $errors['password']="El paràmetre password no existeix";


 // Validacio comentari: camp no obligatori
 if(isset($_POST['comentari'])) {     
     $dades['comentari'] = validar_entrada($_POST['comentari']); 
     
 }

 // Validacio titulacio: obligatori i amb valors segons array titulacions
 
 if(isset($_POST['titulacio'])) {     
     $dades['titulacio'] = $_POST['titulacio']; 

     if(!isset($valorsTitulacio[$dades['titulacio']]))  
         $errors['titulacio']="El valor de la titulacio no és correcte";
     
 }
 else $errors['titulacio']="El paràmetre titulacio no existeix";
 
 
 // Validacio Forma Acces 
 if(isset($_POST['FormaAcces'])) {     
     $dades['formaAcces'] = $_POST['FormaAcces']; 
     $valors = array("PROVA","BAT","ESO");
     if(!in_array($dades['formaAcces'],$valors))  
         $errors['formaAcces']="El valor de la forma d'accés no és correcte";
     
 }
 else $errors['formaAcces']="El paràmetre Forma d'accés no existeix";

 // Validacio Activitat
 if(isset($_POST['extres'])) {   
      $dades['extres'] = $_POST['extres'];
      $valors = array("futbol","piscina","basquet");
      foreach($dades['extres'] as $extra) {
	         if(!in_array($extra,$valors)) {
	              $errors['extres'] ="Un valor $extra seleccionat com extra no és correcte";
           }
      }
 }
 

 // Validacio idiomes
 if(isset($_POST['idiomes'])) {   
      $dades['idiomes'] = $_POST['idiomes'];
      $valors = array("anglès","francès","alemany","rus");
      foreach($dades['idiomes'] as $idioma) {
	         if(!in_array($idioma,$valors)) 
	         $errors['idiomes'] ="Un valor $idioma seleccionat com idioma no és correcte";
      }
 }
 //else $errorIdiomes="El paràmetre idiomes no existeix";

  // validació data: camp no obligatori, de tipus data en format dd/mm/yyyy
  if(isset($_POST['data'])) {     
     $dades['data'] = validar_entrada($_POST['data']);    

     if($dades['data']!="") {                 
        $valors = explode('/',$dades['data']);
        if(count($valors)!=3 ||
              !checkdate (intval($valors[1]) ,intval($valors[0]),intval($valors[2]) ) ) {
           $errors['data']="El valor de la data no és correcte";
        }
    }     
 }
  



  if(count($errors)==0) 
  {
        // cridarem el codi per processar totes les dades validades correctament
        // ...

      echo "Tot ok!!<br>";
      echo "<div>";
      foreach($dades as $camp => $dada){
          echo "<li>".$camp.":";
          if(is_array($dada)) {
              foreach($dada as $valor) {
                  echo $valor." ";
              }
          }
          else echo $dada;
          echo "</li>";
      }
      echo "</div>";
      
      // Parem execució de l'script!
      exit;
      
  }
  else {

      // mostrar els errors de forma global en la pàgina
      echo "<div class='alert alert-danger' role='alert'>";
      foreach($errors as $error){
          echo "<li>".$error."</li>";
      }
      echo "</div>";
  }

}
?>

<HTML>

<HEAD>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</HEAD>

<div class="jumbotron text-center">
  <h1>El meu formulari</h1> 
</div>

<div class="container">
<FORM ACTION="formulari.php" METHOD="POST">
    
   <div class="form-group">
     <label>Introdueix la teva Edad:</label> 
     <INPUT TYPE="text" class="form-control" placeholder="escriu una edat" NAME="edat" value="<?php echo $dades['edat'];?>">
    <?php mostraError('edat');?>
   </div>

   <div class="form-group">
     <label> Clau accés: </label> 
     <INPUT TYPE="password" class="form-control" NAME="password" value="<?php echo $dades['password'];?>" >
     <?php mostraError('password');?>
   </div>  
 

   <div class="form-group">
     <label>  Escull una titulació: </label> 
     <?php
        foreach($valorsTitulacio as $pos => $valor) {
           echo "<div class='radio'><label>\n";
           echo "<INPUT TYPE='radio' NAME='titulacio' VALUE='".$pos."'";
               if($dades['titulacio']==$pos) echo "CHECKED";
           echo " >\n";
           echo $valor."\n";
           echo "</label></div>\n";
        }

     ?>
   </div>

  
    
    <div class="form-group"> 
   <label>Activitats:</label>
    
    <label class="checkbox-inline">
           <INPUT TYPE="checkbox" NAME="extres[]" VALUE="futbol" 
         <?php if(in_array("futbol",$dades['extres']))  echo "CHECKED";  ?>
     >Futbol </label>
    <label class="checkbox-inline">
   <INPUT TYPE="checkbox" NAME="extres[]" VALUE="piscina" 
        <?php if(in_array("piscina",$dades['extres']))  echo "CHECKED";  ?>
    >Piscina </label>
    <label class="checkbox-inline">
   <INPUT TYPE="checkbox" NAME="extres[]" VALUE="basquet" 
         <?php if(in_array("basquet",$dades['extres']))  echo "CHECKED";  ?>
   >Basquet </label>
    

    </div>

   <div class="form-group">
   <label>Selecciona la Forma d'acces al cicle formatiu</label>
   <SELECT  class="form-control" NAME="FormaAcces">
       <OPTION VALUE="PROVA" <?php if($dades['formaAcces']=="PROVA") echo "SELECTED";?>
       >Prova d'accés</OPTION>
       <OPTION VALUE="BAT"  <?php if($dades['formaAcces']=="BAT") echo "SELECTED";?>
       >Batxillerat</OPTION>
       <OPTION VALUE="ESO"  <?php if($dades['formaAcces']=="ESO") echo "SELECTED";?>
       >ESO</OPTION>
   </SELECT>
   
    </div>

   
   <div class="form-group">
   <label>Selecciona els idiomes que saps parlar</label>
   <SELECT MULTIPLE class="form-control"  NAME="idiomes[]">
       <OPTION VALUE="anglès" 
             <?php if(in_array("anglès",$dades['idiomes']))  echo "SELECTED";  ?>
          >Anglès</OPTION>
       <OPTION VALUE="francès"
               <?php if(in_array("francès",$dades['idiomes']))  echo "SELECTED";  ?>
       >Francès</OPTION>
       <OPTION VALUE="alemany"
             <?php if(in_array("alemany",$dades['idiomes']))  echo "SELECTED";  ?>
       >Alemany</OPTION>
       <OPTION VALUE="rus" 
               <?php if(in_array("rus",$dades['idiomes']))  echo "SELECTED";  ?>
       >Rus</OPTION>
   </SELECT>
    
   </div>

   
 

   <div class="form-group">
   <label>Comentari:</label>
   <TEXTAREA NAME="comentari" class="form-control" rows="5" placeholder="Escriu el teu comentari..."><?php echo $dades['comentari'];?></TEXTAREA>
    <?php mostraError('comentari');?>
   </div>

   <div class="form-group">
   <label>Data enviament:</label>
   <INPUT NAME="data" type="text" value="<?php echo $dades['data']; ?>">
   <?php mostraError('data');?>
   </div>


  
   <button type="submit" class="btn btn-default">Acceptar</button>

</FORM>
</div>




</BODY>
</HTML>
