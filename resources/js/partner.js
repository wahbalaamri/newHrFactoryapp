var element = document.getElementById("PartnerEdit");
let url = element.getAttribute('data-url');
let url2 = element.getAttribute('data-url2');

$('#Partner-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: url,
    columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            // "render": function(data, type, row) {
            //     return '<button class="btn btn-xs btn-success mr-3 ml-3 text-xs show-more" data-id="' + row.id + '"><i class="fa fa-eye"></i></button>';
            // }
        },
        { data: 'name', name: 'name' },
        { data: 'country', name: 'country' },
        {
            data: 'Partnership',
            name: 'Partnership',
            "render": function(data, type, row) {
                return '<button class="btn btn-xs btn-info mr-3 ml-3 text-xs show-more" onclick="ShowPartnerships(\'' + row.Partnerships + '\',\'' + row.SavePartnerships + '\')"  data-id="' + row.id + '" data-toggle="modal" data-target="#PartnershipsModal"><span>Partnerships: <span title="This Partner is available in' + row.partnerships_count + 'Country/Countries" class="badge bg-warning">' + row.partnerships_count + '</span></span></button>';
            }
        },
        {
            data: 'FocalPoints	',
            name: 'FocalPoints	',
            "render": function(data, type, row) {
                return '<a href="javascript:void(0)" onclick="ShowPartnerFocalPoints(\'' + row.FocalPoints + '\',\'' + row.SaveFocalPoints + '\')" class="btn btn-xs btn-success mr-3 ml-3 text-xs show-more" data-id="' + row.id + '" data-toggle="modal" data-target="#focalPointsModal"><span>' + row.name + ' Focal Points: <span title="' + row.focal_points_count + ' direct Contact" class="badge bg-warning">' + row.focal_points_count + '</span></span></a>';
            },

        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false,

        },
    ],
    //on ready
    "drawCallback": (s) => {
        // console.log("ss");
    },
    //on error
    "error": (s) => {
            console.log("error");
        }
        //on event inside table


});
//$('#Partner-table') width 100
$('#Partner-table').css('width', '100%');
//on website change
$('#website').on('change', function() {
    var website = $(this).val();
    //check if it's containing http:// or https://
    if (website.includes("http://") || website.includes("https://")) {
        //if http:// update the prepend
        if (website.includes("http://")) {
            website = website.replace("http://", "");
            //get previouse element
            var prev = $('#website').prev();
            // get first child of prev
            var first = prev.children().first();
            //update the first child
            first.text("http://");
        }
        //if https:// update the prepend
        if (website.includes("https://")) {
            website = website.replace("https://", "");
            //get previouse element
            var prev = $('#website').prev();
            // get first child of prev
            var first = prev.children().first();
            //update the first child
            first.text("https://");
        }
        $('#website').val(website);
    } else {
        $('#website').val(website);
    }
});
// on SavePartner clicked
$("#SavePartner").click(() => {
    //check if id is null
    if ($('#id').val() == '') {
        //if null add new partner
        addPartner();
    } else {
        //if not null update partner
        updatePartner();
    }
});
//add new partner
function addPartner() {
    //get all values
    var name = $('#name').val();
    var country = $('#country').val();
    var website = $('#website').val();
    var logo = $('#logo').prop('files')[0];
    //if Pstatus check
    if ($('#Pstatus').is(':checked')) {
        var Pstatus = 1;
    } else {
        var Pstatus = 0;
    }
    //check if name input are filled
    if (name == '') {
        //sweetalert
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "You need to fill partner name",
        });
        return;
    }
    //check if country input are filled
    if (country == '') {
        //sweetalert
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "You need to select partner country",
        });
        return;
    }
    var formData = new FormData();
    formData.append('name', name);
    formData.append('country', country);
    formData.append('website', website);
    formData.append('logo', logo);
    formData.append('Pstatus', Pstatus);
    formData.append('_token', $('input[name="_token"]').val());
    //send request to add new partner
    $.ajax({
        type: "POST",
        url: url2,
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            //if success reload the table
            if (response.stat) {
                //sweetalert
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.msg,
                });
                $('#Partner-table').DataTable().ajax.reload();
                //clear all inputs
                clearInputs();
            } else {
                //sweetalert
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.msg,
                });
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
}