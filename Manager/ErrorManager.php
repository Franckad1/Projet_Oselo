<?php

namespace Manager;

use Exception;

class ErrorManager
{
  static public function interceptionErreur($e)
  {
    file_put_contents('error.log', $e . PHP_EOL, FILE_APPEND);
  }
}
