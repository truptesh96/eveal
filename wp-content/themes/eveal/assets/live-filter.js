jQuery(document).ready(function($) {
    $('.live-filter-form').on('change', 'select', function(e) {
        e.preventDefault();
        var form = $(this).closest('.live-filter-form');
        var resultsContainer = form.next('.live-filter-results');
        var formData = form.serialize();
        $.ajax({
            url: wp_live_filter_params.ajax_url,
            type: 'POST',
            data: formData,
            beforeSend: function() {
                resultsContainer.html('<div class="lf-loading">Loading posts...</div>');
                resultsContainer.css('opacity', '0.5');
            },
            success: function(response) {
                resultsContainer.css('opacity', '1');
                if (response.success) {
                    resultsContainer.html(response.data.html);
                } else {
                    resultsContainer.html('<div class="lf-error">' + response.data.message + '</div>');
                }
            },
            error: function() {
                resultsContainer.css('opacity', '1');
                resultsContainer.html('<div class="lf-error">An unexpected error occurred. Please try again.</div>');
            }
        });
    });
    $('.live-filter-form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var resultsContainer = form.next('.live-filter-results');
        var formData = form.serialize();
        $.ajax({
            url: wp_live_filter_params.ajax_url,
            type: 'POST',
            data: formData,
            beforeSend: function() {
                resultsContainer.html('<div class="lf-loading">Loading posts...</div>');
                resultsContainer.css('opacity', '0.5');
            },
            success: function(response) {
                resultsContainer.css('opacity', '1');
                if (response.success) {
                    resultsContainer.html(response.data.html);
                } else {
                    resultsContainer.html('<div class="lf-error">' + response.data.message + '</div>');
                }
            },
            error: function() {
                resultsContainer.css('opacity', '1');
                resultsContainer.html('<div class="lf-error">An unexpected error occurred. Please try again.</div>');
            }
        });
    });
});