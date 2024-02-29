<?php

class Request
{
  public function getPathInfo()
  {
      if (strpos($_SERVER['REQUEST_URI'], '?')) {
      return substr_replace($_SERVER['REQUEST_URI'], '', mb_strpos($_SERVER['REQUEST_URI'], '?'), mb_strlen($_SERVER['REQUEST_URI']) -  mb_strpos($_SERVER['REQUEST_URI'], '?'));
    }
    return $_SERVER['REQUEST_URI'];

  }
}
