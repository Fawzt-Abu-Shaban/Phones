function sendMarkRequest(id = null){
    return $.ajax("{{route('markAsRead')}}" ,{
    method: 'POST',
    data:{
        _token,
        id
    }
    });
}

$(function() {
    $('.mark-as-read').click(function(){
        let request = sendMarkRequest($(this).data('id'));

        request.done(() => {
            $(this).parents('div.alert').remove();
        });
    });

    $('#mark-all').click(function(){
        let request = sendMarkRequest();

        request.done(() => {
            $('div.alert').remove();
        })
    });
});
