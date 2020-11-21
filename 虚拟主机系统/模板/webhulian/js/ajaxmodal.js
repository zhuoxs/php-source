/*!
 * WHMCS Ajax Driven Modal Framework
 *
 * @copyright Copyright (c) WHMCS Limited 2005-2015
 * @license http://www.whmcs.com/license/ WHMCS Eula
 */
jQuery(document).ready(function(){
    jQuery('.open-modal').click(function(e) {
        e.preventDefault();
        var url = jQuery(this).attr('href'),
            modalSize = jQuery(this).data('modal-size'),
            modalTitle = jQuery(this).data('modal-title'),
            submitId = jQuery(this).data('btn-submit-id'),
            submitLabel = jQuery(this).data('btn-submit-label');

        openModal(url, '', modalTitle, modalSize, submitLabel, submitId);
    });

    // define modal close reset action
    jQuery('#modalAjax').modal('hide').on('hidden', function(){
        jQuery('#modalAjax').find('.modal-body').empty();
        jQuery('#modalAjax').children('div[class="modal-dialog"]').removeClass('modal-lg');
        jQuery('#modalAjax .modal-title').html('Title');
        jQuery('#modalAjax .modal-submit').html('Submit');
        jQuery('#modalAjax .modal-submit').removeAttr('id');
        jQuery('#modalAjax .loader').show();
    });
});

function openModal(url, postData, modalTitle, modalSize, submitLabel, submitId) {

    //set the text of the modal title
    jQuery('#modalAjax .modal-title').html(modalTitle);

    // set the modal size via a class attribute
    if (modalSize) {
        jQuery('#modalAjax').children('div[class="modal-dialog"]').addClass(modalSize);
    }

    // set the text of the submit button
    if(!submitLabel){
       jQuery('#modalAjax .modal-submit').hide();
    } else {
        jQuery('#modalAjax .modal-submit').show().html(submitLabel);
        // set the button id so we can target the click function of it.
        if (submitId) {
            jQuery('#modalAjax .modal-submit').attr('id', submitId);
        }
    }

    // show modal
    jQuery('#modalAjax').modal('show');

    // fetch modal content
    jQuery.post(url, postData, function(data) {
        updateAjaxModal(data);
    }, 'json').fail(function() {
        jQuery('#modalAjax .modal-body').html('An error occurred while communicating with the server. Please try again.');
        jQuery('#modalAjax .loader').fadeOut();
    });

    //define modal submit button click
    if (submitId) {
        jQuery('#' + submitId).on('click', function() {
            var modalForm = jQuery('#modalAjax').find('form');
            jQuery('#modalAjax .loader').show();
            jQuery.post(modalForm.attr('action'), modalForm.serialize(),
                function(data) {
                    updateAjaxModal(data);
                }, 'json').fail(function() {
                    jQuery('#modalAjax .modal-body').html('An error occurred while communicating with the server. Please try again.');
                    jQuery('#modalAjax .loader').fadeOut();
                }
            );
        })
    }
}

function updateAjaxModal(data) {
    if (data.dismiss) {
        jQuery('#modalAjax').modal('hide');
    }
    if (data.successMsg) {
        jQuery.growl.notice({ title: data.successMsgTitle, message: data.successMsg });
    }
    if (data.title) {
        jQuery('#modalAjax .modal-title').html(data.title);
    }
    if (data.body) {
        jQuery('#modalAjax .modal-body').html(data.body);
    }
    if (data.submitlabel) {
        jQuery('#modalAjax .modal-submit').html(data.submitlabel);
    }
    jQuery('#modalAjax .loader').fadeOut();
}

// backwards compat for older dialog implementations

function dialogSubmit() {
    jQuery('#modalAjax .loader').show();
    jQuery.post('', jQuery('#modalAjax').find('form').serialize(),
        function(data) {
            updateAjaxModal(data);
        }, 'json').fail(function() {
            jQuery('#modalAjax .modal-body').html('An error occurred while communicating with the server. Please try again.');
            jQuery('#modalAjax .loader').fadeOut();
        });
}

function dialogClose() {
    jQuery('#modalAjax').modal('hide');
}
