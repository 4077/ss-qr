// head {
var __nodeId__ = "ss_qr_ui_printing__main";
var __nodeNs__ = "ss_qr_ui_printing";
// }

(function (__nodeNs__, __nodeId__) {
    $.widget(__nodeNs__ + "." + __nodeId__, $.ewma.node, {
        options: {},

        selected: null,

        __create: function () {
            var w = this;
            var o = w.options;
            var $w = w.element;

            $(".item", $w).rebind("click", function () {
                if (w.selected === $(this).attr("number")) {
                    $(".qr_code img", $w).css({opacity: 1});

                    w.selected = null;
                } else {
                    $(".qr_code img", $w).css({opacity: 0.05});

                    $(this).find("img").css({opacity: 1});

                    w.selected = $(this).attr("number");
                }
            });
        }
    });
})(__nodeNs__, __nodeId__);
