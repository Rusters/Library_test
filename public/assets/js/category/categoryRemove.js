$(document).ready( function()
{
    $('.bat').click(function ()
    {
        if (confirm("Are you sure?") )
        {
            const id = $(this).data("remove");
            $.ajax({
                    type: "DELETE",
                    url: "/category/"+id,
                    data: JSON.stringify({
                        id : id
                    }),
                    success: function(response)
                    {
                        alert(`Remove's complete`)
                        location.href = "/category";
                    },
                    error: function (error) {
                        console.log(error)
                    }
                }
            );
        }
        else{
            alert('Deletion canceled!')
            location.href = "/category";
        }
    })
});