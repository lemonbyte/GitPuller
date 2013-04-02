<?php #!/usr/bin/env /usr/bin/php
error_reporting(E_ALL);
ini_set('display_errors', '1');
set_time_limit(0);
 
try {
 
  $payload = json_decode($_REQUEST['payload']);
 
}
catch(Exception $e) {
 
    //log the error
    file_put_contents('/var/www/dev/GitPuller/logs/github.txt', $e . ' ' . $payload, FILE_APPEND);
 
      exit(0);
}
 
if ($payload->ref === 'refs/heads/master') {
 	
	$shelldata = start_sh();
	mail_log($shelldata);
	server_log($shelldata);
	
}

function start_sh(){
	  $output = shell_exec("/var/www/dev/git-puller.sh");
	  return $output;
	}

	function server_log($output){
    file_put_contents('/var/www/dev/GitPuller/logs/github.txt', $output, FILE_APPEND);
	}
	
	function mail_log($output){
	$to      = 'r.dolewa@gmail.com';
	$subject = 'Gitpuller Script';
	$message = $output;
	$headers = 'From: Gitpuller@Lemonbyte.nl' . "\r\n" .
		'Reply-To: Gitpuller@Lemonbyte.nl' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

	mail($to, $subject, $message, $headers);
	}
	
?>
