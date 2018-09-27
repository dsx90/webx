$('.catalog').dcAccordion({
    speed: 300
});

function orderModal(client) {
    $('footer').html(client);
    $('#modal').modal();
}

$('.order_click').on('click', function (e) {
    e.preventDefault();
    var url = $(this).data('id');
    $.ajax({
        url: '/frontend/web/tehnic/frontend/tehnic-customer/add',
        data: {slug: url},
        type: 'GET',
        success: function (res) {
            if(!res) alert('Ошибка');
            //console.log(res);
            orderModal(res);
        },
        error: function() {
            alert('Error!');
        }
    })
})