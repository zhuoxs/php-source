/**
 * Created by smiler on 2019/1/16.
 */
var title = "温馨提示";
$('.liuer-delete').click(function(){
    var url = $(this).prop('href');
    layer.confirm('确定要删除吗？', {
        btn: ['确定','取消'], //按钮,
        title: title,
        icon: 3
    }, function(){
        location.href = url;
    }, function(){

    });
    return false;
})

$('.liuer-abandon').click(function(){
    var url = $(this).prop('href');
    layer.confirm('确定要禁用吗？', {
        btn: ['确定','取消'], //按钮,
        title: title,
        icon: 3
    }, function(){
        location.href = url;
    }, function(){

    });
    return false;
})