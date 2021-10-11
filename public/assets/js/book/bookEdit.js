$(document).ready( function()
{
    $('#btnEditBook').click(function (){
        let formData = new FormData();
        formData.append('text', $('#bookEditName').val());
        formData.append('file', $("#bookEditPhoto")[0].files[0]);
        formData.append('id', $("button").data("id"));
        formData.append('_method', 'PUT');
        $.ajax(
            {
                type: "POST",
                url: "/book/bookEdit",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                dataType : 'json',
                success: function(response)
                {
                    alert(`Books edit complete`)
                    location.href = "/book";
                },
                error: function (error) {
                    console.log(error)
                }
            }
        );
        }
    );
});