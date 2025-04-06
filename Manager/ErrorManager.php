<?php

namespace Manager;

// Déclaration d'une classe ErrorManager dans le namespace "Manager"
class ErrorManager
{
  // Méthode statique pour intercepter une erreur ou une exception
  static public function interceptionErreur($e)
  {
    // Écrit l'erreur dans un fichier 'error.log'
    // Chaque erreur est ajoutée à la suite du fichier grâce à FILE_APPEND
    // PHP_EOL ajoute un saut de ligne 
    file_put_contents('error.log', $e . PHP_EOL, FILE_APPEND);
  }
}
