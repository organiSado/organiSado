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

// parse the json payload
$payload = json_decode($_REQUEST['payload']);
ob_start();
var_dump($payload);
$payload_str = ob_get_clean();

//if (!$payload) exit();

// parse the payload for the project name
$project_name = $payload->{'repository'}->{'name'};

/* debug $project_name = "organiSado";$payload->ref = 'refs/heads/master';
 */

// check for payload and server key for authentication
if ( $payload->ref === 'refs/heads/master' && $_REQUEST['key'] == md5($project_name) )
{
    // define the cd directory based on config and project name
    $project_directory = PROJECTS_PATH . $project_name;

    // cd into the project dir, git reset and pull changes
    exec('cd ' . $project_directory . '/ && git reset --hard HEAD && git pull', $out);

	/** email notification 
	 * @author Joel Quatrocchi
	 * @version 0.1
	*/
	$emails = "mjheredia88@gmail.com, martinmatus100@gmail.com, leonardo_celedon@hotmail.com, joel.quatro@gmail.com";
	$subject = "Nuevo commit en organiSado!";
	$plain_hr = "\n\n - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - \n\n";
	$message = "El ultimo PUSH ya se encuentra disponible en http://organisado.com.ar por ".$payload->pusher->name.".";
	$message .= $plain_hr;

	foreach ($payload->commits as $commit)
	{
		$ci_message = explode("\n", $commit->message);

		$message .= "- \"".$ci_message[0]."\"\n\n";
		$message .= $ci_message[2]."\n\n";
		$message .= "por ".$commit->author->name.", ".$commit->timestamp;
		$message .= $commit->url."\n\n";
	}

	$message .= $plain_hr;
	$message .= "Console Out:\n\n".implode("\n", $out);

	mail($emails, $subject, $message);
}

?>