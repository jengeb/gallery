<?php

function init_api_images($app) {
// -----------------
// GET
// -----------------

  $app->get("/images", function () use ($app) {
    $dir = "Images/";
    $files = scandir($dir);
    foreach ($files as $file) {
      if (filetype($dir . $file) == "file" && ($file != ".") && ($file != "..") && ($file != ".gitignore")) {
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
    if ($_SESSION["Username"]) {
      $dir = "Images/";

      echo json_encode_utf8($_FILES);

      if (preg_match('/^image/i', $_FILES['file']['type'])) {

        $src = $_FILES['file']['tmp_name'];
        $dest = $dir.$_FILES['file']['name'];

        move_uploaded_file($src, $dest);
      }
    } else {
      return ($app -> halt(401));
    }
  });


// -----------------
// DELETE
// -----------------
  $app->delete('/images/:file', function ($file) use ($app) {
    if ($_SESSION["Username"]) {
      $dir = "Images/";
      echo json_encode_utf8($file);
      unlink($dir . $file);
    } else {
      return ($app -> halt(401));
    }
  });

}
?>
