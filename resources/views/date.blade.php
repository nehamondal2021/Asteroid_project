<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <title>Document</title>
</head>
<body>
    {{-- <form action="data" method="POST">
        @csrf
        <input type="date" name="start_date" id="start_date" class="dates" value=""/><br><br>
        <input type="date" name="end_date" id="end_date" class="dates" value=""/><br>
        <h5 id="hidden_field" style="color:red"></h5>
        <input type="submit" id="date_submit">
    </form> --}}

    <form action="data" method="POST" style="padding: 63px;">
        @csrf
        <div class="form-group">
          <label for="email">Start Date:</label>
          <input style=" width: 180px; " type="date" name="start_date" id="start_date" class="form-control dates" placeholder="Select Date" value=""/>
        
        </div>
        <div class="form-group">
          <label for="pwd">End Date:</label>
          <input style=" width: 180px; " type="date" name="end_date" id="end_date" class="form-control dates" value=""/>
        </div>

        <div class="alert alert-warning" id="hidden_field" display: block;>
        </div>
        
        <input type="submit" class="btn btn-primary" id="date_submit">
    </form>
</body>
</html>
<script>   
$(document).ready(function(){

    $('#hidden_field').hide();
    $('.dates').change(function(){
       var from_date = $('#start_date').val();
       var to_date = $('#end_date').val();
       if(from_date !='' && to_date != '')
       {
           if(to_date >= from_date) {
                var days = daysdifference(from_date, to_date);
                if(days > 7) {
                    $('#hidden_field').show();
                    $('#hidden_field').text("Warning! : Select dates between 7 days.");
                    $('#date_submit').attr('disabled',true);
                } 
                else {
                    $('#date_submit').attr('disabled', false);
                }
            }
            else {
                $('#hidden_field').show();
                $('#hidden_field').text('Warning! : Select the correct date');
                $('#date_submit').attr('disabled',true);
            }
        }
    });

    function daysdifference(firstDate, secondDate) {
        var startDay = new Date(firstDate);  
        var endDay = new Date(secondDate);  
        // Determine the time difference between two dates    
        var millisBetween = startDay.getTime() - endDay.getTime();  

        // Determine the number of days between two dates  
        var days = millisBetween / (1000 * 3600 * 24);  

        // Show the final number of days between dates    
        return Math.round(Math.abs(days));  
    }
});
</script>