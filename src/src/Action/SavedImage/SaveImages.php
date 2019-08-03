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
    /** @var EngineInterface $renderEngine */
    protected EngineInterface $renderEngine;
    /** @var FormFactoryInterface $form */
    protected FormFactoryInterface $form;
    /** @var SavedImageService $imageService */
    protected SavedImageService $imageService;
    /** @var CrawlService $crawlService */
    protected CrawlService $crawlService;

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
            foreach ($images as $image) {
                $this->imageService->saveImage($image);
            }

            return new RedirectResponse("/saved");
        }

        return new Response(
            $this->renderEngine->render(
            '@App/savedimage/save.html.twig', [ 'form' => $form->createView()]
        ));
    }
}