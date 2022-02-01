;(function($) {

    $('table.wp-list-table.contacts').on('click', 'a.submitdelete', function(e) {
        e.preventDefault();

        if (!confirm(ramLitAcademy.confirm)) {
            return;
        }

        var self = $(this),
            id = self.data('id');

        // wp.ajax.send('rm-academy-delete-contact', {
        //     data: {
        //         id: id,
        //         _wpnonce: ramLitAcademy.nonce
        //     }
        // })
        wp.ajax.post('rm-academy-delete-contact', {
            id: id,
            _wpnonce: ramLitAcademy.nonce
        })
        .done(function(response) {

            self.closest('tr')
                .css('background-color', 'red')
                .hide(400, function() {
                    $(this).remove();
                });

        })
        .fail(function() {
            alert(ramLitAcademy.error);
        });
    });

})(jQuery);
