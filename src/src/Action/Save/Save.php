<?php

namespace App\Action\Save;

use App\Form\ScrapeRequestType;
use App\Service\CrawlService;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

class Save
{
    /** @var TwigRendererEngine $renderEngine */
    protected $renderEngine;
    /** @var FormFactoryInterface $form */
    protected $form;
    /** @var CrawlService $crawlService */
    protected $crawlService;

    /**
     * Crawl constructor.
     * @param EngineInterface $renderEngine
     * @param FormFactoryInterface $form
     * @param CrawlService $crawlService
     */
    public function __construct(EngineInterface $renderEngine, FormFactoryInterface $form, CrawlService $crawlService)
    {
        $this->renderEngine = $renderEngine;
        $this->form = $form;
        $this->crawlService = $crawlService;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     * @throws InvalidArgumentException
     */
    public function __invoke(Request $request): Response
    {
        $form = $this->form->createBuilder(ScrapeRequestType::class)
            ->setMethod('get')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $scrapeRequest = $form->getData();

            $response = $this->renderEngine->render(
                'crawl/crawl.html.twig', [
                'images' => $this->crawlService->getImagesFromUrl($scrapeRequest->getUrl()),
                'form' => $form->createView()
            ]);
        } else {
            $response = $this->renderEngine->render(
                'crawl/crawl.html.twig', [ 'form' => $form->createView()]
            );
        }

        return new Response($response);
    }
}