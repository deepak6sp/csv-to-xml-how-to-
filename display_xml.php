<?php
	$db_host = "127.0.0.1";
	$db_user = "root";
	$db_pass = "123456";
	$db_name = "csv_xml";
	
	$db = mysql_connect($db_host, $db_user, $db_pass);
	if (!$db) {
	 die('Could not connect: ' . mysql_error());
	}
	else{
	 echo "successfully connected to database"."<br></br>";
	}
	mysql_select_db($db_name,$db);
	echo "selected db is ". $db_name;
	$result = mysql_query("SELECT * FROM data", $db);
	$xml = new SimpleXMLElement('<xml/>');
	echo "<br> </br>";
	while($row = mysql_fetch_assoc($result)) {
		 $data = $xml->addChild('data');
		 $data->addChild('postcode',$row['postcode']);
		 $data->addChild('suburb',$row['suburb']);
		 $data->addChild('state',$row['state']);
		 $data->addChild('dc',$row['dc']);
		 $data->addChild('type',$row['type']);
		 $data->addChild('lat',$row['lat']);
		 $data->addChild('lon',$row['lon']);
	}
	mysql_close($db);
	$dom = new DOMDocument('1.0');
	$dom->preserveWhiteSpace = false;
	$dom->formatOutput = true;
	$dom->loadXML($xml->asXML());
	echo $dom->saveXML();
	$fp = fopen("display.xml","wb");
	fwrite($fp,$xml->asXML());
	fclose($fp);
?>