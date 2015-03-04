$(document).ready(function(){

    var table = $('#table');

    $('#name_header, #title_header, #genre_header')
        .each(function(){
            var th = $(this),
                thIndex = th.index(),
                inverse = false;

            th.click(function(){
                table.find('td').filter(function(){
                    return $(this).index() === thIndex;
                }).sortElements(function(a, b){
                    return $.text([a]) > $.text([b]) ?
                        inverse ? -1 : 1
                        : inverse ? 1 : -1;
                }, function(){
                    return this.parentNode;
                });
                inverse = !inverse;
            });
        });

    $('#1').parent('li').addClass('active');

    $('.pagination a').on('click', function(e){
        $('body li').removeClass('active');
        var page = $(this).attr('id');
        $(this).parent('li').addClass('active');
        e.preventDefault();
        loadElements(page);
    });
});

function loadElements(page){
    $('#content').html('');
    var params = {
        authors: $('#app_main_bundle_bookt_authors').val(),
        title: $('#app_main_bundle_bookt_title').val(),
        genre: $('#app_main_bundle_bookt_genre').find('[selected="selected"]').text(),
        isbn: $('#app_main_bundle_bookt_isbn').val()
    };
    $.ajax({
        url: '/load-elements',
        method: 'POST',
        data: {
            page: page,
            params: params
        },
        success: function(data){
            $('#content').append(data);
        }
    })
}