<?php
/**
 * Пример инициализации платежа
 */
require_once('CBTPay.php');
if (class_exists('CBTPay')) {
	$cbt = new CBTPay();

	// Аутенфикация
	$cbt->setAqId(1);
	$cbt->setLogin('test');
	$cbt->setPassword('testPassword');
	$cbt->setPrivateSecurityKey('testPrivateSecurityKey');

	// Информация об обплате
	$cbt->setIdPrefix('TST');
	$cbt->setId(2);
	$cbt->setOrderDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
	$cbt->setAmount(100);
	$cbt->setReturnUrl('https://example.com/success/');
	$cbt->setFailUrl('https://example.com/fail/');
	$cbt->setCallbackUrl('https://example.com/callback?id=2');
	$token = $cbt->getToken(true);
	?>
	<!Doctype html>
	<html>
	<body>
	<form action="https://pay.cbt.tj/payment/" method="post">
		<input type="hidden" name="aqId" value="<?= $cbt->getAqId() ?>">
		<input type="hidden" name="id" value="<?= $cbt->getId() ?>">
		<input type="hidden" name="orderDescription" value="<?= $cbt->getOrderDescription() ?>">
		<input type="hidden" name="amount" value="<?= $cbt->getAmount() ?>">
		<input type="hidden" name="currency" value="<?= $cbt->getCurrency() ?>">
		<input type="hidden" name="login" value="<?= $cbt->getLogin() ?>">
		<input type="hidden" name="returnUrl" value="<?= $cbt->getReturnUrl() ?>">
		<input type="hidden" name="failUrl" value="<?= $cbt->getFailUrl() ?>">
		<input type="hidden" name="callbackUrl" value="<?= $cbt->getCallbackUrl() ?>">
		<input type="hidden" name="token" value="<?= $token ?>">
		<button type="submit">Оплатить</button>
	</form>
	</body>
	</html>
	<?php
} else {
	trigger_error('CBTPay class not found', E_USER_ERROR);
}