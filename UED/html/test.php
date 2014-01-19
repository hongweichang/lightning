<?php
	$a = array("avatarSrc"=> "", "title"=>"借款","titleHref"=>"http://www.caixiao2.com",
	"rate"=>"12%","rank"=>"A","amount"=>"3000","time"=>"12个月","progress"=>"70%");
	$b = array("state"=> 1, "data"=> array($a) );
	die(json_encode($b));
?>