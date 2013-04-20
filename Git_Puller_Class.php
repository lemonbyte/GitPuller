<?php 

Class Git_Puller_Class{
	
	// Functie voor het uitvoeren van de shell
	function start_sh(){
		$output = shell_exec("/var/www/dev/git-puller.sh");
		return $output;
	}

	// Functie van het plaatsen van een log file op de server
	function server_log($output){
		file_put_contents('/var/www/dev/GitPuller/logs/github.txt', $output, FILE_APPEND);
	}
	
	// Functie van het plaatsen van een log file op de server
	function server_log_payload($output){
		file_put_contents('/var/www/dev/GitPuller/logs/payload.txt', $output, FILE_APPEND);
	}
	
	// Mail functie 
	function mail_log($shelldata,$email_body){
		$to      = 'r.dolewa@gmail.com';
		$subject = 'Gitpuller Script';
		$from = 'Gitpuller@lemonbyte.nl';
		$message = $shelldata.$email_body;
		$headers = "MIME-Version: 1.0\r\n";
    	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    	$headers  .= "From: $from\r\n";
		mail($to, $subject, $message, $headers);
	}
	
	function payload_to_data($payload){
		$data = array(
				"Email" 	 => $payload->commits[0]->committer->email,
				"Name"		 => $payload->commits[0]->committer->name,
				"Username"	 => $payload->commits[0]->committer->username,
				"Message" 	 => $payload->commits[0]->message,
				"Modified"	 => $payload->commits[0]->modified[0],
				"Removed"	 => isset($payload->commits[0]->removed[0]),
				"Timestamp"	 => $payload->commits[0]->timestamp
		);
		return $data;
	}

	function email_data_to_text($data_exec){
		extract($data_exec);
		$Removed_temp = $Removed ? $Removed : "Nothing removed";
		$Modified_temp = $Modified ? $Modified : "Nothing modified";
		
		$email = 
		<<<EOT
		<h2>GitPuller</h2>
		<h4>Updated @ $Timestamp</h4>
		<p>Name: $Name</p>
		<p>Email: $Email</p>
		<p>Commiter: $Username </p>
		<p><strong>Message: </strong>$Message </p>
		<p>Modified: $Modified_temp </p>
		<p>Removed: $Removed_temp </p>	
EOT;
		return $email;
	}
	
	// Uitvoer functie
	function execute($payload){
		if ($payload->ref === 'refs/heads/master') {

			$payload_to_data = $this->payload_to_data($payload);
			$email_body = $this->email_data_to_text($payload_to_data);
// 			echo $email_body;
// 			die();
			// Data verzameling en uivoeren van de shell
			$shelldata = $this->start_sh();
			// Log files
			$this->server_log($shelldata);
			$this->server_log_payload($payload);
			$this->mail_log($shelldata,$email_body);
		}
		
	}
}
?>