<?php

namespace Knip\FAQ\Entity;

/**
 * @Entity(tableClass="@faq_faqs", eventPrefix="faq.faq")
 */
class Faq
{

    /* FAQ unpublished status. */
    const STATUS_UNPUBLISHED = 0;

    /* FAQ published status. */
    const STATUS_PUBLISHED = 1;

    /** @Column(type="integer") @Id */
    protected $id;

    /** @Column(type="string") */
    protected $hashtag;

    /** @Column(type="string") */
    protected $title;

    /** @Column(type="integer") */
    protected $status = self::STATUS_UNPUBLISHED;

    /** @Column */
    protected $content = '';

    /** @Column(type="integer") */
    protected $category_id;

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

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }


    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getStatusText()
    {
        $statuses = self::getStatuses();

        return isset($statuses[$this->status]) ? $statuses[$this->status] : __('Unknown');
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_UNPUBLISHED => __('Unpublished'),
            self::STATUS_PUBLISHED => __('Published')
        ];
    }

    /**
     * @return mixed
     */
    public function getHashtag()
    {
        return $this->hashtag;
    }

    /**
     * @param mixed $hashtag
     */
    public function setHashtag($hashtag)
    {
        $this->hashtag = $hashtag;
    }

    /**
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * @param mixed $category
     */
    public function setCategory(FaqCategory $category = null)
    {
        $this->category_id = $category->getId();
    }

    /**
     * @param mixed $category_id
     */
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }

}
