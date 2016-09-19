<?php
global $g_bypass_headers;
$g_bypass_headers = 1;

require_once('core.php');

// Retrieve settings
$fallback_account = config_get('git_fallback_account');
$commit_template = config_get('git_template');

try {
// Parse HTTP headers
    $event_handler = new EventHandler;
    $event = $event_handler->parseEvent(apache_request_headers());

    $data = file_get_contents("php://input");
    file_put_contents('checkingit.log', $data);

// Load parser
    $loader = new Loader;
    $parser = $loader->getParser($event);

// Parse request
    $parser->setTemplate($commit_template);
    $loader->parseEvent($event, $parser, $data);
} catch (Exception $ex) {
    exit($ex->getMessage());
}