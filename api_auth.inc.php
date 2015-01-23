<?php

function init_api_auth($app) {

  $app->post("/auth", function () use ($app) {
    $json = $app->request->getBody();
    $obj = json_decode($json, true);

    if (isset($obj["Logout"]) && $obj["Logout"] == "Logout") {
      $_SESSION["Username"] = false;
      return $app -> status(200);
    }

    if (isset($_SESSION["Username"]) && $_SESSION["Username"]) {
      echo json_encode_utf8(array('Username' => $_SESSION["Username"]));
      return $app -> status(200);
    }

    if (isset($obj["Username"]) && isset($obj["Password"])) {
      if (is_string($obj["Username"]) && is_string($obj["Password"])) {
        if ($obj["Username"] == "testuser" && $obj["Password"] == "testpw") {
          $_SESSION["Username"] = $obj["Username"];
          echo json_encode_utf8(array('Username' => $_SESSION["Username"]));
          return $app -> status(200);
        }
      }
    }

    $_SESSION["Username"] = false;
    return ($app -> status(401));
  });

}
?>
