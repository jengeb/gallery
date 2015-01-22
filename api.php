<?php
  $dir = "Images/";

  $files = scandir($dir);
  foreach ($files as $file) {
    if (filetype($dir . $file) == "file" && ($file != ".") && ($file != "..") && (substr($file, -4) == ".JPG")) {
      $imageNames[] = $file;
    }
  }

  for ($i = 0; $i < sizeof($imageNames); $i++) {
    echo $imageNames[$i];
    echo ", ";
  }

?>
