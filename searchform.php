<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search"  class="search-field" placeholder="Search the Blog" value="<?php echo get_search_query(); ?>" name="s" />
	 <input type="hidden" name="post_type" value="post" />
	<button type="submit" class="search-submit icon-search5"></button>
</form>

<div class="scontent"></div>

<script>
    jQuery(function($){
        function get_results(){
            var url = window.location.origin+'/eveal/wp-json/vt/v1/posts/';
            var request = $.ajax({ url: url , method: "GET", dataType: "json", });
            request.done(function(data) {
                var response = data;
                if(response.length > 0){
                    var result = response.map(function(res){
                        row = 
                        `<div class='row'>

                            ${ (res.thumbnail) != false ? '<img src='"'${res.thumbnail}'"' alt="">' : ''}

                            <a href='${res.url}'>${res.title} </a>
                            <p> ${res.content}</p>
                        </div>`;
                        return row;
                    }).join('');
                    $('.scontent').html(result);
                }else{
                    $('.scontent').html('');
                }
            });   
        }
        get_results();
        function filter_search_result(search_str){
            $('.scontent .row').hide();
            $('.scontent .row').each(function(){
                var arr_str = search_str.split(' ');
                var vts = $(this).text().toLowerCase().replace(' ','');
                var temp = $(this);
                arr_str.map(function(x){    
                   if(vts.indexOf(x) >= 0 ){
                        temp.show();
                    }
                });
            });
            $('.scontent').show('100');
        }
        $(document).on('keyup', function(event) {
            if($('.search-field').val().length > 3){
                $('.search-field').val().toLowerCase();
                filter_search_result($('.search-field').val().toLowerCase());
            }else{
                $('.scontent').hide('50');
            }
        });
    });
</script>