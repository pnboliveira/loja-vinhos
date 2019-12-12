<?php
	
function checkStringAndLength($min, $max, $field){
	
	$exp='/^[A-Z][A-z\s]{'.$min.','.$max.'}$/';
	
	if(!preg_match($exp,$field)){
		return(false);
	}
	else{
		return(true);
		}
	
}

function cleanFields($field){
	$field = trim($field);
	$field = strip_tags($field);
	$field = stripslashes($field);
	
	return($field);
}

function checkEmail($email){
	
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	if(filter_var($email, FILTER_VALIDATE_EMAIL)){
		return(true);
	}
	else{
		return(false);
	}
	
}

function checkPass($min,$max,$password){
	
	$exp = '/^[A-z-_0-9]{'.$min.','.$max.'}$/';
	
	if(!preg_match($exp,$password)){
		return(false);
	}
	else{
		return(true);
		}
}


function checkContato($contato){
	$exp = '/^[0-9]{9}$/';
	if(!preg_match($exp, $contato)){
		return(false);
	}else{
		return(true);
	}
}

?>