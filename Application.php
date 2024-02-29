<?php

class Application
{
  private $router;
  private $request;
  private $response;
  private $databaseManager;

  public function __construct()
  {
    $this->router = new Router($this->registerRoute());
    $this->request = new Request();
    $this->response = new Response();
    $this->databaseManager = new DatabaseManager();
    $this->databaseManager->connect(
      [
        'hostnameAndDatabase' => 'mysql:charset=UTF8;host=aws-and-infra-web.ckk4tnzpw1vs.ap-northeast-1.rds.amazonaws.com;dbname=aws_and_infra',
        'username' => 'aws_and_infra',
        'password' => 'password'
      ]
      );
  }
  public function run()
  {
    try{
      $params = $this->router->resolve($this->request->getPathInfo());
      if (!$params) {
        throw new HttpNotFoundException();
      }
    $controller = $params['controller'];
    $action = $params['action'];
    $this->runAction($controller, $action);
    } catch (HttpNotFoundException) {
      $this->render404Page();
    }

    $this->response->send();
  }

  public function getRequest()
  {
    return $this->request;
  }

  public function getDatabaseManager()
  {
    return $this->databaseManager;
  }

  private function runAction($controllerName, $action)
  {
    $controllerClass = ucfirst($controllerName) . 'Controller';

    if (!class_exists($controllerClass)) {
      throw new HttpNotFoundException();
    }

    $controller = new $controllerClass($this);
    $content = $controller->run($action);
    $this->response->setContent($content);
  }

  private function render404Page()
  {
    echo $_SERVER['REQUEST_URI'];

    $this->response->setStatus(404, 'Page Not Found');
    $this->response->setContent(
      <<<EOF
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404</title>
</head>
<body>
        <h1>404 Page Not Found<h1>
</body>
</html>
EOF
    );
  }

  private function registerRoute()
  {
    return [
      '/' => ['controller' => 'calender', 'action' => 'index'],
      '/register' => ['controller' => 'register', 'action' => 'index'],
      '/editor' => ['controller' => 'editor', 'action' => 'index'],
      '/shuffle' => ['controller' => 'shuffle', 'action' => 'select'],
      '/shuffle/index' => ['controller' => 'shuffle', 'action' => 'index'],
    ];
  }
}
