<?php
define('INCL_FILE', 'true');
$def_printHTML = false;
require_once '../construct.php';
require '../Facebook/autoload.php';

$helper = $fb->getRedirectLoginHelper();

try {
	$accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
	// When Graph returns an error
	error_log('Graph returned an error: ' . $e->getMessage());
	header('location: ' . $def_cred->rootURL);
	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
	// When validation fails or other local issues
	error_log('Facebook SDK returned an error: ' . $e->getMessage());
	header('location: ' . $def_cred->rootURL);
	exit;
}

if (!isset($accessToken)) {
	if ($helper->getError()) {
		if ($helper->getErrorCode() == '200') {
			header('location: ' . $def_cred->rootURL);
			exit;
		}

		header('HTTP/1.0 401 Unauthorized');
		echo "Error: " . $helper->getError() . "\n";
		echo "Error Code: " . $helper->getErrorCode() . "\n";
		echo "Error Reason: " . $helper->getErrorReason() . "\n";
		echo "Error Description: " . $helper->getErrorDescription() . "\n";
	} else {
		header('HTTP/1.0 400 Bad Request');
		echo 'Bad request';
	}
	exit;
}

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);

// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId($def_cred->appId);

$tokenMetadata->validateExpiration();

if (!$accessToken->isLongLived()) {
	// Exchanges a short-lived access token for a long-lived one
	try {
		$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
	} catch (Facebook\Exceptions\FacebookSDKException $e) {
		error_log("Error getting long-lived access token: " . $helper->getMessage());
		header('location: ' . $def_cred->rootURL);
		exit;
	}
}

try {
	// Returns a `Facebook\FacebookResponse` object
	$response = $fb->get('/me?fields=id,name', $accessToken->getValue());
} catch(Facebook\Exceptions\FacebookResponseException $e) {
	error_log('Graph returned an error: ' . $e->getMessage());
	header('location: ' . $def_cred->rootURL);
	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
	error_log('Facebook SDK returned an error: ' . $e->getMessage());
	header('location: ' . $def_cred->rootURL);
	exit;
}

$user = $response->getGraphUser();

$resultado = Usuario::logar(null, null, $user['id']);

// Caso não haja um usuário criado para esta conta
if ($resultado === "c1") {
	if ($def_remainingTime) {
		$resultado = Usuario::registrar($user['name'], null, $user['id'], true);
	} else {
		$resultado = "c8";
	}
}

$_SESSION['fbError'] = $resultado;

header('location: ' . $def_cred->rootURL);
?>
