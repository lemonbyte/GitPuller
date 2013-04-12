<?php 

	// Functie voor het uitvoeren van de shell
	function start_sh(){
		$output = shell_exec("/var/www/dev/git-puller.sh");
		return $output;
	}

	// Functie van het plaatsen van een log file op de server
	function server_log($output){
		file_put_contents('/var/www/dev/GitPuller/logs/github.txt', $output, FILE_APPEND);
	}

	// Mail functie 
	function mail_log($shelldata,$payloaddata){
		$to      = 'r.dolewa@gmail.com';
		$subject = 'Gitpuller Script';
		$message = $shelldata.$payloaddata;
		$headers = 'From: Gitpuller@Lemonbyte.nl' . "\r\n" .
				'Reply-To: Gitpuller@Lemonbyte.nl' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();
	
		mail($to, $subject, "Bericht::".$message, $headers);
	}
	
	function execute($payload){
		
		if ($payload->ref === 'refs/heads/master') {
		
			$payload_data = 'Payload Data3S';
		
			$shelldata = start_sh();
			mail_log($shelldata,$payload_data);
			server_log($shelldata);
			file_put_contents('/var/www/dev/GitPuller/logs/payload.txt', $payload, FILE_APPEND);
		
		}
		
	}

?>