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
	
	function markup($markup){
		
		echo '<pre>';
		echo($markup);
		echo '</pre>';
		
	}
	
	function execute($payload){
		
		$data_payload = array(
	    "foo" => "bar",
	    "bar" => "foo",
		);
			
		
		
		//die();
		
		
		// Commiter ( Naam, Email, Usernaam )
		$email_commiter = $payload->commits[0]->committer->email;
		$name_commiter = $payload->commits[0]->committer->name;
		$username_commiter = $payload->commits[0]->committer->username;
			
		// Comit massage
		$commit_massage = $payload->commits[0]->message;
		
		// Bestanden die zijn aangepast.
		$items_changed = $payload->commits[0]->modified[0];
		$items_removed = isset($payload->commits[0]->removed[0]);
		$timestamp = $payload->commits[0]->timestamp;
		
		markup($timestamp);
		markup($items_changed);
		markup($email_commiter);
		markup($name_commiter);
		
		//die();
		
		if ($payload->ref === 'refs/heads/master') {
		
			$payload_data = 'Payload Data3S';
		
			$shelldata = start_sh();
			mail_log($shelldata,$payload_data);
			server_log($shelldata);
			file_put_contents('/var/www/dev/GitPuller/logs/payload.txt', $payload, FILE_APPEND);
		
		}
		
	}

?>