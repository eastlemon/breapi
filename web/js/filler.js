$( "document" ).ready(function() {
    lookupQueue();
});

function lookupQueue() {
    setTimeout(function() {
        $.ajax({
            type: "GET",
            url: "/admin/fill/check",
            dataType: "JSON"
        }).done(function(response) {
            if (response.result) {
                $( "#loader-queue" ).html(response.result);
            }

            lookupQueue();
        });
    }, 1000);
}