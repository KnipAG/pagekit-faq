<?php

namespace Knip\FAQ\Entity;

/**
 * @Entity(tableClass="@faq_faq_categories", eventPrefix="faq.faq_categories")
 */
class FaqCategory
{

    /** @Column(type="integer") @Id */
    protected $id;

    /** @Column(type="string") */
    protected $title;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

}
