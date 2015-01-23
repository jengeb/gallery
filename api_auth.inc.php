<?php

function init_api_auth($app) {

  $app->post("/auth", function () use ($app) {
    $json = $app->request->getBody();
    $obj = json_decode($json, true);

    if (is_string($obj["Username"]) && is_string($obj["Password"])) {
      if ( (strcmp($obj["Username"], "testuser") == 0) && (strcmp($obj["Password"], "testpw") == 0) ){
        $_SESSION["Username"] = $obj["Username"];
        $app -> halt(200);
      } else {
        $_SESSION["Username"] = false;
        $app->response->redirect("../#/failed");
        $app -> halt(401);
      }
    $_SESSION["Username"] = false;
    $app -> halt(401);
    }
    $_SESSION["Username"] = false;
    $app -> halt(401);
  });

}
?>
