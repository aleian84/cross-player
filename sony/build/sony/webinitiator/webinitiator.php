<?php 
	/* SONY
	 * This code is provided just as a reference and may contain untested parts of code
	 * and bugs.
	*/
	include_once(dirname(__FILE__).'/build_url.php');


	header('Content-type: application/vnd.ms-playready.initiator+xml');

	error_log("****************** Webinitiator LOG START ******************");
	
	//content url, the link to the actual protected ismc (manifest) file
	$contentUrl = null;
	if (isset($_REQUEST["contentUrl"])) {$contentUrl=$_REQUEST["contentUrl"];} else { exit(401); }
	error_log("Content URL : ".$contentUrl);


	$laUrl = null;
	$kid = null;
	$customData = null;
	$checksum = null;
	
	//If parameters are passed, do not use Manifest
	/*if (isset($_REQUEST["laUrl"]) && isset($_REQUEST["kid"])) {

		//License acquisition url
		if (isset($_REQUEST["laUrl"])) {$laUrl=$_REQUEST["laUrl"];}
		error_log("LA Url (param): ".$laUrl);

		//kid for content url
		if (isset($_REQUEST["kid"])) {$kid=$_REQUEST["kid"];}
		error_log("KID (param): ".$kid);
		
		//checksum for content url
		if (isset($_REQUEST["checksum"])) {$checksum=$_REQUEST["checksum"];}
		error_log("Checksum (param): ".$checksum);
		
	} else {
		$climArr = simplexml_load_string (curl_get_contents ($contentUrl));
		
		//If Manifest includes protection header, get information from there
		if (isset ($climArr->Protection->ProtectionHeader)) {
			error_log("Manifest contains protection header");
			$protectionStr = base64_decode($climArr->Protection->ProtectionHeader);
			$protectionStr = preg_replace('/[\x00-\x1F\x80-\xFF]/','',$protectionStr);

			preg_match ('@^.+<CHECKSUM>?(.+)</CHECKSUM>.+@i', $protectionStr, $tmp);
			$checksum = $tmp[1];
			error_log("Checksum (manifest): ".$checksum);

			preg_match ('@^.+<KID>?(.+)</KID>.+@i', $protectionStr, $tmp);
			$kid = $tmp[1];
			error_log("KID (manifest): ".$kid);

			preg_match ('@^.+<LA_URL>?(.+)</LA_URL>.+@i', $protectionStr, $tmp);
			$laUrl = $tmp[1];
			error_log("LA Url (manifest): ".$laUrl);
		}
	}*/
		
	//customData for content url
	if (isset($_REQUEST["customData"])) {$customData=$_REQUEST["customData"];}
	error_log("Custom Data (param): ".$customData);

	//canonicalize into absolute URL
	/*$contentUrl = http_build_url ((isset ($_SERVER['HTTPS']) ? "https" : "http")."://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'],
					  $contentUrl,
					  HTTP_URL_JOIN_PATH | HTTP_URL_STRIP_QUERY | HTTP_URL_STRIP_FRAGMENT);
	error_log("Content URL : ".$contentUrl);*/

	

	//-- GENERATE the Initiator XML
	$xmlInitiator=
	"<?xml version=\"1.0\" encoding=\"utf-8\"?>".
	"<PlayReadyInitiator xmlns=\"http://schemas.microsoft.com/DRM/2007/03/protocols/\">".
		"<LicenseAcquisition>".
			"<Header>".
				/*"<WRMHEADER xmlns=\"http://schemas.microsoft.com/DRM/2007/03/PlayReadyHeader\" version=\"4.0.0.0\">".

					"<DATA>".
						"<PROTECTINFO>".
							"<KEYLEN>16</KEYLEN>".
							"<ALGID>AESCTR</ALGID>".
						"</PROTECTINFO>".
						"<LA_URL>".xmlencode($laUrl)."</LA_URL>";
						if ($kid) {
							$xmlInitiator=$xmlInitiator."<KID>".$kid."</KID>";
						}
						
						if ($checksum) {
							$xmlInitiator=$xmlInitiator."<CHECKSUM>".$checksum."</CHECKSUM>";
						}
	
	$xmlInitiator=$xmlInitiator.
					"</DATA>".
				"</WRMHEADER>".*/
			"</Header>";
			/*if ($cookie) {*/

				
				$xmlInitiator=$xmlInitiator."<CustomData>".$_REQUEST["CD"]."</CustomData>";
			/*} else {
				//This optional tag is required in some Sony devices!
				$xmlInitiator=$xmlInitiator."<CustomData></CustomData>";
			}*/
			
		    $xmlInitiator=$xmlInitiator."<Content>".xmlencode($contentUrl)."</Content>".
		"</LicenseAcquisition>".
	"</PlayReadyInitiator>";
	error_log("XML : ".$xmlInitiator);
	echo $xmlInitiator;


	error_log("****************** Webinitiator LOG END ******************");
	exit(200);

	// -------------------- FUNCTIONS --------------------------------

	function xmlencode($instr) {
		return str_replace(array("&","<",">","\"","'"),array("&amp;","&lt;","&gt;","&quot;","&apos;"),$instr);
	}

	
	function curl_get_contents ($url)
	{
	  $request = curl_init ($url);
	  curl_setopt ($request, CURLOPT_RETURNTRANSFER, 1);
	  $ret = curl_exec ($request);
	  curl_close ($request);
	  return $ret;
	}

?>
