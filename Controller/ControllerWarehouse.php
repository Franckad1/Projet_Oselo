<?php

namespace Controller;

use Model, Manager;
use PDOException;

// Contrôleur pour gérer les entrepôts (warehouses)
class ControllerWarehouse extends Controller
{
  public function __construct()
  {
    // Initialisation du modèle lié aux entrepôts
    $this->model = new Model\ModelWarehouse;
  }

  // Affiche une vue pour un entrepôt spécifique avec un éventuel message d'erreur
  public function view($id, $error)
  {
    $params = [
      'title' => $this->model->selectById($id)->name, // Titre : nom de l'entrepôt
      'current' => $this->model->selectById($id), // Données de l'entrepôt
      'error' => $error // Message d'erreur à afficher si présent
    ];
    $this->render('warehouse/newWarehouse.html', $params); // Affiche la vue correspondante
  }

  // Crée un nouvel entrepôt
  public function new()
  {
    $error = ''; // Initialisation du message d'erreur

    // Vérifie que le formulaire n'est pas vide
    if (!empty($_POST)) {
      // Validation des champs
      if (empty($_POST['name'])) $error = "Add a name please"; // Vérifie si le nom est présent
      else if (empty($_POST['adress'])) $error = "Add an adress name please"; // Vérifie si l'adresse est présente
      else {
        // Si tout est valide, tente l'insertion en base
        try {
          $this->model->insertInto($_POST); // Insertion dans la BDD
          $_SESSION['Message'] = "The artwork has been modified with success "; // Message de succès
        } catch (PDOException $e) {
          $_SESSION['Message'] = "Oops an error has been detected "; // En cas d'erreur
          Manager\ErrorManager::interceptionErreur(date('Y-m-d H:i ') . $e->getMessage()); // Log de l'erreur
        }
        // Redirection vers la page d'accueil
        header("Location:" . Manager\Config::URL);
        exit;
      }
    }

    // Si une erreur est présente ou le formulaire est incomplet, on renvoie à la vue
    $params = [
      'title' => 'New artwork', // Titre de la page
      'error' => $error // Message d'erreur
    ];
    $this->render('warehouse/newWarehouse.html', $params); // Affiche la vue de création
  }

  // Modifie un entrepôt existant
  public function edit($id)
  {
    // Donne accès aux données de l'entrepôt à modifier
    $params = [
      'title' => $this->model->selectById($id)->name, // Titre : nom de l'entrepôt
      'current' => $this->model->selectById($id), // Données de l'entrepôt à modifier
    ];

    // Traitement du formulaire d'édition
    if (!empty($_POST)) {
      // Validation des champs
      if (empty($_POST['name'])) {
        $this->view($id, 'Insert a Warehouse name'); // Si le nom est vide, on renvoie un message d'erreur
      } else if (empty($_POST['adress'])) {
        $this->view($id, 'Insert an address'); // Si l'adresse est vide, on renvoie un message d'erreur
      } else {
        // Si tout est valide, on tente de mettre à jour les données
        try {
          $this->model->update($_POST, $id); // Mise à jour en base de données
          $_SESSION['Message'] = 'The update is a success'; // Message de succès
        } catch (PDOException $e) {
          $_SESSION['Message'] = 'Oh No an error has been detected'; // En cas d'erreur
          Manager\ErrorManager::interceptionErreur(date('Y-m-d H:i ') . $e->getMessage()); // Log de l'erreur
        }
        // Redirection après mise à jour
        header("Location:" . Manager\Config::URL);
        exit;
      }
    }

    // Affiche la vue d'édition si nécessaire
    $this->render('warehouse/newWarehouse.html', $params); // Affiche la vue d'édition avec les données
  }
}
