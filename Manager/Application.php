<?php

namespace Manager;

use Controller;

// Classe finale (non extensible) chargée de lancer l'application
final class Application
{
  public function launch()
  {
    // Récupère l'URI demandée et supprime le chemin de base défini dans la config
    $destination = str_replace(Config::PATH, '', $_SERVER['REQUEST_URI']);

    // Découpe l'URL en segments (ex: /article/edit/12 → ['article', 'edit', '12'])
    $elements = explode('/', $destination);
    $entite = $elements[0] ?? ''; // Nom du contrôleur
    $method = $elements[1] ?? ''; // Méthode à appeler
    $param = $elements[2] ?? '';  // Paramètre optionnel

    if (empty($entite)) {
      // Si aucun contrôleur n'est précisé, on appelle la méthode home du contrôleur principal
      $ctrl = new Controller\Controller;
      $ctrl->home();
    } else {
      // Génère le nom de la classe du contrôleur (ex: 'Article' devient 'ControllerArticle')
      $class = 'Controller' . ucfirst($entite);

      // Vérifie que le fichier du contrôleur existe, que la classe est bien déclarée et que la méthode demandée existe
      if (
        file_exists($_SERVER['DOCUMENT_ROOT'] . Config::PATH . 'Controller/' . $class . '.php') &&
        class_exists('Controller\\' . $class) &&
        method_exists('Controller\\' . $class, $method)
      ) {
        // Instancie dynamiquement le contrôleur et appelle la méthode en lui passant le paramètre
        $nomComplet = 'Controller\\' . $class;
        $ctrl = new $nomComplet;
        $ctrl->{$method}($param);
      } else {
        // Si le contrôleur ou la méthode n'existent pas, appelle la page 404
        $ctrl = new Controller\Controller;
        $ctrl->page404();
      }
    }
  }
}
