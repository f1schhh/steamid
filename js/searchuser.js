$(document).ready(function(){
    $(".searchbarbtn").closest("form").submit(function(e) {
        e.preventDefault();

           $(".info").fadeIn("slow").html("Laddar.....");

            $.ajax({
            url: 'getuserdata.php',
            type: 'POST',
            data: {searchid: $(".searchtext").serialize()},
            dataType: 'html'
        })
        .done(function(data){
            $("#search4user")[0].reset();
            $(".info").fadeIn("slow").html(data);
            
        })
        .fail(function(){
            alert("Funkade inte");
        });
        
    });
});