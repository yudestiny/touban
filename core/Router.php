<?php

class Router
{
  private $route;
  public function __construct($route)
  {
    $this->route = $route;
  }
  public function resolve($pathInfo)
  {
    foreach ($this->route as $path => $pattern) {
      if ($path === $pathInfo) {
        return $pattern;
      }
    }
    return false;
  }
}
