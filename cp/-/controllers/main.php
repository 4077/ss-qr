<?php namespace ss\qr\cp\controllers;

class Main extends \Controller
{
    private $tree;

    public function __create()
    {
        if ($this->tree = $this->unpackModel('tree')) {
            $this->instance_($this->tree->id);
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
        $treeXPack = xpack_model($tree);

        $pluginData = ss()->trees->plugins->pluginData($tree, 'qr');

        $v->assign([
                       'BASE_URL_TXT' => $this->c('\std\ui txt:view', [
                           'path'              => '>xhr:updateBaseUrl',
                           'data'              => [
                               'tree' => $treeXPack
                           ],
                           'class'             => 'txt',
                           'fitInputToClosest' => '.control',
                           'placeholder'       => '...',
                           'content'           => ap($pluginData, 'base_url') ?: '...'
                       ]),
                   ]);

        $this->css();

        return $v;
    }
}
