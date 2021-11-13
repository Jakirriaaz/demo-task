$(document).ready(function(){
    var i = 1;
    $('#add_btn').click(function(){
        i++;
        $('#dynamic_field').append('<tr id="row'+i+'"><td><input class="widefat" type="text" name="name" id="name" placeholder="Name of the Person"></td></tr><tr><td><button class="btn custom-btn btn-danger btn-remove" type="button" name="remove" id="'+i+'">Add More</button></td></tr>');
    });
    $(document).on('click', '.btn-remove', function(){
        var button_id = $(this).attr("id");
        $("#row"+button_id+"").remove();
    });

    $('#submit').click(function(){

        $.ajax({
            url:"process.php",
            method: "POST",
            data: $('#add_name').serialize(),
            success: function(data){
                alert(data);
                $('#add_name')[0].reset();
            }
        });

    });

});