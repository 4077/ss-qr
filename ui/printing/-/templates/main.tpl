<div class="{__NODE_ID__}" instance="{__INSTANCE__}">

    <!-- css -->
    <style type="text/css">
        .{~__NODE_ID__} {
            font-family: verdana, arial, sans-serif;
        }

        .{~__NODE_ID__} .item {
            margin: {ITEM_V_MARGIN}px {ITEM_H_MARGIN}px;
            padding: {ITEM_PADDING}px;
            display: inline-block;
        }

        .{~__NODE_ID__} .hint {
            font-size: {HINT_FONT_SIZE}px;
            width: {HINT_WIDTH}px;
            height: {HINT_HEIGHT}px;
            padding: {HINT_V_PADDING}px {HINT_H_PADDING}px;
            border: {BORDER_WIDTH}px solid #000000;
            border-bottom: 0;
            overflow: hidden;
        }

        .{~__NODE_ID__} .qr_code {
            padding: {ITEM_PADDING}px;
            border: {BORDER_WIDTH}px solid #000000;
        }
    </style>
    <!-- / -->

    <div class="items">
        <!-- item -->
        <div class="item" hover="hover" number="{NUMBER}">
            <div class="hint">{HINT}</div>
            <div class="qr_code">{QR_CODE}</div>
        </div>
        <!-- / -->
    </div>

</div>
