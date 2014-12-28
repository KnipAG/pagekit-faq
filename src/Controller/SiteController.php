<?php

namespace Knip\FAQ\Controller;

use Knip\FAQ\Entity\Faq;
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
            'head.title' => 'FAQ | Knip AG',
            'head.description' => 'Alle häufig gestellten Fragen, sowie ausführliche Antworten dazu findest du in unserer FAQ Sektion.',
            'items' => $this['db.em']->getRepository('Knip\FAQ\Entity\Faq')->query()->where(['status' => Faq::STATUS_PUBLISHED])->get(),
            'categories' => $this['db.em']->getRepository('Knip\FAQ\Entity\FaqCategory')->query()->get()
        ];

    }

}
