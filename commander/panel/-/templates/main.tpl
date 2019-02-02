<div class="{__NODE_ID__} focusable {FOCUS_CLASS}" instance="{__INSTANCE__}">

    <div class="cp">
        {CLEAR_BUTTON}
        <div class="add button">Добавить выбранные</div>
        <a href="{PRINT_URL}" target="_blank" class="print button">Печать</a>
    </div>

    <div class="content">
        <div class="cats">
            <!-- cat -->
            <div class="cat">
                <a href="{URL}" target="ss_qr" class="qr_code">{QR_CODE}</a>
                <div class="name">
                    <div class="icon fa fa-folder"></div>
                    <div class="label">{NAME}</div>
                </div>
                <div class="buttons">
                    {DELETE_BUTTON}
                </div>
            </div>
            <!-- / -->
        </div>

        <div class="products">
            <!-- product -->
            <div class="product">
                <a href="{URL}" target="ss_qr" class="qr_code">{QR_CODE}</a>
                <div class="name">{NAME}</div>
                <div class="buttons">
                    {DELETE_BUTTON}
                </div>
            </div>
            <!-- / -->
        </div>
    </div>

</div>
