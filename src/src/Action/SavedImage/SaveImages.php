<?php

namespace App\Action\SavedImage;

use App\Form\ScrapeRequestType;
use App\Service\CrawlService;
use App\Service\SavedImageService;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Tests\RedirectResponseTest;
use Symfony\Component\Templating\EngineInterface;

class SaveImages
{
    /** @var TwigRendererEngine $renderEngine */
    protected $renderEngine;
    /** @var FormFactoryInterface $form */
    protected $form;
    /** @var SavedImageService $imageService */
    protected $imageService;
    /** @var CrawlService $crawlService */
    protected $crawlService;

    /**
     * Crawl constructor.
     * @param EngineInterface $renderEngine
     * @param FormFactoryInterface $form
     * @param SavedImageService $imageService
     * @param CrawlService $crawlService
     */
    public function __construct(
        EngineInterface $renderEngine,
        FormFactoryInterface $form,
        SavedImageService $imageService,
        CrawlService $crawlService
    ) {
        $this->renderEngine = $renderEngine;
        $this->form = $form;
        $this->imageService = $imageService;
        $this->crawlService = $crawlService;
    }

    /**
     * @param Request $request
     * @return Response
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

            $images = $this->crawlService->getImagesFromUrl($scrapeRequest->getUrl());
            $this->imageService->saveImages($images);

            return new RedirectResponse("/");
        }

        return new Response(
            $this->renderEngine->render(
            'savedimage/save.html.twig', [ 'form' => $form->createView()]
        ));
    }
}