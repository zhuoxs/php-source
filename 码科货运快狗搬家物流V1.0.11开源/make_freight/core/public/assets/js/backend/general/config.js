define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {

            $("#user_msg_tpl").click(function(){
                var data = $(this).data('id');
                Fast.api.ajax({
                    url:'general/config/registel_tpl',
                    data:{type:data},
                },
                    function(res){

                        if(res.errcode == 0 || res.msg == 'ok'){
                            $("#user_input_tpl").val(res.template_id);
                            $("#user_msg_tpl").html('已启用');
                        }
                    }
                )
            })

            $("#driver_msg_tpl").click(function(){
                var data = $(this).data('id');
                Fast.api.ajax({
                    url:'general/config/registel_tpl',
                    data:{type:data},
                },
                    function(res){
                        if(res.errcode == 0 || res.msg == 'ok'){
                            $("#driver_input_tpl").val(res.template_id);
                            $("#driver_msg_tpl").html('已启用')
                        }
                    }
                )
            })

            Controller.api.bindevent();
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        activity:function(){
            console.log(32233);
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});