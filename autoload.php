<?php

// Définition de la classe Autoload
final class Autoload
{
  // Méthode statique pour gérer l'autoload des classes
  public static function nameAutoload($name)
  {
    // Remplace les backslashes par des slashes dans le nom de la classe
    // Cela permet d'utiliser des namespaces (par exemple: MyNamespace\MyClass) pour convertir en chemin de fichier
    $fichier = str_replace('\\', '/', $name) . '.php';

    // Inclut le fichier correspondant à la classe demandée Cela charge la classe automatiquement quand elle est appelée
    require($fichier);
  }
}

// Enregistrement de l'autoloader pour qu'il soit utilisé chaque fois qu'une classe est demandée
// La fonction 'spl_autoload_register' permet de lier la méthode 'nameAutoload' à l'autoload des classes
spl_autoload_register(array('Autoload', 'nameAutoload'));
