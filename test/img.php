<?
    echo time ();
	echo "\n\n";
	    
	print_r (md5 ($argv[1]));
	echo "\n\n";
	print_r (sha1 ($argv[1]));	
	echo "\n\n";	
	
	print_r (base64_encode (md5 ($argv[1])));
	echo "\n\n";
	print_r (sha1 ($argv[1]));	
	echo "\n\n";		
?>