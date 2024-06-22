function ShowPartnerships(url, newUrl) {
    $.ajax({
        type: "get",
        url: url,
        success: function(response) {
            if (response.stat) {
                if (response.partnerships.length > 0) {
                    $('#partnerships-table-body').html('');
                    var html = '';
                    index = 1;
                    response.partnerships.forEach(element => {
                        console.log(element);

                        html += '<tr>' +
                            '<td>' + index++ + '</td>' +
                            '<td>' + element.country_name + '</td>' +
                            '<td>' + element.start_date + '</td>' +
                            '<td>' + element.end_date + '</td>' +
                            '<td>' + element.exclusive + '</td>' +
                            '<td>' + element.active + '</td>' +
                            '<td>' + element.updated_at + '</td>' +
                            '<td>' +
                            '<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editPartnership" data-id="' + element.id + '" data-url="' + element.editUrl + '"><i class="fa fa-edit"></i>'
                        '</button>' +
                        '</td>' +
                        '</tr>';
                    });
                    //append
                    $('#partnerships-table-body').html(html);
                } else {
                    //html
                    var html = '<tr><td colspan="8" class="text-center">NO DATA</td></tr> '
                        //append
                    $('#partnerships-table-body').html(html);
                }
                //add data-url
                $("#addPartnership").attr('data-url', newUrl);
            }
        }
    });
}
//on addPartnership click
$("#addPartnership").click(function(e) {
    e.preventDefault();
    //hide modal
    $("#PartnershipsModal").modal('hide');
});
//on SavePartnerShip
$("#SavePartnerShip").click(function(e) {
    e.preventDefault();
    //get url from data url in addPartnership
    var url = $("#addPartnership").attr('data-url');
    //fromdata from partnership-form

    $.ajax({
        type: "post",
        url: url,
        data: $('#partnership-form').serialize(),
        success: function(response) {
            if (response.stat) {

                $('#editPartnership').modal('hide')
                $('#Partner-table').DataTable().ajax.reload();
            } else {
                //sweetalert
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.msg,
                });
            }
        }
    });
});
