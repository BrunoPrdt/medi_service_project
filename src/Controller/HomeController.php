<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController extends AbstractController
{

    /**
     * @var Environment
     */
    private $twig;

    public function __construct(Environment $twig){
        $this->twig = $twig;
    }

    /**
     * @Route("/", name="home")
     * @return Response
     */

    public function index(): Response
    {
        return $this->render('pages/home.html.twig');
    }

    /**
     * @Route("/admin", name="admin")
     * @return Response
     */

    public function admin(): Response
    {
        return $this->render('admin/index.html.twig');
    }
}

