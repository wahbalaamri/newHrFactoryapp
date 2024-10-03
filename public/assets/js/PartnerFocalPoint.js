let myUrl = "";

function ShowPartnerFocalPoints(url, newUrl) {
    // $('#focalPointsModal').modal('show');
    myUrl = url;
    //ajax call to retrive partner focal points
    $.ajax({
        url: url,
        type: 'GET',
        success: function (data) {
            //check stat
            if (data.stat) {
                if (data.focal_points.length > 0) {
                    var html = getHtmlFormOfData(data.focal_points);
                    $("#FocalPointTableBody").html("");
                    $("#FocalPointTableBody").html(html);
                } else {
                    $("#FocalPointTableBody").html('<tr><td colspan="8" class="text-center">NO DATA</td></tr>')
                }
                //add parameter to SaveFocalPoint
                $("#SaveFocalPointbtn").attr('data-url', newUrl);
            } else {
                //sweet alert
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.msg,
                    button: "Ok",
                });
            }
        },
        error: function () {
            alert('An error occurred');
        }
    });
}

function hideModal(id) {
    $('#' + id).modal('hide');
}
//on SaveFocalPointbtn clicked
function SaveFocalPoint(btn) {
    //find data-url from btn
    var url = $(btn).data('url');
    console.log(url);
    //ajax call
    $.ajax({
        url: url,
        type: 'POST',
        data: $('#FocalPointForm').serialize(),
        success: function (data) {
            //check stat
            if (data.stat) {
                var html = getHtmlFormOfData(data.focals);
                $("#FocalPointTableBody").html("");
                $("#FocalPointTableBody").html(html);
                console.log(data);
                hideModal('EditfocalPointsModal')
                //reload datatable Partner-table
                $('#Partner-table').DataTable().ajax.reload();
                //reset all fields
                $('#FocalPointForm').trigger('reset');
            }
        },
        error: function () {
            alert('An error occurred');
        }
    });
}

function getHtmlFormOfData(focal_points) {
    var html = '';
    index = 1;
    focal_points.forEach(element => {
        F_status = element.is_active ? "Active" : "Inactive";
        Focal_p=JSON.stringify(element)
        html += `<tr><td>${index++}</td>
        <td>${element.name}</td>
        <td>${element.Email}</td>
        <td>${element.phone}</td>
        <td>${element.position}</td>
        <td>${F_status}</td>
        <td>
        <a href="javascript:void(0)" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#EditfocalPointsModal" data-element='${element}'
        onclick="CollectPartnerFP(${element.id},'${element.name}' ,'${element.name_ar}' ,'${element.Email}','${element.phone}','${element.position}' ,'${F_status}')">
        <i class="fa fa-edit"></i>
        </a>
        </td>
        <td>
        <a href="javascript:void(0)" class="btn btn-danger btn-xs">
        <i class="fa fa-trash"></i>
        </a>
        </td>
        </tr>`
    });
    return html;
}
function CollectPartnerFP(id,name,name_ar,email,phone,position,status) {
    //set FocalPointForm focal_name
    $('#focal_name').val(name);
    //set FocalPointForm focal_name_ar
    $('#focal_name_ar').val(name_ar);
    //set FocalPointForm focal_email
    $('#focal_email').val(email);
    //set FocalPointForm focal_phone
    $('#focal_phone').val(phone);
    //set FocalPointForm focal_position
    $('#focal_position').val(position);
    //set FocalPointForm focal_status
    $('#focal_status').val(status);
    //set FocalPointForm focal_id
    $('#focal_id').val(id);

}
