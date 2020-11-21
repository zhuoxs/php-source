define(['core', 'tpl'], function(core, tpl) {
    var modal = {
        page: 1,
        status: ''
    };
    modal.init = function() {
        FoxUI.tab({
            container: $('#tab'),
            handlers: {
                'status1': function() {
                    modal.changeTab(1)
                },
                'status2': function() {
                    modal.changeTab(2)
                },
                'status3': function() {
                    modal.changeTab(3)
                },
                'status_1': function() {
                    modal.changeTab(-1)
                }
            }
        });
        $('.fui-content').infinite({
            onLoading: function() {
                modal.getList()
            }
        });
        if (modal.page == 1) {
            modal.getList()
        }
    };
    modal.changeTab = function(status) {
        $('.fui-content').infinite('init');
        $('.content-empty').hide(), $('.infinite-loading').show(), $('#container').html('');
        modal.page = 1, modal.status = status, modal.getList()
    };
    modal.getList = function() {
        core.json('merchmanage/apply/get_list', {
            page: modal.page,
            status: modal.status
        }, function(ret) {
            var result = ret.result;
            $('#total').html(result.total);
            if (result.total <= 0) {
                $('.content-empty').show();
                $('#container').hide();
                $('.fui-content').infinite('stop')
            } else {
                $('#container').show();
                $('.content-empty').hide();
                $('.fui-content').infinite('init');
                if (result.list.length <= 0 || result.list.length < result.pagesize) {
                    $('.fui-content').infinite('stop')
                }
            }
            modal.page++;
            core.tpl('#container', 'tpl_apply_log_list', result, modal.page > 1)
        })
    };
    
    return modal
});