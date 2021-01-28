<?php
require_once 'api-request.php';

require __DIR__ . '/vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
$loader = new FilesystemLoader(__DIR__ . '/');
$loader->addPath(__DIR__ . '/templates');
$twig = new Environment($loader);
$template = $twig->load('index.php');

/**
 *
 * Delete string between two strings
 *
 * @param   string  $beginning The first string to start the deletion from
 * @param   string  $end The seconf string to end the deletion to
 * @param 	string $string The string that will be removed from
 * @return  string $string The result sfter removing the string
 */
function delete_all_between($beginning, $end, $string) {
  $beginningPos = strpos($string, $beginning);
  $endPos = strpos($string, $end);
  if ($beginningPos === false || $endPos === false) {
    return $string;
  }

  $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

  return delete_all_between($beginning, $end, str_replace($textToDelete, '', $string)); // recursion to ensure all occurrences are replaced
}

$api_response = get("http://hiring.rewardgateway.net/list");
$api_response = delete_all_between("<script", "/script>", $api_response);
$api_response_decoded = json_decode($api_response, true);

if (array_key_exists('code', $api_response_decoded) && $api_response_decoded['code'] == 0 ) {
	//handle error message that sometimes is returned from the api
	echo $api_response_decoded['message']. " Please reload your browser";
} else {

		echo $template->render(
		        [
			    'eployees' => $api_response_decoded, 
				]
		 );	
}

?>