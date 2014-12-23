<?php

namespace Knip\FAQ;

use Pagekit\Framework\Application;
use Pagekit\Extension\Extension;

class FaqExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
        parent::boot($app);
        // your code here...
    }

    public function enable()
    {
        if ($version = $this['migrator']->create('extension://faq/migrations', $this['option']->get('faq:version'))->run()) {
            $this['option']->set('faq:version', $version);
        }
    }

}
