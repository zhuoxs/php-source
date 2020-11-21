// 选项卡 鼠标点击
$(".TAB_CLICK li").click(function() {
    var tab = $(this).parent(".TAB_CLICK");
    var con = tab.attr("id");
    var on = tab.find("li").index(this);
    $(this).addClass('on').siblings(tab.find("li")).removeClass('on');
    $(con).eq(on).show().siblings(con).hide();
});

// 头部 点击下拉
$('.m-select .all').click(function() {
    $('.m-select .con').stop().slideToggle();
});

// 点击复制
$('#copy').click(function() {
    const range = document.createRange();
    range.selectNode(document.getElementById('word'));

    const selection = window.getSelection();
    if (selection.rangeCount > 0) selection.removeAllRanges();
    selection.addRange(range);

    document.execCommand('copy');
});

// 明文密文
$(function() {
    $('.js-check').click(function() {
        $(this).toggleClass('on');
        if ($('.js-inp').attr("type") == "password") {
            $('.js-inp').attr("type", "text");
        } else {
            $('.js-inp').attr("type", "password");
        }
    })
})