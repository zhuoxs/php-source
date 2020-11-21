function timer(intDiff){

    window.setInterval(function(){

        var day=0,

            hour=0,

            minute=0,

            second=0;//时间默认值

        if(intDiff > 0){

            day = Math.floor(intDiff / (60 * 60 * 24));

            hour = Math.floor(intDiff / (60 * 60)) - (day * 24);

            minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);

            second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);

        }

        if (hour <= 9) hour = '0' + hour;

        if (minute <= 9) minute = '0' + minute;

        if (second <= 9) second = '0' + second;


        $('#hour_show').html('<s id="h"></s>'+hour);

        $('#minute_show').html('<s></s>'+minute);

        $('#second_show').html('<s></s>'+second);

        intDiff--;
        $('.seckill').show();

    }, 1000);

}