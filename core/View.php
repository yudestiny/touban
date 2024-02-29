<?php

class view
{
  private $baseDir;

  public function __construct($baseDir)
  {
    $this->baseDir = $baseDir;
  }

  public function render($path, $variables, $layout)
  {
    extract($variables);

    ob_start();
    require $this->baseDir . '/' . $path . '.php';
    $content = ob_get_clean();

    ob_start();
    require $this->baseDir . '/' . $layout . '.php';
    $layout = ob_get_clean();

    return $layout;
  }
}
