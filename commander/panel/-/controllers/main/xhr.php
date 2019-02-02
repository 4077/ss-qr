<?php namespace ss\qr\commander\panel\controllers\main;

class Xhr extends \Controller
{
    public $allow = self::XHR;

    /**
     * @var $panel \ss\commander\Svc\Panel
     */
    private $panel;

    private $tree;

    private $cat;

    private $s;

    public function __create()
    {
        if ($this->panel = commanderPanel($this->_instance())) {
            $this->tree = $this->panel->getTree();
            $this->cat = $this->panel->getCat();

            $this->s = &$this->s('<|' . $this->_instance() . '/tree-' . $this->tree->id, [
                'cats_ids'     => [],
                'products_ids' => []
            ]);
        } else {
            $this->lock();
        }
    }

    public function add()
    {
        $items = $this->data('items');

        $catsIds = [];
        $productsIds = [];

        foreach ($items as $item) {
            if (in($item['type'], 'folder, page, container')) {
                $catsIds[] = $item['id'];
            }

            if ($item['type'] == 'product') {
                $productsIds[] = $item['id'];
            }
        }

        $s = &$this->s;

        foreach ($catsIds as $catId) {
            if (!in($catId, $s['cats_ids'])) {
                $s['cats_ids'][] = $catId;
            }
        }

        foreach ($productsIds as $productId) {
            if (!in($productId, $s['products_ids'])) {
                $s['products_ids'][] = $productId;
            }
        }

        $this->c('<:reload|');
    }

    public function clear()
    {
        ra($this->s, [
            'cats_ids'     => [],
            'products_ids' => []
        ]);

        $this->c('<:reload|');
    }

    public function delete()
    {
        $type = $this->data('type');
        $id = $this->data('id');

        if ($type == 'cat') {
            $catsIds = &$this->s('<:cats_ids');

            if (false !== $key = array_search($id, $catsIds)) {
                unset($catsIds[$key]);
            }
        }

        if ($type == 'product') {
            $productIds = &$this->s('<:products_ids');

            if (false !== $key = array_search($id, $productIds)) {
                unset($productIds[$key]);
            }
        }

        $this->c('<:reload');
    }
}
