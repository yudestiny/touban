<?php

class Controller
{
  protected $actionName;
  protected $request;
  protected $databaseManager;

  public function __construct($application)
  {
    $this->request = $application->getRequest();
    $this->databaseManager = $application->getDatabaseManager();

  }
  public function run($action)
  {
    $this->actionName = $action;

    if (!method_exists($this, $action)) {
      throw new HttpNotFoundException();
    }

    return $this->$action();
  }

  protected function render($variables = [], $action = NULL, $layout = 'layout')
  {
    $view = new View(__DIR__ . '/../views');

    if (is_null($action)) {
      $action = $this->actionName;
    }

    $className = strtolower(substr(get_class($this), 0, -10));
    $path = $className . '/' . $action;

    return $view->render($path, $variables, $layout);
  }
}
