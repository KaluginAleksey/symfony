<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\TokenAuthenticatedController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController implements TokenAuthenticatedController
{
    #[Route(path: '/test', name: 'app_test')]
    public function index(Request $request): Response
    {
        return $this->json(['test' => 'ok', 'request' => $request]);
    }
}
