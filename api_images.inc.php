<?php

function init_api_images($app) {

// -----------------
// GET
// -----------------

  $app->get("/images", function () use ($app) {

    $dir = "Images/";

    $files = scandir($dir);
    foreach ($files as $file) {
      if (filetype($dir . $file) == "file" && ($file != ".") && ($file != "..") && (substr($file, -4) == ".JPG")) {
        $imageNames[] = array("image" => $dir . $file);
      }
    }

    $obj = array("images" => $imageNames);

    echo json_encode_utf8($obj);
  });

}
?>
