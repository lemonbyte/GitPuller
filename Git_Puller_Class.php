<?php 

function start_sh(){
	$output = shell_exec("/var/www/dev/git-puller.sh");
	return $output;
}

function server_log($output){
	file_put_contents('/var/www/dev/GitPuller/logs/github.txt', $output, FILE_APPEND);
}

function mail_log($output,$payload){
	$to      = 'r.dolewa@gmail.com';
	$subject = 'Gitpuller Script';
	$message = $output;
	$headers = 'From: Gitpuller@Lemonbyte.nl' . "\r\n" .
			'Reply-To: Gitpuller@Lemonbyte.nl' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

	mail($to, $subject, $message."<br />".$payload, $headers);
}
?>