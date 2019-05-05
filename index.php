<!DOCTYPE html>
<html lang="en">
<head>
  <title>Ajex Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">


</head>
<body>

<div class="container">
	<h1 class="text-primary text-uppercase text-center"> AJAX CRUD OPERATION </h1>

	<div class="d-flex justify-content-end">
		<button type="button" class="btn btn-warning" data-toggle="modal" onclick="addRecordModel()" > Add Records </button>
	</div>

	<h2 class="text-danger">All Record</h2>
	<div id="records_contant">

	</div>


  <!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add New Record</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
     
      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-group">
        	<label> Firstname:</label>
        	<input type="text" name="firstname" id="firstname" class="form-control" placeholder="First Name">
        </div>
       

        <div class="form-group">
        	<label> Email Id:</label>
        	<input type="email" name="email" id="email" class="form-control" placeholder="Email">
        </div>

     <!-- Modal footer -->
      <div class="modal-footer">
      	<button type="button" name="submit"  id="submit"  class="btn btn-success" data-dismiss="modal" onclick="addRecord()">Add New</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

     </div>  
 </div>
 </div>
 </div> </div>
        
  <!-- //////////////// after update ////////////////// -->
<div class="modal fade" id="update_user_modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Update Record</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
       
      		<div class="form-group">
      		<label> User Name </label>
      		<input type="text" name="firstname" id="update_firstname" placeholder="First Name" class="form-control">
      	</div>
      	<div class="form-group">
      		<label> Email Id </label>
      		<input type="text" name="email" id="update_email" placeholder="Email Id" class="form-control">
      	</div>
      </div>

      <!-- Modal footer -->
     <div class="modal-footer">
	               
	                <button type="button" class="btn btn-primary" onclick="UpdateUserDetails()" >Update</button>
	                 <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	                <input type="hidden" id="hidden_user_id">
	 </div>



    </div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script type="text/javascript">
$(document).ready(function () {
    readRecords(); 



	});
//////////reset add model//////////////

function addRecordModel(){

		$('#firstname').val('');
		$('#email').val('');
		$("#myModal").modal("show");
    
	}
//////////////////Display Records
	function readRecords(){
		
		var readrecords = "readrecords";
		$.ajax({
			url:"backend.php",
			type:"POST",
			data:{readrecords:readrecords},
			success:function(data,status){
				$('#records_contant').html(data);
			},

		});
	}

//add record

  function addRecord(){

		var firstname 	 =  $('#firstname').val();
		var email 		 =  $('#email').val();
		var submit 		 =  $('#submit').val();

		$.ajax({

			url:"backend.php",
			type:'POST',
			data: { firstname :firstname,
  				email : email,
  				submit: submit
  			 },
			success:function(data, status){
				readRecords();
			},

		});

	}
  
/////////////delete userdetails ////////////
function DeleteUser(deleteid){

	var conf = confirm("Are u sure to delete this record ?");
	if(conf == true) {
	$.ajax({
		url:"backend.php",
		type:'POST',
		data: {  deleteid : deleteid },

		success:function(data, status){
			readRecords();
		}
	});
	}
}

function GetUserDetails(id){
	  $("#hidden_user_id").val(id);
	  $.post("backend.php", {
            id: id
        },
        function (data, status) {
            //alert(data);
            //JSON.parse() parses a string, written in JSON format, and returns a JavaScript object.
            var user = JSON.parse(data);
            //alert(user);

            $("#update_firstname").val(user.user_name);
            $("#update_email").val(user.email);
        }
    );
    $("#update_user_modal").modal("show");
}


function UpdateUserDetails() {
    var firstnameupd = $("#update_firstname").val();
    var emailupd = $("#update_email").val();
    var hidden_user_id = $("#hidden_user_id").val();
    $.post("backend.php", {
            hidden_user_id: hidden_user_id,
            firstnameupd: firstnameupd,
            emailupd: emailupd
        },
        function (data, status) {
            $("#update_user_modal").modal("hide");
            readRecords();
        }
    );
}

  </script>

</body>

</html>