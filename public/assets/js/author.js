$(document).ready( function()
{
    $('#btnAddAuthor').click(function ()
        {
            const name = $('#inputAddAuthor').val();
            $.ajax(
                {
                    type: "POST",
                    url: "/author/authorAdd",
                    data: JSON.stringify({
                        name: name
                    }),
                    // success: function({ message, author_id: id })
                    success: function(response)
                    {
                        // response.message
                        // response.author_id
                        // const { message, author_id: id } = response
                        // console.log(response)
                        // console.log(message, id)
                        // alert("Author " + name + " added!");
                        alert(`Author ${name} added`)
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