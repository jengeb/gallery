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
        $imageNames[] = array("image" => $file);
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

    if (preg_match('/^image/i', $_FILES['upfile']['type'])) {

      $src = $_FILES['upfile']['tmp_name'];
      $dest = $dir.$_FILES['upfile']['name'];

      move_uploaded_file($src, $dest);
      $app->response->redirect("../#/images");
    } else {
      $app->response->redirect("../#/error");
    }
  });


// -----------------
// DELETE
// -----------------
  $app->delete('/images/:file', function ($file) use ($app) {
    $dir = "Images/";
    echo json_encode_utf8($file);
    unlink($dir . $file);
  });

}
?>
