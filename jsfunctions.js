$(document).ready(function(){
    $(".slideToggle").click(function(){
        $("#panel").slideToggle("slow");
    });

    $("button"[name="afficherplus"]).click(function(){
        var filters = document.getElementById("filters").value
        var options = document.getElementById("options").value
        var derniercode = document.getElementById("lastcode").value
        var limit = 8;
        query = '';
        function load_data(limit, derniercode, query)
        {
            $.ajax({
                url:"fetch.php",
                method:"POST",
                data:{limit:limit, derniercode:derniercode, query:query, filters:filters, options:options},
                cache:false,
                success:function(data)
                {
                    $('.checkboxes').append(data);
                    if(data == '')
                    {
                        $('#load_data_message').html("<button type='button' class='btn btn-info'>No Data Found</button>");
                    }
                    else
                    {
                        $('#load_data_message').html("<button type='button' class='btn btn-warning'>Please Wait....</button>");
                    }
                }
            });
        }

});