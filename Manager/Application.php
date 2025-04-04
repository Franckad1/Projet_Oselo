<?php

namespace Manager;

use Controller;

final class Application
{
  public function Launch()
  {
    //echo "Tu veux atteindre".$_SERVER['REQUEST_URI'];
    $destination = str_replace(Config::PATH, '', $_SERVER['REQUEST_URI']); //Sépare PATH d'origine de mon URL reçu 
    $elements = explode('/', $destination);
    $entite = $elements[0] ?? ''; //
    $method = $elements[1] ?? '';
    $param = $elements[2] ?? '';

    if (empty($entite)) {
      $ctrl = new Controller\Controller;
      $ctrl->home();
    } else {
      $class = 'Controller' . ucfirst($entite);

      if (
        file_exists($_SERVER['DOCUMENT_ROOT'] . Config::PATH . 'Controller/' . $class . '.php') &&
        class_exists('Controller\\' . $class) &&
        method_exists('Controller\\' . $class, $method)
      ) {
        $nomComplet = 'Controller\\' . $class;
        $ctrl = new $nomComplet;
        $ctrl->{$method}($param);
      } else {
        $ctrl = new Controller\Controller;
        $ctrl->page404();
      }
    }
  }
}
// Creer un github