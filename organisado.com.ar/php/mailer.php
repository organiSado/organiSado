<?php
/*$c = $_POST["c"];

// auth
if ($c != "9b3d1bf88e1a143f0a3f0d6c8783977e")
{
	exit( "Access Not Authorized!" );
}
*/
$t = $_POST["t"];
$s = $_POST["s"];
$b = $_POST["b"];

if ( mail($t, $s, $b) )
{
	echo "Enviado a ".$t;
}
else
{
	echo "No se pudo enviar a ".$t;
}

?>
