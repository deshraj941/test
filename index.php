<!DOCTYPE html>
<html lang="en">
<head>
  <title>Search Engine App</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

  <style>
  * {box-sizing: border-box}
  body {font-family: "Lato", sans-serif;}

  /* Style the tab */
  .tab {
    float: left;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
    width: 30%;
    height: 100%;
  }

  /* Style the buttons inside the tab */
  .tab button {
    display: block;
    background-color: inherit;
    color: black;
    padding: 22px 16px;
    width: 100%;
    border: none;
    outline: none;
    text-align: left;
    cursor: pointer;
    transition: 0.3s;
    font-size: 17px;
  }

  /* Change background color of buttons on hover */
  .tab button:hover {
    background-color: #ddd;
  }

  /* Create an active/current "tab button" class */
  .tab button.active {
    background-color: #ccc;
  }

  /* Style the tab content */
  .tabcontent {
    float: left;
    padding: 0px 12px;    
    width: 70%;    
    height: 100%;
  }
  .tabcontent .card{
  	margin: 0px 0px 20px 0px;
  }
  </style>
</head>
<body>
  
    <div class="tab">
      <button class="tablinks" onclick="openCity(event, 'London')" id="defaultOpen"><span class="glyphicon glyphicon-link"></span>Sync</button>
      <button class="tablinks" onclick="openCity(event, 'Paris')">Settings</button>
      <!--button class="tablinks" onclick="openCity(event, 'Tokyo')">Tokyo</button-->
    </div>

    <div id="London" class="tabcontent">  	
    		
		<div class="card">
		  <div class="card-header">
		    <h3>Data Synchronization</h3>
		  </div>
		   <div class="card-body">
		 		<div id="response"></div>
	      		<button class="tablinks" id="startSync" onclick=""> Start Sync</button>
	       		<div class="text-center">
				  	<div class="spinner-border loaderCust" role="status" style="display: none;">
				    	<span class="sr-only">Loading...</span>
					</div>
				</div>
			</div>
		</div>
      	
    </div>

    <div id="Paris" class="tabcontent">

    	<div class="card">
		  <div class="card-header">
		    <h3>Settings</h3>
		  </div>
		   <div class="card-body">
		 		<form  id="setting" action="" method="">
			        <div class="form-group">
			            <label for="accountID">Account ID:</label>
			            <input type="text" class="form-control" id="accountID" placeholder="Enter your account ID" name="accountID">
			        </div>
			        <div class="form-group">
			            <label for="sig">API KEY:</label>
			        <input type="password" class="form-control" id="sig" placeholder="Enter your API_KEY" name="sig">
			        </div>         
			        <button type="submit" class="btn btn-primary">Submit</button>
			    </form>
			</div>
		</div>      
      
    </div>
   
    <!--div id="Tokyo" class="tabcontent">
      <h3>Tokyo</h3>
      <p>Tokyo is the capital of Japan.</p>
    </div-->

    <script>
    function openCity(evt, cityName) {
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(cityName).style.display = "block";
      evt.currentTarget.className += " active";
    }

    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();


    $(document).ready(function(){ 

        $("#startSync").click(function(){
        	//$(".loaderCust").show();

          var shop = '<?php echo $_GET['shop'] ?>';


         // console.log(shop);
          var get_url = "https://agiledevelopers.in/shopify/app/sync-ajax.php?shop="+ shop;

          $.get(get_url, function(data, status){
          		$(".loaderCust").hide();
          		if((data == "empty") && (status == "success")){
          			console.log(data);

          			$("#response").html('<div class="alert alert-danger" id="success-alert"><button type="button" class="close" data-dismiss="alert">x</button><strong>Wrong! </strong> Something went wrong</div>');

          			setTimeout(function(){
				        $("#response").html('');
				    }, 2000);

			    }else{
			    		console.log(data);
			    	$("#response").html('<div class="alert alert-success" id="success-alert"><button type="button" class="close" data-dismiss="alert">x</button><strong>Success! </strong> Product have synchronized.</div>');

          			setTimeout(function(){
				        $("#response").html('');
				    }, 2000); 
			    }
          		
          		

          		
		  	});

	        //   $.ajax({ 
	        //         method: 'POST',
	        //        url: "https://agiledevelopers.in/shopify/app/sync-ajax.php",
	        //        async: true,
	        //        crossDomain: true,
	        //        data: {shop: shop},
	        //        dataType: "json",
	        //        success: function(data) {            
	              
	        //       console.log(data);
	        //   }
	        // });
          
        });
    });
    </script>
 
</body>
</html>