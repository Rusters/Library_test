$(document).ready( function()
{
    $("#btnAddBook").click(function(){
        var formData = new FormData();
        formData.append('text', $("#bookAddName").val());
        formData.append('aut', $("#selectionAuthor option:selected").text());
        formData.append('cat', $("#selectionCategory option:selected").text());
        formData.append('file', $("#bookAddPhoto")[0].files[0]);
        $.ajax({
            type: "POST",
            url: '/book/bookAdd',
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            dataType : 'json',
            success: function(response)
            {
                alert(`Books add complete`)
                location.href = "/book";
            },
            error: function (error) {
                console.log(error)
            }
        });
    });
});