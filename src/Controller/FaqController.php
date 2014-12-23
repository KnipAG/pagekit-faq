<?php

namespace Knip\FAQ\Controller;

use Knip\FAQ\Entity\Faq;
use Pagekit\Component\Database\ORM\Repository;
use Pagekit\Framework\Controller\Controller;
use Pagekit\Framework\Controller\Exception;

/**
 * @Route("/faq")
 * @Access("faq: manage FAQs", admin=true)
 */
class FaqController extends Controller
{

    /**
     * @var Repository
     */
    protected $faqs;

    protected $categories;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->faqs = $this['db.em']->getRepository('Knip\FAQ\Entity\Faq');
        $this->categories = $this['db.em']->getRepository('Knip\FAQ\Entity\FaqCategory');
    }

    /**
     * @Request({"filter": "array", "faq":"int"})
     * @Response("extension://faq/views/admin/faqs/index.html.razr")
     */
    public function indexAction($filter = null)
    {
        $query = $this->faqs->query();

        if (isset($filter['status']) && is_numeric($filter['status'])) {
            $query->where(['status' => intval($filter['status'])]);
        }

        if (isset($filter['search']) && strlen($filter['search'])) {
            $query->where(function($query) use ($filter) {
                $query->orWhere('title LIKE :search', ['search' => "%{$filter['search']}%"]);
            });
        }

        $count = $query->count();

        $query->orderBy('category_id ASC, title');

        if ($this['request']->isXmlHttpRequest()) {
            return $this['response']->json([
                'table' => $this['view']->render('extension://faq/views/admin/faqs/table.html.razr', ['count' => $count, 'items' => $query->get()]),
                'total' => $count
            ]);
        }

        return ['head.title' => __('Items'), 'items' => $query->get(), 'statuses' => Faq::getStatuses(), 'filter' => $filter, 'total' => $count, 'count' => $count, 'categories' => $this->categories->query()->get()];
    }

    /**
     * @Response("extension://faq/views/admin/faqs/edit.html.razr")
     */
    public function addAction()
    {
        return ['head.title' => __('Add FAQ'), 'item' => new Faq(), 'statuses' => Faq::getStatuses(), 'categories' => $this->categories->query()->get()];
    }

    /**
     * @Request({"id": "int"})
     * @Response("extension://faq/views/admin/faqs/edit.html.razr")
     */
    public function editAction($id)
    {
        try {

            if (!$faq = $this->faqs->find($id)) {
                throw new Exception(__('Invalid FAQ id.'));
            }

        } catch (Exception $e) {

            $this['message']->error($e->getMessage());

            return $this->redirect('@faq/faq');
        }

        return ['head.title' => __('Edit FAQ'), 'item' => $faq, 'statuses' => Faq::getStatuses(), 'categories' => $this->categories->query()->get()];
    }

    /**
     * @Request({"id": "int", "faq": "array"}, csrf=true)
     */
    public function saveAction($id, $data)
    {
        try {

            if (!$faq = $this->faqs->find($id)) {
                $faq = new Faq();
            }

            if ($this->faqs->where(['hashtag = ?', 'id <> ?'], [$data['hashtag'], $faq->getId()])->first()) {
                throw new Exception(__('FAQ hashtag not available.'));
            }

            $data['data'] = array_merge(['title' => 0, 'markdown' => 0], isset($data['data']) ? $data['data'] : []);

            $this->faqs->save($faq, $data);

            $response = ['message' => $id ? __('FAQ saved.') : __('FAQ created.'), 'id' => $faq->getId()];

        } catch (Exception $e) {
            $response = ['message' => $e->getMessage(), 'error' => true];
        }

        return $this['response']->json($response);
    }

    /**
     * @Request({"ids": "int[]"}, csrf=true)
     * @Response("json")
     */
    public function deleteAction($ids = [])
    {
        foreach ($ids as $id) {
            if ($faq = $this->faqs->find($id)) {
                $this->faqs->delete($faq);
            }
        }

        return ['message' => _c('{0} No FAQ deleted.|{1} FAQ deleted.|]1,Inf[ FAQs deleted.', count($ids))];
    }


    /**
     * @Request({"status": "int", "ids": "int[]"}, csrf=true)
     * @Response("json")
     */
    public function statusAction($status, $ids = [])
    {
        foreach ($ids as $id) {
            if ($faq = $this->faqs->find($id) and $faq->getStatus() != $status) {
                $faq->setStatus($status);
                $this->faqs->save($faq);
            }
        }

        if ($status == Faq::STATUS_PUBLISHED) {
            $message = _c('{0} No FAQ published.|{1} FAQ published.|]1,Inf[ FAQs published.', count($ids));
        } else {
            $message = _c('{0} No FAQ unpublished.|{1} FAQ unpublished.|]1,Inf[ FAQs unpublished.', count($ids));
        }

        return compact('message');
    }
}
