$(document).ready( function()
{
    $('#btnEditAuthor').click(function (){
        const name = $('#inputEditAuthor').val();
        const id = $("button").data("id");
        $.ajax(
            {
                type: "PUT",
                url: "/author/authorEdit",
                data: JSON.stringify({
                    id: id,
                    name: name
                }),
                // success: function({ message, author_id: id })
                success: function(response)
                {
                    alert(`Edit's complete`)
                    location.href = "/author";
                },
                error: function (error) {
                    console.log(error)
                }
            }
        );
    }
    );
});