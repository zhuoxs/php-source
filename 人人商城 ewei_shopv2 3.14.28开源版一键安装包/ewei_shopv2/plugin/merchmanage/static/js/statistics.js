define(['core', 'tpl'], function(core, tpl) {
    var modal = {
        type:0
    };
    modal.init = function(params) {
        modal.getTypeSale(modal.type);
        $(document).on('click','.fui-tab-o a',function () {
            var type = $(this).attr("data-type");
            $('.fui-tab-o a').removeClass('active');
            $(this).addClass('active');
            modal.changeType(type);
        })
        $(document).on('click','#tab a',function () {
            var status = $(this).attr("data-status");
            $('#tab a').removeClass('active');
            $(this).addClass('active');
            modal.changeTab(status);
        })
    };
    modal.changeTab = function(status) {
       
        $('#container').html('');
        if (status == 'sale') {
            modal.changeType(modal.type);
        }else if (status =='sale_analysis'){
            html = $('.sale_analysis').html();
            $('#container').html(html);
        }
    };
    modal.changeType = function(type) {
        $('.fui-content').infinite('init');
        $('.content-empty').hide(),  $('#container').html('');
        modal.type = type;
        modal.getTypeSale(type);
    };
    modal.getTypeSale = function(type) {
        core.json('merchmanage/statistics/getsale', {
            type: modal.type
        }, function(ret) {
            var result = ret.result;
            core.tpl('#container', 'tpl_sale_list', result)
        })
    };
    return modal
});