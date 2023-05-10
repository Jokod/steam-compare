<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SitemapController extends AbstractController
{
    #[Route('/sitemap.xml', name: 'sitemap', format: 'xml')]
    public function index(Request $request): Response
    {
        $hostname = $request->getSchemeAndHttpHost();

        $urls = [];

        $urls[] = ['loc' => $this->generateUrl('dashboard'), 'priority' => '1.00'];
        $urls[] = ['loc' => $this->generateUrl('login')];
        // $urls[] = ['loc' => $this->generateUrl('about')];
        // $urls[] = ['loc' => $this->generateUrl('confidentiality')];

        $response = new Response(
            $this->renderView('pages/sitemap.html.twig', [
                'urls'     => $urls,
                'hostname' => $hostname,
            ]),
            200
        );
        $response->headers->set('Content-type', 'text/xml');

        return $response;
    }
}
