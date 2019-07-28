<?php

namespace App\Action\SavedImage;

use App\Service\SavedImageService;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

class SavedImages
{
    /** @var TwigRendererEngine $renderEngine */
    protected $renderEngine;
    /** @var FormFactoryInterface $form */
    protected $form;
    /** @var SavedImageService $imageService */
    protected $imageService;

    /**
     * Crawl constructor.
     * @param EngineInterface $renderEngine
     * @param FormFactoryInterface $form
     * @param SavedImageService $imageService
     */
    public function __construct(EngineInterface $renderEngine, FormFactoryInterface $form, SavedImageService $imageService)
    {
        $this->renderEngine = $renderEngine;
        $this->form = $form;
        $this->imageService = $imageService;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {

    }
}