<?php
namespace TuDublin;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class Controller
{
    protected $twig;

    public function __construct()
    {
        // my settings
        // ------------
        $myTemplatesPath = __DIR__ . '/../templates';

        // setup twig
        // ------------
        $loader = new FilesystemLoader($myTemplatesPath);
        $this->twig = new Environment($loader);

        $this->twig->addGlobal('session', $_SESSION);
    }
}