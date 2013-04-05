<?php #!/usr/bin/env /usr/bin/php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	set_time_limit(0);
	
	include("Git_Puller_Class.php");
	 
	try {
	 
		$payload = json_decode($_REQUEST['payload']);
	 
	}
	catch(Exception $e) {
	
		file_put_contents('/var/www/dev/GitPuller/logs/github.txt', $e . ' ' . $payload, FILE_APPEND);
		exit(0);
		die();
	
	}
 	
	if ($payload->ref === 'refs/heads/master') {
		
		$payload_data = $payload->message."<br>".$payload->modified.$payload->removed.$payload->timestamp.$payload->committer;
		
		$shelldata = start_sh();
		mail_log($shelldata,$payload_data);
		server_log($shelldata);
	}
	
	function get_web_hook($payload){
		$git_name = $payload->name;
	}
	
?>
