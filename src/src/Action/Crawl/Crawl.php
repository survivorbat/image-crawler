<?php

namespace App\Action\Crawl;

use App\Service\CrawlService;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

class Crawl
{
    /** @var TwigRendererEngine $renderEngine */
    protected $renderEngine;
    /** @var CrawlService $crawlService */
    protected $crawlService;

    /**
     * Crawl constructor.
     * @param EngineInterface $renderEngine
     * @param CrawlService $crawlService
     */
    public function __construct(EngineInterface $renderEngine, CrawlService $crawlService)
    {
        $this->renderEngine = $renderEngine;
        $this->crawlService = $crawlService;
    }

    /**
     * TODO: Handle exception
     *
     * @param Request $request
     * @return Response
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function __invoke(Request $request): Response
    {
        $url = $request->query->get('url');

        if (empty($url)) {
            $response = $this->renderEngine->render('crawl/crawl.html.twig', [ 'images' => [] ]);
            return new Response($response);
        }

        $response = $this->renderEngine->render(
            'crawl/crawl.html.twig',
            [ 'images' => $this->crawlService->getImagesFromUrl($url) ]
        );

        return new Response($response);
    }
}