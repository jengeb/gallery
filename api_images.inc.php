<?php

function init_api_images($app, $con, $config) {
// -----------------
// GET
// -----------------

  $app->get("/images", function () use ($app, $con, $config) {
    $dir = "Images/";
    $files = scandir($dir);

    foreach ($files as $file) {
      if (filetype($dir . $file) == "file" && ($file != ".") && ($file != "..") && ($file != ".gitignore")) {

        $sql = "SELECT tag FROM gallery WHERE name = '" .  mysqli_real_escape_string($con, $file) . "'";
        $res = mysqli_query($con, $sql);

        if (!$res) {
          error(500, "SQL error: " . mysqli_error($con));
        }

        $dsatz = mysqli_fetch_assoc($res);

        $imageNames[] = array("image" => $file, "tags" => $dsatz);
      }
    }

    $obj = array("images" => $imageNames);

    echo json_encode_utf8($obj);
  });


// -----------------
// POST -> insert
// -----------------

  $app->post("/images", function () use ($app, $con, $config) {
    if ($_SESSION["Username"]) {
      $dir = "Images/";

      echo json_encode_utf8($_FILES);

      if (preg_match('/^image/i', $_FILES['file']['type'])) {

        $src = $_FILES['file']['tmp_name'];
        $dest = $dir.$_FILES['file']['name'];

        move_uploaded_file($src, $dest);

        $tag = "Hallo";

        $sql = "insert gallery (name, tag) values ('" . $_FILES['file']['name'] . "', '" . $tag . "')";

        $res = mysqli_query($con, $sql);

      }
    } else {
      return ($app -> halt(401));
    }
  });


// -----------------
// DELETE
// -----------------
  $app->delete('/images/:file', function ($file) use ($app, $con, $config) {
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
