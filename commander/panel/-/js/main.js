// head {
var __nodeId__ = "ss_qr_commander_panel__main";
var __nodeNs__ = "ss_qr_commander_panel";
// }

(function (__nodeNs__, __nodeId__) {
    $.widget(__nodeNs__ + "." + __nodeId__, $.ewma.node, {
        options: {},

        __create: function () {
            var w = this;
            var o = w.options;
            var $w = w.element;

            w.bind();
        },

        bind: function () {
            var w = this;
            var o = w.options;
            var $w = w.element;

            $w.on("click", function () {
                w.w('panel').focus('plugins');
            });

            // add button

            var $addButton = $(".add.button", $w);

            $addButton.on("click", function () {
                var preparedItems = w.w('content').getPreparedItems();

                w.r('add', {
                    items: preparedItems
                });
            });

            $addButton.mouseenter(function () {
                var preparedItems = w.w('content').getPreparedItems();

                w.w('content').highlight(preparedItems, 'highlight source');
            }).mouseleave(function () {
                var preparedItems = w.w('content').getPreparedItems();

                w.w('content').unhighlight(preparedItems, 'highlight source');
            });
        }
    });
})(__nodeNs__, __nodeId__);
