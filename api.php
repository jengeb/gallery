<?php

  require "config.inc.php";
  require "vendor/autoload.php";
  require "api_images.inc.php";
  require "api_auth.inc.php";

  session_start();

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

  $con = mysqli_init();

  // Connecting der Datenbank; return number of matched rows, not of affected rows
  if (!$con || !mysqli_real_connect($con, $config["server"], $config["username"], $config["password"], NULL, NULL, NULL, MYSQLI_CLIENT_FOUND_ROWS)) {
    error(503, "Connection to SQL-Server failed");
  }

  mysqli_set_charset($con, "utf8");
  mysqli_select_db($con, $config["db"]);

  init_api_images($app, $con, $config);
  init_api_auth($app, $con, $config);

  try {
    $app->run();
  }
  catch (Exception $e) {
    error(500, "Unerwarteter Fehler: " . $e->getMessage());
  }

?>
