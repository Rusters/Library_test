$(document).ready( function()
{
        $('.but').click(function ()
        {
            if (confirm("Are you sure?") )
            {
                const id = $(this).data("remove");
                $.ajax({
                        type: "DELETE",
                        url: "/author/"+id,
                        data: JSON.stringify({
                            id : id
                        }),
                        // success: function({ message, author_id: id })
                        success: function(response)
                        {
                            alert(`Remove's complete`)
                            location.href = "/author";
                        },
                        error: function (error) {
                            console.log(error)
                        }
                    }
                );
            }
            else{
                alert('Deletion canceled!')
                location.href = "/author";
            }
        })
});