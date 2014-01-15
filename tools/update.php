<?

/**
 * Github WebHook processor
 * POST to: postreceive.php?key=REPLACE_ME_WITH_A_UNIQUE_KEY
 *
 * @author Luis Abreu
 * @version 0.1
 * @copyright Quodis, 24 February, 2011
 * @package default
 **/

/**
 * path to projects in server
 **/
define('PROJECTS_PATH', '/home/joelquatro/');
/**
 * server key for authentication
 **/
define('SERVER_KEY', md5("organiSado"));

// parse the json payload
$payload = json_decode($_REQUEST['payload']);

if (!$payload) exit();

// check for payload and server key
if ( $payload->ref === 'refs/heads/master' && $_REQUEST['key'] == SERVER_KEY ) {
    // parse the payload for the project name
    $project_name = /*strtolower(*/$payload->{'repository'}->{'name'}/*)*/;
    // define the cd directory based on config and project name
    $project_directory = PROJECTS_PATH . $project_name;

    // cd into the project dir, git reset and pull changes
    $message = nl2br( shell_exec('cd ' . $project_directory . '/ && git reset --hard HEAD && git pull 2>&1') );


	/** email notification 
	 * @author Joel Quatrocchi
	 * @version 0.1
	*/
	$emails = array(/*"mjheredia88@gmail.com", "martinmatus100@gmail.com", "leonardo_celedon@hotmail.com",*/ "joel.quatro@gmail.com");
	$subject = "Nuevo commit en organiSado!";
	//$message = implode(", <br>\n\n", $_POST);
	$plain_hr = "\n\n - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - \n\n";
	$message = "El ultimo PUSH ya se encuentra disponible en organisado.com.ar...$plain_hr Console Out:\n\n".$message."$plain_hr Commit Data:\n\n".$payload;

	foreach ($emails as $email)
	{
	        mail($email, $subject, $message);
	}
}

?>