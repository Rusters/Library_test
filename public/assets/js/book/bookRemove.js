$(document).ready( function()
{
    $('.but').click(function ()
    {
        if (confirm("Are you sure?") )
        {
            const id = $(this).data("remove");
            $.ajax({
                    type: "DELETE",
                    url: "/book/"+id,
                    data: JSON.stringify({
                        id : id
                    }),
                    success: function(response)
                    {
                        alert(`Remove's complete`)
                        location.href = "/book";
                    },
                    error: function (error) {
                        console.log(error)
                    }
                }
            );
        }
        else{
            alert('Deletion canceled!')
            location.href = "/book";
        }
    })
});