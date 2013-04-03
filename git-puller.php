<?php #!/usr/bin/env /usr/bin/php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	set_time_limit(0);
	
	include("Git_Puller_Class.php");
	 
	try {
	 
		$payload = json_decode($_REQUEST['payload']);
	 
	}
	catch(Exception $e) {
		server_log_error($e,$payload);
	}
 
	if ($payload->ref === 'refs/heads/master') {
	
		$shelldata = start_sh();
		mail_log($shelldata,$payload);
		server_log($shelldata);
	
	}


	
?>
