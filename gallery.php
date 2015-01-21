<?php
  session_start();
  $_SESSION["valid"] = true;

  $alledateien = scandir('files'); //Ordner "files" auslesen

  foreach ($alledateien as $datei) { // Ausgabeschleife
    echo $datei."<br />"; //Ausgabe Einzeldatei
  };

?>
