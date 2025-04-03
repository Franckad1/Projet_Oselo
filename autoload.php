<?php

final class Autoload{

  public static function nameAutoload($name)  {
    $fichier=str_replace('\\','/',$name).'.php';// Renvoie le nom des classes afin de les inclures automatiquements lors de leurs initialisations
    require($fichier);  //Fais un appel du fichier contenant la classe à utilisé;
  }
}

spl_autoload_register(array('Autoload','nameAutoload'));//Creation de l'autoload 