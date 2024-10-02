var obj = [];
function ShowPartnerships(url, newUrl) {
    $.ajax({
        type: "get",
        url: url,
        success: function (response) {
            if (response.stat) {
                if (response.partnerships.length > 0) {
                    $('#partnerships-table-body').html('');
                    var html = '';
                    index = 1;
                    response.partnerships.forEach(element => {
                        //push each element to obj
                        obj.push(element);
                        html += '<tr>' +
                            '<td>' + index++ + '</td>' +
                            '<td>' + element.country_name + '</td>' +
                            '<td>' + element.start_date + '</td>' +
                            '<td>' + element.end_date + '</td>' +
                            '<td>' + element.exclusive + '</td>' +
                            '<td>' + element.active + '</td>' +
                            '<td>' + element.updated_at + '</td>' +
                            '<td>' +
                            '<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editPartnership" onclick="EditPartnership(' + element.id + ')" data-id="' + element.id + '" data-url="' + element.editUrl + '"><i class="fa fa-edit"></i>'
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
$("#addPartnership").click(function (e) {
    e.preventDefault();
    //hide modal
    $("#PartnershipsModal").modal('hide');
});
//on SavePartnerShip
$("#SavePartnerShip").click(function (e) {
    e.preventDefault();
    //get url from data url in addPartnership
    var url = $("#addPartnership").attr('data-url');
    //fromdata from partnership-form

    $.ajax({
        type: "post",
        url: url,
        data: $('#partnership-form').serialize(),
        success: function (response) {
            if (response.stat) {

                $('#editPartnership').modal('hide')
                $('#Partner-table').DataTable().ajax.reload();
                //reload location
                location.reload();
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
//EditPartnership with object
function EditPartnership(id) {
    //editPartnership
    //get an item from obj using id
    var item = obj.find(x => x.id == id);
    console.log(item);
    if (item.services) {
        services = JSON.parse(item.services);
        //get all services keys
        var keys = Object.keys(services);
        //for each key find html element using id or name
        //un-check all checkboxes that are id or name starting with s-
        $('input[type="checkbox"][id^="s-"]').prop('checked', false);
        keys.forEach(key => {
            $('#' + key).prop('checked', true);
        });
    }
    //set values
    setTimeout(function () {
        $("#end_date").val(item.end_date);
        $("#start_date").val(item.start_date);
        //set country option selected
        $("#country_ps").val(item.country_id);
        //bootstrapSwitch change state exclusivity
        $("#exclusivity").bootstrapSwitch('state', item.is_exclusive == 1 ? true : false);
        //bootstrapSwitch change state Partnershipstatus
        $("#Partnershipstatus").bootstrapSwitch('state', item.is_active == 1 ? true : false);
        $("#partnership_id").val(item.id);
    }, 1000);
}
