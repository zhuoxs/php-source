define([], function () {
    var modal = {};
    modal.init = function (params) {
        //  alert(params.view);
        // if(params.view=='gird'){
        //     $('.card-group-list').addClass('in');
        // }

        $('.cutlist-card').click(function () {
            $('.card-group-list').toggleClass('in');
            $('.list-group').toggleClass('none');
            $('#list-icon').toggleClass('icow-list1');
            $('#list-icon').toggleClass('icow-liebiao');
            // $('#list-icon').toggle(
            //     function () {
            //         $(this).addClass("icow-list1");
            //         // $(this).addClass("icow-list1")
            //     },
            //     function () {
            //         // $(this).addClass("icow-liebiao");
            //         $(this).removeClass("icow-list1");
            //     }
            // );

        })
    };
    return modal;
});