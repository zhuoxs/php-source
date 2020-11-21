$('.plant').click(function () {//显示农场二维码
    $('.md-overlay').css("opacity", 1).css('visibility', 'visible')
    $('#modal-2').addClass('md-show')
    $(document.body).css("overflow", 'hidden')
})
$('.plant div').click(function () {//显示农场二维码
    $('.md-overlay').css("opacity", 1).css('visibility', 'visible')
    $('#modal-2').addClass('md-show')
    $(document.body).css("overflow", 'hidden')
})
$('.plants').click(function () {//显示农场二维码
    $('.md-overlay').css("opacity", 1).css('visibility', 'visible')
    $('#modal-2').addClass('md-show')
    $(document.body).css("overflow", 'hidden')
})
$('.md-overlay').click(function () {//隐藏农场二维码
    $('.md-overlay').css("opacity", 0).css('visibility', 'hidden')
    $('#modal-2').removeClass('md-show')
    $(document.body).css("overflow", 'auto')
})

$('.md-overlay').bind("touchmove",function(e){
    e.preventDefault()
});
var isPlay = false
var myVideo = document.getElementById("video")
function play() {
    if (!isPlay) {
        myVideo.play()
        isPlay = true
    } else {
        myVideo.pause()
        isPlay = false
    }
}