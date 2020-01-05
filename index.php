<!DOCTYPE html>
<html>
<head>
<title>Country</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
	<form action="" method="post">
	    <div class="form-group">
	        <label for="country">Country</label>
	        <select class="form-control" id="country" name="country" data-dependent="state">
	            <option>Select Country</option>
	        </select>
	    </div>

	    <div class="form-group">
	        <label for="state">State</label>
	        <select class="form-control" id="state" name="state" data-dependent="city">
	            <option>Select State</option>
	        </select>
	    </div>
	    <div class="form-group">
	        <label for="city">City</label>
	        <select class="form-control" id="city" name="city">
	            <option>Select City</option>
	        </select>
	    </div>

	    <button type="submit" class="btn btn-default">Submit</button>
	</form>
</div>
<script>
$( document ).ready(function() {

    $.ajax({
        type:"get",           
        url:"http://walletmix.info/geoapp/?get=country",
        dataType: 'json',
        success:function(data){

            if(data.length>0){                    
                $(data).each(function(e,v){
                    $('#country').append("<option value="+v.id+">"+v.name+"</option>");
                });
            }

        }
    });

    $(document).on('change','#country',function(){
    	var country=$(this).val();
    	var url="http://walletmix.info/geoapp/?get=state&country_id="+country+'"';

	    $.ajax({
	    	type:"get",
	    	url:url,
	    	data:{'country':country,'url':url},
	    	success:function(data){
	    		if(data.length>0)
	    		{
	    			$('#state').html('');
	    			$('#city').html('');
	    			// if(data[0].country_id==17){
	    			// 	$('#state').append('<option value="Bd">BD</option>');
	    			// }else{
    				$(data).each(function(e,v){
	    				if(country==v.country_id){
	    					$('#state').append("<option value="+v.id+">"+v.name+"</option>");
	    				}
	    			});	    			
	    			// }
	    		}
	    	}
	    });

    });

    $(document).on('change','#state',function(){
    	var country_state=$('#state').val();
    	var country_city=$('#country').val();
    	var url_state="http://walletmix.info/geoapp/?get=city&country_id="+country_city+"&state_id="+country_state+'"';
    	$.ajax({
    		type:"get",
    		url:url_state,
    		data:{'country_state':country_state,'country_city':country_city,'url_state':url_state},
    		success:function(data){
			// var myh="";
    			if(data.length>0){
    				$('#city').html('');
    				$(data).each(function(i,r){
    					if(country_state==r.region_id){
    						$('#city').append("<option value="+r.id+">"+r.name+"</option>");
						// myh += "<option value="+v.id+">"+v.name+"</option>";
    					}
    				});
    			}
			// $('#city').html(myh);
    		}
    	});

    });
    
});

</script>
</body>
</html>
