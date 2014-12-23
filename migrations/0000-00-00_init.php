<?php

return [

    'up' => function () use ($app) {

        $util = $app['db']->getUtility();

        if ($util->tableExists('@faq_faqs') === false) {
            $util->createTable('@faq_faqs', function ($table) {
                $table->addColumn('id', 'integer', ['unsigned' => true, 'length' => 10, 'autoincrement' => true]);
                $table->addColumn('title', 'string', ['length' => 255]);
                $table->addColumn('content', 'text');
                $table->addColumn('hashtag', 'string', ['length' => 1023]);
                $table->addColumn('status', 'smallint');
                $table->addColumn('category_id', 'integer');
                $table->setPrimaryKey(['id']);
            });
        }

        if ($util->tableExists('@faq_faq_categories') === false) {
            $util->createTable('@faq_faq_categories', function ($table) {
                $table->addColumn('id', 'integer', ['unsigned' => true, 'length' => 10, 'autoincrement' => true]);
                $table->addColumn('title', 'string', ['length' => 255]);
                $table->setPrimaryKey(['id']);
            });
        }

        // skip migrations and return latest version
        return '0000-00-00_init';
    }

];
