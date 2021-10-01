$(document).ready( function()
{
    $('#btnAddCategory').click(function ()
        {
            const name = $('#inputAddCategory').val();
            $.ajax(
                {
                    type: "POST",
                    url: "/category/categoryAdd",
                    data: JSON.stringify({
                        name: name
                    }),
                    success: function(response)
                    {
                        alert(`Category ${name} added`)
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