define(['core', 'tpl'], function (core, tpl) {
    var modal = {cards: [],card_id: 0, card_name:'',card_price:'', };
    var Picker = function (params) {
        var self = this;
        self.params = $.extend({}, params || {});
        self.data = {cards: self.params.cards,};
        self.show = function () {
            if (self.data.cards !== modal.cards) {
                modal.pickerHTML = tpl('tpl_cards', self.data)
            }
            modal.cards = self.data.cards;


            modal.picker = new FoxUIModal({
                content: modal.pickerHTML,
               extraClass: 'picker-modal',
                maskClick: function () {
                    modal.picker.close()
                }
            });
            modal.picker.show();
            if($('#selectCard').find('.fui-cell-label').text()=='不使用会员卡')
            {
                $('.btn-card-cancel').addClass('activeselect');

            }
            $('.card-picker').find('.iconselect .activeselect').removeClass('activeselect');
            $('.card-picker').find(".iconselect[data-cardid='" + self.params.card_id + "']").addClass('activeselect');

            $('.card-picker').find('.iconselect').click(function () {
                $('.card-picker').find('.iconselect.activeselect').removeClass('activeselect');
                $(this).addClass('activeselect');
                modal.card_id = $(this).data('cardid');
                modal.card_name = $(this).data('cardnname');
                modal.card_price = $(this).data('cardprice');
                var data = {
                    card_id:modal.card_id,
                    card_name:modal.card_name,
                    card_price:modal.card_price,
                };
                if (self.params.onSelected) {
                    self.params.onSelected(data)
                }
                modal.picker.close()

            });
            $('.card-list-cancel').find('.btn-card-cancel').click(function () {
                $(this).addClass('activeselect');
                modal.card_id = 0;
                modal.card_name = '';
                modal.card_price = '';
                 modal.picker.close();
                 self.params.onCaculate();
                if (self.params.onCancel) {
                    self.params.onCancel()
                }
            });

        }
    };
    modal.show = function (params) {
        var picker = new Picker(params);
        picker.show()
    };
    return modal
});