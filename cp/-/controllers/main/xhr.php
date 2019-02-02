<?php namespace ss\qr\cp\controllers\main;

class Xhr extends \Controller
{
    public $allow = self::XHR;

    public function updateBaseUrl()
    {
        if ($tree = $this->unxpackModel('tree')) {
            $txt = \std\ui\Txt::value($this);

            ss()->trees->plugins->pluginData($tree, 'qr', 'base_url', $txt->value);

            $txt->response();
        }
    }
}
