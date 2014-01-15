<?

$emails = array(/*"mjheredia88@gmail.com", "martinmatus100@gmail.com", "leonardo_celedon@hotmail.com",*/ "joel.quatro@gmail.com");
$subject = "Nuevo commit en organiSado!";
//$message = implode(", <br>\n\n", $_POST);
$message = var_dump($_POST);

foreach $emails as $email
{
        mail($email, $subject, $message);
}

?>

