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

        $tags = array();

        while ($dsatz = mysqli_fetch_assoc($res)) {
          array_push($tags, $dsatz["tag"]);
        }

        $imageNames[] = array("image" => $file, "tags" => $tags);
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

      // in $_REQUEST steht data Inhalt
      $tags = json_decode($_REQUEST["tags"]);

      if (preg_match('/^image/i', $_FILES['file']['type'])) {

        $src = $_FILES['file']['tmp_name'];
        $dest = $dir.$_FILES['file']['name'];

        move_uploaded_file($src, $dest);

        foreach ($tags as $tag) {
          $sql = "insert gallery (name, tag) values ('" . mysqli_real_escape_string($con, $_FILES['file']['name']) . "', '" . mysqli_real_escape_string($con, $tag) . "')";
          $res = mysqli_query($con, $sql);
        }

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

      $sql = "delete from gallery where name = '" . mysqli_real_escape_string($con, $file) . "'";

      if (!mysqli_query($con, $sql)) {
        error(500, "MySQL-Error: " . mysqli_error($con));
      }

      if (!mysqli_affected_rows($con)) {
        error(404, "Das angegebene Bild ist nicht vorhanden");
      }

    } else {
      return ($app -> halt(401));
    }
  });

}
?>
