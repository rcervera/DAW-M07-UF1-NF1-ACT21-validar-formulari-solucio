<?php

function netejarCamp($valor) {
     $valor = trim($valor);
     $valor = stripslashes($valor);
     $valor = htmlspecialchars($valor);
     
     // futures accions sanejament
     // ...
     
     return $valor; 
  }
  
  
function validarString($camp,&$errors,$max=null,$required=false) {
    if(!isset($_POST[$camp])) {
        if ($required) {
            $errors[$camp] = "La informació del camp " . $camp . " no ha estat enviada!";
        }
    return ""; 
    }
    $valor = netejarCamp($_POST[$camp]);      
    if ($required && $valor == "") {
        $errors[$camp] = "Has deixat el camp en blanc.";
        return $valor; 
    }
    if (isset($max) && strlen($valor) > $max) {
        $errors[$camp] = "El camp és massa llarg";
        return $valor; 
    }

    return $valor;       
}



function validarInteger($camp,&$errors,$min=null,$max=null,$required=false) {
    
    if(!isset($_POST[$camp])) {
    if ($required) {
            $errors[$camp] = "La informació del camp " . $camp . " no ha estat enviada!";
        }
        return ""; 
    }
    $valor = netejarCamp($_POST[$camp]); 
    if ($required && $valor == "") {
        $errors[$camp] = "Has deixat el camp en blanc.";
        return $valor;
    }
    if(filter_var($valor, FILTER_VALIDATE_INT)===FALSE) {
        $errors[$camp] = "El camp ".$camp." ha de ser un enter";
        return $valor;
    } 
    if (isset($min) && $valor < $min) {
        $errors[$camp] = "El camp ha de ser superior a " . $min;
        return $valor;
    }
    if (isset($max) && $valor > $max) {
        $errors[$camp] = "El camp ha de ser inferior a " . $max;
        return $valor;
    }

    return $valor;
}

function validarOpcions($camp,&$errors,$opcions,$required=false) {
    
    if(!isset($_POST[$camp])) {
    if ($required) {
            $errors[$camp] = "La informació del camp " . $camp . " no ha estat enviada!";
        }
    return ""; 
    }
    $valor = netejarCamp($_POST[$camp]); 
    if ($required && $valor == "") {
        $errors[$camp] = "Has deixat el camp en blanc.";
        return $valor;
    }
    
    if(in_array($valor,$opcions)==false) {
        $errors[$camp] = "Selecció incorrecta.";
        return $valor;
    }
    return $valor;
}

function validarOpcionsMultiples($camp,&$errors,$opcions,$required=false) {
    
    if(!isset($_POST[$camp])) {
    if ($required) {
            $errors[$camp] = "La informació del camp " . $camp . " no ha estat enviada!";
        }
    return array(); 
    }
    $valors =$_POST[$camp]; 
    if ($required && count($valors) == 0) {
        $errors[$camp] = "Has de seleccionar una opcio.";
        return $valors;
    }
    
    foreach($valors as $element) {    
    if(in_array($element,$opcions)==false) {
            $errors[$camp] = "Selecció incorrecta";
            return $valors;
        }
    }    
    return $valors;
}

function mostraError($camp,$errors) {
    if(isset($errors[$camp])) {
        echo '<div class="alert alert-danger">';
        echo '<strong>'. $errors[$camp]. '</strong>'; 
        echo '</div>';
    }
}


?>

