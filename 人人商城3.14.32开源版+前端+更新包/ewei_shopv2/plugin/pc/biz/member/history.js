define(['core', 'tpl'], function(core, tpl) {
    var modal = {
        page: 1,
        status:'history',
    };
    modal.init = function() {
        $('.btn-edit').click(function() {
            modal.changeMode()
        });
        $('.editcheckall').click(function() {
            var checked = $(this).find(':checkbox').prop('checked');
            $(".edit-item").prop('checked', checked);
            modal.caculateEdit()
        });
        $('.btn-delete').click(function() {
            if ($('.edit-item:checked').length <= 0) {
                return
            }
            modal.remove()
        })
    };
    modal.caculateEdit = function() {
        $('.editcheckall .fui-radio').prop('checked', $('.edit-item').length == $('.edit-item:checked').length);
        var selects = $('.edit-item:checked').length;
        if (selects > 0) {
            $('.btn-delete').removeClass('disabled')
        } else {
            $('.btn-delete').addClass('disabled')
        }
    };
    modal.changeMode = function() {
        if ($('.goods-item').length <= 0) {
            $('.container').remove();
            $('.btn-edit').remove();
            $('.editmode').remove();
            $('.content-empty').show();
            return
        }

        if (modal.status == 'history') {
            $('.edit-item').prop('checked', false);
            $('.editcheckall').prop('checked', false);
            $('.editmode').show();
            modal.status = 'edit';
            $('.btn-edit').html('完成')
        } else {
            $('.editmode').hide();
            modal.status = 'history';
            $('.btn-edit').html('编辑')
        }
    };
    modal.remove = function(ids, callback) {
        var ids = [];
        $('.edit-item:checked').each(function() {
            var id = $(this).closest('.goods-item').data('id');
            ids.push(id)
        });
        if (ids.length <= 0) {
            return
        }
        FoxUI.confirm('确认删除这些足迹吗?', function() {
            core.json('pc.member.history.remove', {
                ids: ids
            }, function(ret) {
                if (ret.status == 0) {
                    FoxUI.toast.show(ret.result);
                    return
                }
                $.each(ids, function() {
                    $(".goods-item[data-id='" + this + "']").prev().remove();
                    $(".goods-item[data-id='" + this + "']").remove()
                });
                modal.changeMode()
            }, true, true)
        })
    };
    return modal
});