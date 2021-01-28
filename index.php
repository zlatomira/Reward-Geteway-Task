<?php
require_once 'api-request.php';

require __DIR__ . '/vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
// Specify Twig templates location
$loader = new FilesystemLoader(__DIR__ . '/templates');
// Instantiate Twig
$twig = new Environment($loader);

/**
 *
 * Delete string between two strings
 *
 * @param   string  $beginning The first string to start the deletion from
 * @param   string  $end The seconf string to end the deletion to
 * @param   string $string The string that will be removed from
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

// save the response
$api_response = get("http://hiring.rewardgateway.net/list");
// remove the scripts
$api_response = delete_all_between("<script", "/script>", $api_response);
// decode to json
$api_response_decoded = json_decode($api_response, true);
//print_r($api_response_decoded );
if (array_key_exists('code', $api_response_decoded) && $api_response_decoded['code'] == 0 ) {
  //handle error message that sometimes is returned from the api
  echo $api_response_decoded['message']. " Please reload your browser";
} else {
    // Render view
    echo $twig->render('index.html', ['eployees' => $api_response_decoded] ); 
}

?>