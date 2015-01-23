<?php

function init_api_auth($app) {

  $app->post("/auth", function () use ($app) {
    $json = $app->request->getBody();
    $obj = json_decode($json, true);

    if (isset($obj["Username"]) && isset($obj["Password"])) {
      if (is_string($obj["Username"]) && is_string($obj["Password"])) {
        if ($obj["Username"] == "testuser" && $obj["Password"] == "testpw") {
          $_SESSION["Username"] = $obj["Username"];
          $app -> halt(200);
        } else {
          $_SESSION["Username"] = false;
          return ($app -> halt(401));
        }
      }
    }

    if ($obj["Logout"] == "Logout") {
      $_SESSION["Username"] = false;
      return ($app -> halt(200));
    }
  });

}
?>
