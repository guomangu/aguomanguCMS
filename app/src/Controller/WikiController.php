<?php

namespace App\Controller;

use App\Entity\WikiPage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WikiController extends AbstractController
{
    #[Route('/wiki/{id}', name: 'app_wiki_show')]
    public function show(WikiPage $wikiPage): Response
    {
        // Magie : Symfony a vu "{id}" dans l'URL et "WikiPage" dans les arguments.
        // Il fait tout seul le "SELECT * FROM wiki_page WHERE id = ..."
        // Si l'id n'existe pas, il renvoie une erreur 404 tout seul.

        return $this->render('wiki/index.html.twig', [
            'page' => $wikiPage,
        ]);
    }
    
    // #[Route('/', name: 'app_home')]
    // public function index(): Response 
    // {
    //     // Petite redirection pour que la page d'accueil aille vers l'admin pour l'instant
    //     // ou vers une liste d'articles (à toi de voir)
    //     return $this->redirectToRoute('admin');
    // }
}