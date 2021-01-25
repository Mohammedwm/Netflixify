$(document).ready(function (){
    $('#movie_file-input').on('change',function(){

        $('#movie_upload-wrapper').css('display','none');
        $('#movie_properties').css('display','block');

        var movie = this.files[0];
        var movieId = $(this).data('movie-id');
        var movieName = movie.name.split('.').slice(0,-1).join('.');
        $('#movie_name').val(movieName);

        var formData = new FormData();
        formData.append('movie_id',movieId);
        formData.append('name',movieName);
        formData.append('movie',movie);

        var url = $(this).data('url');
        $.ajax({
            url : url,
            data : formData,
            method :'POST',
            processData : false,
            contentType : false,
            cache : false,
            success:function(movieBeforProcessing){
                var interval = setInterval(function () {
                    
                    $.ajax({
                        url : `/dashboard/movies/${movieBeforProcessing.id}`,
                        method : 'GET',
                        success : function(movieWhileProcessing){
                            //console.log(movieWhileProcessing.percent);
                            $('#movie_upload-status').html('Progressing');
                            $('#movie_upload-progress').css('width',movieWhileProcessing.percent + '%');
                            $('#movie_upload-progress').html(movieWhileProcessing.percent + '%');

                            if(movieWhileProcessing.percent == 100){
                                clearInterval(interval); // break interval
                                $('#movie_upload-status').html('Done Progressing');
                                $('#movie_upload-progress').parent().css('display','none');
                                $('#movie_submit-btn').css('display','block');
                               
                            }
                        },
                    });

                },3000);
            },
            xhr:function (){
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress",function(evt){
                    if(evt.lengthComputable){
                        var percentComplete = Math.round(evt.loaded/evt.total * 100) + "%";
                        $('#movie_upload-progress').css('width',percentComplete).html(percentComplete);
                    }
                },false);
                return xhr;
            },
        });
        
    });
});