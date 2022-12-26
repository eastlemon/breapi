$( "document" ).ready(function() {
    lookupFile();
});

function lookupFile() {
    setTimeout(function() {
        $.ajax({
            type: "GET",
            url: "/admin/load/check",
            dataType: "JSON"
        }).done(function(response) {
            if (response.result) {
                $( "#loader-queue" ).html(response.result);
            }

            lookupFile();
        });
    }, 1000);
}