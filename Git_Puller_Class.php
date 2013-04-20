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
	
	function email_data($payload){
		
		$data_payload = array(
				"Email" 	 => $payload->commits[0]->committer->email,
				"Name"		 => $payload->commits[0]->committer->name,
				"Username"	 => $payload->commits[0]->committer->username,
				"Message" 	 => $payload->commits[0]->message,
				"Modified"	 => $payload->commits[0]->modified[0],
				"Removed"	 => isset($payload->commits[0]->removed[0]),
				"Timestamp"	 => $payload->commits[0]->timestamp
		);
			

		
		
	}

	function email_data_to_text(){
		extract($data_payload);
		$Removed_temp = $Removed ? $Removed : "Nothing removed";
		$Modified_temp = $Modified ? $Modified : "Nothing modified";
		
$email = <<<EOT
<h2>GitPuller</h2>
<h4>Updated @ $Timestamp</h4>
		
<p>Name: $Name</p>
<p>Email: $Email</p>
<p>Commiter: $Username </p>
<p><strong>Message: </strong>$Message </p>
<p>Modified: $Modified_temp </p>
<p>Removed: $Removed_temp </p>
		
EOT;
	}
	
	// Uitvoer functie
	function execute($payload){
		if ($payload->ref === 'refs/heads/master') {
			$shelldata = start_sh();
			mail_log($shelldata,$payload_data);
			server_log($shelldata);
			file_put_contents('/var/www/dev/GitPuller/logs/payload.txt', $payload, FILE_APPEND);
		
		}
		
	}

?>