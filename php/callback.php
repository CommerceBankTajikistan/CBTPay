<?php
/**
 * Пример обработки колбэка, получения статуса платежа
 */
if (isset($_GET['id']) && $_GET['id'] !== '') {
	require_once('CBTPay.php');
	$id = $_GET['id'];
	if (class_exists('CBTPay')) {


		$cbt = new CBTPay();

		$cbt->setAqId(1);
		$cbt->setLogin('test');
		$cbt->setPassword('testPassword');
		$cbt->setPrivateSecurityKey('testPrivateSecurityKey');

		$cbt->setIdPrefix('TST');
		$cbt->setId($id);

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://pay.cbt.tj/status/' . $cbt->getAqId() . '/' . $cbt->getId() . '/' . $cbt->getToken(true) . '/',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 2,
			CURLOPT_TIMEOUT => 10,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
		));

		$response = json_decode(curl_exec($curl), true);
		curl_close($curl);

		if ($response !== false) {
			echo $response['status_code'];
		} else {
			trigger_error('Broken response', E_USER_NOTICE);
		}
	} else {
		trigger_error('CBTPay class not found', E_USER_ERROR);
	}
} else {
	trigger_error('ID is not provided', E_USER_NOTICE);
}
