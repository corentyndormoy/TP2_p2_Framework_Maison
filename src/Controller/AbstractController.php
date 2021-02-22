<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use \Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractController
{
    private ?RouterInterface $routerInterface;

    public function render($templateName, $data = []): Response
    {
        $loader = new FilesystemLoader(__DIR__ . "/../../templates");
        $twig = new Environment($loader, [
            'cache' => __DIR__ . "/../../var/cache/",
            'debug' => true,
        ]);

        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $pathfunction = new \Twig\TwigFunction('path', function ($route_name, $route_parameters = []) {
            return $this->routerInterface->generate($route_name, $route_parameters);
        });

        $twig->addFunction($pathfunction);
        
        return new Response($twig->render($templateName, $data));
    }
    
    public function redirectTo($path):Response{
        return new RedirectResponse($path);
    }

    public function getRouter(): RouterInterface
    {
        return $this->routerInterface;
    }

    public function setRouter(?RouterInterface $routerInterface): Void
    {
        $this->routerInterface = $routerInterface;
    }

    public function redirectToRoute(string $route_name, $route_parameters = [])
    {
        $this->redirectTo($this->routerInterface->generate($route_name, $route_parameters));
    }
}