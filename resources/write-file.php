<?php

    ///-------------------------------------------------
    // Request to pixelrte
    //

	function pixelrteRequest($thankyouURL) {
	    $ch = curl_init();

	    curl_setopt($ch, CURLOPT_URL, 'https://www.pixelrte.com/campaigns');
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic '.base64_encode("pixeltrx:tallturtle85").''));
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS,'thankyouURL='.$thankyouURL.'');
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec($ch);
		curl_close ($ch);

		$pixelrteJSON = json_decode($server_output, true);

	    return $pixelrteJSON['caid'];
	};

	$json = json_decode(file_get_contents("../params.json", "w"), true);
	$caid = strlen($json['caid']) == 'null' ? pixelrteRequest($_POST['thankyou_url']) : $json['caid'];

	$post_data = array(
		'pixel' => $_POST['pixel_code'],
		'thankyou_url' => $_POST['thankyou_url'],
		'caid' => $caid
	);

	$myfile = fopen("../params.json", "w") or die("Unable to open file!");
	fwrite($myfile, json_encode($post_data));
	fclose($myfile);

	$pixel_code = $_POST['pixel_code'];

	$thankyou_template = file_get_contents('tmpl-thankyou.html');
	$thank_you = str_replace("[pixel]", $pixel_code, $thankyou_template);

	file_put_contents("../thankyou.php", $thank_you);

	header("Location: ../writer.php?message=Your thank you page has been created successfully and is ready to use");

?>