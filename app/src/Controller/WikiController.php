<?php

namespace App\Controller;

use App\Form\WikiPageType; 
use App\Entity\WikiPage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class WikiController extends AbstractController
{
    #[Route('/wiki', name: 'app_wiki_index', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $page = new WikiPage();
        $form = $this->createForm(WikiPageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (method_exists($page, 'setCreatedAt')) {
                $page->setCreatedAt(new \DateTimeImmutable());
            }

            $em->persist($page);
            $em->flush();

            return $this->redirectToRoute('app_wiki_show', ['id' => $page->getId()]);
        }

        $pages = $em->getRepository(WikiPage::class)->findBy([], ['id' => 'DESC']);

        return $this->render('wiki/list.html.twig', [
            'pages' => $pages,
            'form' => $form,
        ]);
    }

    // 1. LE CHEATCODE "CREATE"
    #[Route('/wiki/new', name: 'app_wiki_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $page = new WikiPage();
        $form = $this->createForm(WikiPageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On définit la date de création auto si ce n'est pas fait dans l'entité
            if (method_exists($page, 'setCreatedAt')) {
                $page->setCreatedAt(new \DateTimeImmutable());
            }

            $em->persist($page);
            $em->flush();

            // Hop, on redirige vers le nouvel article
            return $this->redirectToRoute('app_wiki_show', ['id' => $page->getId()]);
        }

        return $this->render('wiki/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/wiki/{id}', name: 'app_wiki_show', requirements: ['id' => '\d+'])]
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

    // 2. LE CHEATCODE "DELETE"
    #[Route('/wiki/{id}/delete', name: 'app_wiki_delete', methods: ['POST'])]
    public function delete(Request $request, WikiPage $page, EntityManagerInterface $em): Response
    {
        // Sécurité CSRF (le "token" évite que n'importe qui supprime via un lien piégé)
        if ($this->isCsrfTokenValid('delete'.$page->getId(), $request->request->get('_token'))) {
            $em->remove($page);
            $em->flush();
        }

        return $this->redirectToRoute('app_home'); // Ou 'admin' selon ta route d'accueil
    }
}