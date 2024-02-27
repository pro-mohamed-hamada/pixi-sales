$(document).ready(function () {
    $("#governorates").change(function () {
        alert('done');  
         var governorate_id = $(this).val();
         $('#governorate_cities').html('');
        $.ajax({
            url: '{{ route("cities.index") }}',
            type: 'get',
            // data:{'governorate_id': governorate_id},
            success: function (res) {
                if (res.data != null)
                {
                    $('#governorate_cities').html('<option>please select</option>');
                    $.each(res.data, function (key, value) {
                        $('#governorate_cities').append('<option value="' + value
                            .id + '">' + value.title + '</option>');
                    });
                }else
                $('#governorate_cities').html('<option>please select</option>');

            },
            error: function(res, status, error){
                $('#governorate_cities').html('<option>'+error+'</option>');
            }
        });
    });
})
