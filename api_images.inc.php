<?php

function init_api_images($app) {
// -----------------
// GET
// -----------------

  $app->get("/images", function () use ($app) {
    $dir = "Images/";
    $files = scandir($dir);
    foreach ($files as $file) {
      if (filetype($dir . $file) == "file" && ($file != ".") && ($file != "..")) {
        $imageNames[] = array("image" => $dir . $file);
      }
    }

    $obj = array("images" => $imageNames);

    echo json_encode_utf8($obj);
  });


// -----------------
// POST -> insert
// -----------------

  $app->post("/images", function () use ($app) {
    $dir = "Images/";

    $src = $_FILES['upfile']['tmp_name'];
    $dest = $dir.$_FILES['upfile']['name'];

    move_uploaded_file($src, $dest);
    $app->response->redirect("../#/images");
  });

}

?>
