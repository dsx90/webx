$('.repeat-menutitle').click(function(){
    var text = $('#title').val();
    $('#resources-menutitle').val(text);
});
$('.translate-title').click(function(){
    var text = $('#title').val().toLowerCase();
    result = translit(text);
    $('#resources-url').val(result);
});

$('input#title').keyup(function(){
    $('span#title').text($(this).val());
});
$('input#longtitle').keyup(function(){
    $('span#longtitle').text($(this).val());
});
$('input#url').keyup(function(){
    $('span#url').text($(this).val());
});
$('textarea#description').keyup(function(){
    $('span#description').text($(this).val());
});

function orderModal(res) {
    $('forms').html(res);
    $('#forms').html();
}