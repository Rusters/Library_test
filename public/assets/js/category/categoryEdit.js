$(document).ready( function()
{
    $('#btnEditCategory').click(function ()
        {
            const name = $('#inputEditCategory').val();
            const id = $("button").data("id");
            $.ajax(
                {
                    type: "PUT",
                    url: "/category/categoryEdit",
                    data: JSON.stringify({
                        id: id,
                        name: name
                    }),
                    success: function(response)
                    {
                        alert(`Edit's complete`)
                        location.href = "/category";
                    },
                    error: function (error) {
                        console.log(error)
                    }
                }
            );
        }
    );
});