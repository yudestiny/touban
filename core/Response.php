<?php

class Response
{
  private $content;
  private $statusCode;
  private $statusText;

  public function send()
  {
    Header('HTTP/1.1 ' . $this->statusCode . ' ' . $this->statusText);
    echo $this->content;
  }
  public function setContent($content)
  {
    $this->content = $content;
  }
  public function setStatus($statusCode, $statusText)
  {
    $this->statusCode = $statusCode;
    $this->statusText = $statusText;
  }
}
