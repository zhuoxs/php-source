$.fn.editable.defaults.params = function (params) {
    params._token = LA.token;
    params._editable = 1;
    params._method = 'PUT';
    return params;
};

$.fn.editable.defaults.error = function (data) {
    var msg = '';
    if (data.responseJSON.errors) {
        $.each(data.responseJSON.errors, function (k, v) {
            msg += v + '\n';
        });
    }
    return msg
};

toastr.options = {
    closeButton: true,
    progressBar: true,
    showMethod: 'slideDown',
    timeOut: 4000
};

$.pjax.defaults.timeout = 5000;
$.pjax.defaults.maxCacheLength = 0;
$(document).pjax('a:not(a[target="_blank"],a[no-pjax])', {
    container: '#pjax-container'
});

NProgress.configure({parent: '#pjax-container'});

$(document).on('pjax:timeout', function (event) {
    event.preventDefault();
})


$(document).on('submit', 'form[pjax-container]', function (event) {
    $.pjax.submit(event, '#pjax-container')
});


$(document).on("pjax:popstate", function () {

    $(document).one("pjax:end", function (event) {
        $(event.target).find("script[data-exec-on-popstate]").each(function () {
            $.globalEval(this.text || this.textContent || this.innerHTML || '');
        });
    });
});

$(document).on('pjax:send', function (xhr) {
    if (xhr.relatedTarget && xhr.relatedTarget.tagName && xhr.relatedTarget.tagName.toLowerCase() === 'form') {
        $submit_btn = $('form[pjax-container] :submit');
        if ($submit_btn) {
            $submit_btn.button('loading')
        }
    }
    NProgress.start();
});

$(document).on('pjax:complete', function (xhr) {
    if (xhr.relatedTarget && xhr.relatedTarget.tagName && xhr.relatedTarget.tagName.toLowerCase() === 'form') {
        $submit_btn = $('form[pjax-container] :submit');
        if ($submit_btn) {
            $submit_btn.button('reset')
        }
    }
    NProgress.done();
});
function change_sms_type(sms_type)
{

    if(sms_type == 0){
        $(".form-aliyun_appId").hide();
        $(".form-aliyun_appSecret").hide();
        $(".form-aliyun_sign").hide();
        $(".form-aliyun_order_template_code").hide();

        $(".form-cloud253_appId").show();
        $(".form-cloud253_appSecret").show();
        $(".form-cloud253_order_template_code").show();

    }else if(sms_type == 1){
        $(".form-cloud253_appId").hide();
        $(".form-cloud253_appSecret").hide();
        $(".form-cloud253_order_template_code").hide();


        $(".form-aliyun_appId").show();
        $(".form-aliyun_appSecret").show();
        $(".form-aliyun_sign").show();
        $(".form-aliyun_order_template_code").show();
    }
}
$(function () {
    $('.sidebar-menu li:not(.treeview) > a').on('click', function () {
        var $parent = $(this).parent().addClass('active');
        $parent.siblings('.treeview.active').find('> a').trigger('click');
        $parent.siblings().removeClass('active').find('li').removeClass('active');
    });


    var obj = $("input:radio[name='sms_type'][checked]");
    if(obj){
        var sms_type  = obj.val();
        change_sms_type(sms_type);
    }

    $("input:radio[name='sms_type']").on('ifChecked', function(event){
        console.log("radio change,val:" +  $(this).val());
        var sms_type  = $(this).val();
        change_sms_type(sms_type);
    });
    var current = $("ul>li>a.current");
    var ul = current.parent().parent();
    if(ul.hasClass("treeview-menu"))
    {
        current.parent().parent().addClass("menu-open");
        current.parent().parent().parent().addClass("active");
    }


    $('[data-toggle="popover"]').popover();
    $(document).on('change', ".goods_id", function () {
        var target = $(this).closest('.fields-group').find(".shop_price");
        var target2 = $(this).closest('.fields-group').find(".price");
        $.get("/web/index.php?c=home&a=welcome&do=ext&m=yzbld_sun&version_id=24&_do=api&_op=getGoodsShopPrice&q="+this.value, function (data) {
            $(target).val(data);
            $(target2).val(data);
        });
    });

});

(function ($) {
    $.fn.admin = LA;
    $.admin = LA;

})(jQuery);