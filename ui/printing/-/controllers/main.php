<?php namespace ss\qr\ui\printing\controllers;

class Main extends \Controller
{
    private $s;

    private $tree;

    public function __create()
    {
        if ($target = _j64($this->data('target'))) {
            $this->s = $this->s($target['s_path']);
            $this->tree = unpack_model($target['tree']);
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

        $catsIds = $this->s['cats_ids'] ?? [];
        $productsIds = $this->s['products_ids'] ?? [];

        $layoutSettings = dataSets()->get('modules/ss-qr/printing:layout');

        $size = $layoutSettings['size'];
        $itemHMargin = ap($layoutSettings, 'item/h_margin');
        $itemVMargin = ap($layoutSettings, 'item/v_margin');
        $itemPadding = ap($layoutSettings, 'item/padding');
        $hintFontSize = ap($layoutSettings, 'hint/font_size');
        $hintHeight = ap($layoutSettings, 'hint/height');
        $hintHPadding = ap($layoutSettings, 'hint/h_padding');
        $hintVPadding = ap($layoutSettings, 'hint/v_padding');
        $borderWidth = $layoutSettings['border_width'];
        $hintWidth = $size - $hintHPadding * 2;

        $v->assign('css', [
            'HINT_FONT_SIZE' => $hintFontSize,
            'HINT_HEIGHT'    => $hintHeight,
            'HINT_WIDTH'     => $hintWidth,
            'HINT_H_PADDING' => $hintHPadding + $itemPadding,
            'HINT_V_PADDING' => $hintVPadding,
            'ITEM_H_MARGIN'  => $itemHMargin,
            'ITEM_V_MARGIN'  => $itemVMargin,
            'ITEM_PADDING'   => $itemPadding,
            'BORDER_WIDTH'   => $borderWidth
        ]);

        $baseUrl = trim_r_slash(ss()->trees->plugins->pluginData($tree, 'qr', 'base_url'));

        $punycode = new \TrueBV\Punycode();
        $baseUrl = $punycode->encode($baseUrl);

        $cats = table_rows_by_id(\ss\models\Cat::whereIn('id', $catsIds)->get());

        foreach ($catsIds as $n => $catId) {
            if ($cat = $cats[$catId] ?? false) {
                $url = $baseUrl . '/c/' . ($cat->articul ? $cat->articul : $cat->id);

                $v->assign('item', [
                    'HINT'    => $cat->name,
                    'NUMBER'  => $n,
                    'QR_CODE' => $this->c('\std\ui tag:view:img', [
                        'attrs' => [
                            'src'   => 'data:image/png;base64, ' . $this->qrCodeView($url, $size),
                            'title' => $url
                        ]
                    ])
                ]);
            }
        }

        $products = table_rows_by_id(\ss\models\Product::whereIn('id', $productsIds)->get());

        foreach ($productsIds as $n => $productId) {
            if ($product = $products[$productId] ?? false) {
                $url = $baseUrl . '/p/' . ($product->articul ? $product->articul : $product->id);

                $v->assign('item', [
                    'HINT'    => $product->name,
                    'NUMBER'  => $n,
                    'QR_CODE' => $this->c('\std\ui tag:view:img', [
                        'attrs' => [
                            'src'   => 'data:image/png;base64, ' . $this->qrCodeView($url, $size),
                            'title' => $url
                        ]
                    ])
                ]);
            }
        }

        $this->css();
        $this->widget(':');

        $this->jsRaw('window.print();');

        return $v;
    }

    private function qrCodeView($url, $size)
    {
        $qrCodeGenerator = new \SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;
        $qrCode = base64_encode($qrCodeGenerator->format('png')->encoding('utf-8')->margin(0)->size($size)->generate($url));

        return $qrCode;
    }
}
