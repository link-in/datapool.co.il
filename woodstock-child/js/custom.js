jQuery(function($) {
    $('body').on('change', '#file', function() {
        $this = $(this);
        file_data = $(this).prop('files')[0];
        form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append('action', 'file_upload');
        form_data.append('security', blog.security);

        $.ajax({
            url: blog.ajaxurl,
            type: 'POST',
            contentType: false,
            processData: false,
            data: form_data,
            success: function (response) {
                $this.val('');
                $('.table').html(response);
            }
        });
    });
});