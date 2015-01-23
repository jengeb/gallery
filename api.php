<?php

  require "vendor/autoload.php";
  require "api_images.inc.php";
  require "api_auth.inc.php";

  $app = new \Slim\Slim();
  //Header wird für Antwort gesetzt (als JSON und utf8)
  $app->response->headers->set("Content-Type", "application/json; charset=utf-8");

  $app->response->headers->set("Cache-Control", "no-cache, must-revalidate"); // HTTP/1.1
  $app->response->headers->set("Pragma", "no-cache");
  $app->response->headers->set("Expires", "Tue, 01 Jan 2000 00:00:00 GMT");

  function json_response($code, $message) {
    $err = array("code" => $code, "message" => $message);
    return json_encode_utf8($err);
  }

  function error($code, $message) {
    http_response_code($code);
    echo json_response($code, $message);
    exit();
  }

  function success($code, $message) {
    http_response_code($code);
    echo json_response($code, $message);
    exit();
  }

  function json_encode_utf8($obj) {
    return json_encode($obj, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) . "\n";
  }

  init_api_images($app);
  init_api_auth($app);

  try {
    $app->run();
  }
  catch (Exception $e) {
    error(500, "Unerwarteter Fehler: " . $e->getMessage());
  }

?>
