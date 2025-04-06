<?php

// Démarre une session avec un nom spécifique 'PROJET' pour cette application
session_name('PROJET');  // Définit le nom de la session
session_start();  // Démarre la session ou récupère la session existante

// Définit le fuseau horaire à 'Europe/Paris' pour garantir que les dates et heures sont correctement gérées dans ce fuseau
date_default_timezone_set('Europe/Paris');

// Inclut le fichier autoload.php pour charger automatiquement les classes nécessaires
// Cela permet d'inclure toutes les classes et fichiers nécessaires à l'application sans avoir à les inclure manuellement
require_once __DIR__ . '/autoload.php';  // __DIR__ représente le répertoire actuel du fichier

// Crée une instance de la classe Application située dans le namespace Manager
// Cette classe est responsable de lancer et de gérer l'application
$app = new Manager\Application;

// Lance l'application en appelant la méthode 'launch' de l'objet $app
// Cette méthode initie le fonctionnement de l'application
$app->launch();
