<?php namespace ss\qr\commander\panel\controllers;

class Main extends \Controller
{
    /**
     * @var $panel \ss\commander\Svc\Panel
     */
    private $panel;

    private $tree;

    private $cat;

//    private $sPanel;

    private $s;

    public function __create()
    {
        if ($this->panel = commanderPanel($this->_instance())) {
            $this->tree = $this->panel->getTree();
            $this->cat = $this->panel->getCat();

//            $this->sPanel = &$this->s('~:|' . $this->_instance() . '/tree-' . $this->tree->id);

            $this->s = &$this->s('|' . $this->_instance() . '/tree-' . $this->tree->id, [
                'cats_ids'     => [],
                'products_ids' => []
            ]);
        } else {
            $this->lock();
        }
    }

    public function reload()
    {
        $this->jquery('|')->replace($this->view());
    }

    public function view()
    {
        $v = $this->v('|');

        $tree = $this->tree;
        $cat = $this->cat;

        $catsIds = ap($this->s, 'cats_ids');
        $productsIds = ap($this->s, 'products_ids');

        $cats = table_rows_by_id(\ss\models\Cat::whereIn('id', $catsIds)->get());

        $baseUrl = trim_r_slash(ss()->trees->plugins->pluginData($tree, 'qr', 'base_url'));

        $punycode = new \TrueBV\Punycode();
        $baseUrl = $punycode->encode($baseUrl);

        foreach ($catsIds as $catId) {
            if ($cat = $cats[$catId] ?? false) {
                $url = $baseUrl . '/c/' . ($cat->articul ? $cat->articul : $cat->id);

                $v->assign('cat', [
                    'NAME'          => $cat->name,
                    'QR_CODE'       => $this->qrCodeView($url),
                    'URL'           => $url,
                    'DELETE_BUTTON' => $this->c('\std\ui button:view', [
                        'path'  => '>xhr:delete|',
                        'data'  => [
                            'type' => 'cat',
                            'id'   => $catId
                        ],
                        'class' => 'delete button',
                        'icon'  => 'fa fa-trash'
                    ])
                ]);
            }
        }

        $products = table_rows_by_id(\ss\models\Product::whereIn('id', $productsIds)->get());

        foreach ($productsIds as $productId) {
            if ($product = $products[$productId] ?? false) {
                $url = $baseUrl . '/p/' . ($product->articul ? $product->articul : $product->id);

                $v->assign('product', [
                    'NAME'          => $product->name,
                    'QR_CODE'       => $this->qrCodeView($url),
                    'URL'           => $url,
                    'DELETE_BUTTON' => $this->c('\std\ui button:view', [
                        'path'  => '>xhr:delete|',
                        'data'  => [
                            'type' => 'product',
                            'id'   => $productId
                        ],
                        'class' => 'delete button',
                        'icon'  => 'fa fa-trash'
                    ])
                ]);
            }
        }

        $target = j64_([
                           's_path' => $this->_p() . '|' . $this->_instance() . '/tree-' . $tree->id,
                           'tree'   => pack_model($tree)
                       ]);

        $v->assign([
                       'FOCUS_CLASS'  => $this->panel->hasFocus('plugins') ? 'focus' : '',
                       'CLEAR_BUTTON' => $this->c('\std\ui button:view', [
                           'path'    => '>xhr:clear|',
                           'class'   => 'clear button',
                           'content' => 'Очистить'
                       ]),
                       'PRINT_URL'    => abs_url('cp/ss/qr-codes/printing/' . $target)
                   ]);

        $this->css(':\css\std~');

        $this->widget(':|', [
            '.w' => [
                'main'    => $this->_w('\ss\commander\ui~:|' . $this->panel->commander->instance),
                'panel'   => $this->_w('\ss\commander\ui\panel~:|' . $this->panel->instance),
                'content' => $this->_w('\ss\commander\ui\panel~content/' . $this->tree->mode . ':|' . $this->panel->instance)
            ],
            '.r' => [
                'add' => $this->_p('>xhr:add|')
            ]
        ]);

        return $v;
    }

    public function qrCodeView($qrCodeContent)
    {
        $qrCodeGenerator = new \SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

        $inFocusQrCode = base64_encode($qrCodeGenerator->format('png')->encoding('utf-8')->size(100)->generate($qrCodeContent));
        $notInFocusQrCode = base64_encode($qrCodeGenerator->format('png')->encoding('utf-8')->size(100)->backgroundColor(245, 245, 245)->generate($qrCodeContent));

        return $this->c('\std\ui tag:view:img', [
                'attrs' => [
                    'class' => 'in_focus',
                    'src'   => 'data:image/png;base64, ' . $inFocusQrCode
                ]
            ]) . $this->c('\std\ui tag:view:img', [
                'attrs' => [
                    'class' => 'not_in_focus',
                    'src'   => 'data:image/png;base64, ' . $notInFocusQrCode
                ]
            ]);
    }
}
