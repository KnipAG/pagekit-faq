<?php

namespace Knip\FAQ\Controller;

use Pagekit\Framework\Controller\Controller;


/**
 * Class SiteController
 * @package Knip\FAQ\Controller
 *
 * @Route("/faq")
 */
class SiteController extends Controller
{

    /**
     * @return array
     *
     * @Route("/")
     * @Response("extension://faq/views/faq.html.razr")
     */
    public function indexAction()
    {
        return [
            'items' => $this['db.em']->getRepository('Knip\FAQ\Entity\Faq')->query()->get(),
            'categories' => $this['db.em']->getRepository('Knip\FAQ\Entity\FaqCategory')->query()->get()
        ];
    }

}
