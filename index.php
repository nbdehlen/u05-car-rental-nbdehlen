<?php
  use Main\Core\Router;
  use Main\Core\Request;
  //use Twig\Extra\CssInliner\CssInlinerExtension;

  require_once __DIR__ . "/vendor/autoload.php";
  $loader = new Twig\Loader\FilesystemLoader(__DIR__ . "/src/Views");
  $twig = new Twig\Environment($loader);
  //$twig->addExtension(new CssInlinerExtension());

  $request = new Request();
  $router = new Router();
  $htmlCode = $router->route($request, $twig);
  echo $htmlCode;

