"use strict";
let layer = window.layer || null;

/**
 * 信息提示 并刷新跳转
 */
function laymsg(result, reload) {
    reload = reload || false;
    layer.msg(result.msg, {
        icon: result.code === 1 ? 6 : 5,
        scrollbar: false,
        time: 1500,
        shade: [0.6, '#000'],
        end: function () {
            if (result.url) {
                location.href = result.url;
            }
            if (reload) {
                location.reload();
            }
        }
    });
}

function layConfirm(result) {
    layer.msg(result.msg, {
        icon: result.code === 1 ? 6 : 5,
        scrollbar: false,
        time: 1500,
        shade: [0.6, '#000']
    });
}
