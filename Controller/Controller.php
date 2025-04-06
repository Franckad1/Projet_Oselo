<?php

namespace Controller;

use Manager;

// Contrôleur principal qui fournit des méthodes communes (rendu, redirection, erreurs...)
class Controller
{
  protected $model; // Référence au modèle utilisé par les sous-contrôleurs

  // Méthode pour afficher une vue (template HTML)
  public function render($view, $param = array())
  {
    extract($param); // Extrait les clés du tableau $param comme variables
    require_once('View/header.html'); // En-tête commun
    require_once('View/' . $view);    // Vue principale passée en argument
    require_once('View/footer.html'); // Pied de page commun
  }

  // Affiche une page 404 personnalisée
  public function page404()
  {
    $params = [
      'title' => 'Error Page 404',
    ];
    $this->render('page404.html', $params);
  }

  // Supprime une ressource par son ID et redirige vers la page d'accueil
  public function delete($id)
  {
    $this->model->delete($id);
    header("Location:" . Manager\Config::URL); // Redirection vers l'URL de base
  }

  // Méthode d'accueil : récupère les entrepôts et affiche la page d'accueil
  public function home()
  {
    $ctlWarehouse = new ControllerWarehouse; // Instancie le contrôleur lié aux entrepôts

    $params = [
      'title' => 'Accueil Oselo',
      'warehouses' => $ctlWarehouse->model->selectAll() // Récupère tous les entrepôts
    ];

    $this->render('home.html', $params); // Affiche la page d’accueil avec les données
  }
}
