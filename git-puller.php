<?php #!/usr/bin/env /usr/bin/php

	// Config instellingen
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	set_time_limit(0);
	
	// Includen van de Classe
	include("Git_Puller_Class.php");
	
	
	// Server ip checken / als in local modus dan local host, anders naar live omgeiveing maken.s
	$ip = $_SERVER["SERVER_ADDR"];

	
	// Check voor het controleren van de payload.
	try {
		//$payload = json_decode($_REQUEST['payload']);
		$payload = json_decode('{ "after": "ef54f864d067f792edf9782e35d786daeb8a18e0", "before": "17100784be8693da6822a66dc9f1d47b32b74b38", "commits": [ { "added": [], "author": { "email": "r.dolewa@readview.nl", "name": "Radek Dolewa", "username": "dolewa" }, "committer": { "email": "r.dolewa@readview.nl", "name": "Radek Dolewa", "username": "dolewa" }, "distinct": true, "id": "ef54f864d067f792edf9782e35d786daeb8a18e0", "message": "sa\n\ndsadsa", "modified": [ "git-puller.php" ], "removed": [], "timestamp": "2013-04-05T06:17:02-07:00", "url": "https://github.com/lemonbyte/GitPuller/commit/ef54f864d067f792edf9782e35d786daeb8a18e0" } ], "compare": "https://github.com/lemonbyte/GitPuller/compare/17100784be86...ef54f864d067", "created": false, "deleted": false, "forced": false, "head_commit": { "added": [], "author": { "email": "r.dolewa@readview.nl", "name": "Radek Dolewa", "username": "dolewa" }, "committer": { "email": "r.dolewa@readview.nl", "name": "Radek Dolewa", "username": "dolewa" }, "distinct": true, "id": "ef54f864d067f792edf9782e35d786daeb8a18e0", "message": "sa\n\ndsadsa", "modified": [ "git-puller.php" ], "removed": [], "timestamp": "2013-04-05T06:17:02-07:00", "url": "https://github.com/lemonbyte/GitPuller/commit/ef54f864d067f792edf9782e35d786daeb8a18e0" }, "pusher": { "email": "r.dolewa@gmail.com", "name": "lemonbyte" }, "ref": "refs/heads/master", "repository": { "created_at": 1364420452, "fork": false, "forks": 0, "has_downloads": true, "has_issues": true, "has_wiki": true, "id": 9064286, "language": "PHP", "master_branch": "master", "name": "GitPuller", "open_issues": 0, "owner": { "email": "r.dolewa@gmail.com", "name": "lemonbyte" }, "private": false, "pushed_at": 1365167893, "size": 492, "stargazers": 0, "url": "https://github.com/lemonbyte/GitPuller", "watchers": 0 } }');
 	 	//var_dump($payload);
		
 	 	//die();
	}
	catch(Exception $e) {
	
		file_put_contents('/var/www/dev/GitPuller/logs/github_error.txt', $e . ' ' . $payload, FILE_APPEND);
		exit(0);
		die();
	
	}
 	
	
	execute($payload);

?>
