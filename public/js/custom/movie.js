$(document).ready(function () {

    let favCount = $('#nav_fav-count').data('fav-count');

    $(document).on('click', '.movie__fav-icon',function () {

        let url = $(this).data('url');
        let movieId = $(this).data('id');
        let isFavored = $(this).hasClass('fw-900');

        toggleFavored(url,movieId,isFavored);
       
    });

    $(document).on('click', '.movie__fav-btn',function () {

        let url = $(this).find('.movie__fav-icon').data('url');
        let movieId = $(this).find('.movie__fav-icon').data('id');
        let isFavored = $(this).find('.movie__fav-icon').hasClass('fw-900');

        toggleFavored(url,movieId,isFavored);
       
    });

    function toggleFavored(url,movieId,isFavored){

        !isFavored ? favCount++ : favCount-- ;
        
        favCount > 9 ? $('#nav_fav-count').html('9+') : $('#nav_fav-count').html(favCount);

        $('.movie-' + movieId).toggleClass('fw-900');

        if($('.movie-' + movieId).closest('.favorite').length){
            $('.movie-' + movieId).closest('.movie').remove();
        } // end of if

        $.ajax({
            url : url,
            method : 'POST'
        });
    }

});