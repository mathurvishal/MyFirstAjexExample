<?php

$server = "localhost";
$user = "root";
$passdb = "";
$db = "ajexExample";
$conn = mysqli_connect( $server, $user, $passdb, $db ) or die( "Connection Error" );
	
//adding records in database
if(isset($_POST['submit']))
	{
		
		$firstname = $_POST['firstname'];
		$email = $_POST['email'];
$query = "INSERT INTO `users`( `user_name`, `email`) VALUES('$firstname', '$email' )";

		if($result = mysqli_query($conn,$query)){
			exit(mysqli_error());
		}else{
			echo "1 record added";
		}



	}


//display records

if(isset($_POST['readrecords'])){

	$data =  '<table class="table table-bordered table-striped ">
						<tr class="bg-dark text-white">
							<th>No.</th>
							<th>First Name</th>
							<th>Email Address</th>
							<th>Edit Action</th>
							<th>Delete Action</th>
						</tr>'; 

	$displayquery = "SELECT * FROM `users`"; 
	$result = mysqli_query($conn,$displayquery);

	if(mysqli_num_rows($result) > 0){

		$number = 1;
		while ($row = mysqli_fetch_array($result)) {
			
			$data .= '<tr>  
				<td>'.$number.'</td>
				<td>'.$row['user_name'].'</td>
				<td>'.$row['email'].'</td>
				<td>
					<button onclick="GetUserDetails('.$row['id'].')" class="btn btn-success">Edit</button>
				</td>
				<td>
					<button onclick="DeleteUser('.$row['id'].')" class="btn btn-danger">Delete</button>
				</td>
    		</tr>';
    		$number++;

		}
	} 
	 $data .= '</table>';
    	echo $data;

}

/////////////delete userdetails ////////////
if (isset($_POST['deleteid'])) {
	$deleteid = $_POST['deleteid'];

	$deletequery = " delete from users where id ='$deleteid' ";
	if (!$result = mysqli_query($conn,$deletequery)) {
        exit(mysqli_error());	
}
}



/// get userid for update
if(isset($_POST['id']) && isset($_POST['id']) != "")
{
    $user_id = $_POST['id'];
    $query = "SELECT * FROM users WHERE id = '$user_id'";
    if (!$result = mysqli_query($conn,$query)) {
        exit(mysqli_error());
    }
    
    $response = array();

    if(mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
       
            $response = $row;
        }
    }else
    {
        $response['status'] = 200;
        $response['message'] = "Data not found!";
    }
  //     PHP has some built-in functions to handle JSON.
// Objects in PHP can be converted into JSON by using the PHP function json_encode(): 
    echo json_encode($response);
}
else
{
    $response['status'] = 200;
    $response['message'] = "Invalid Request!";
}


///update table

if(isset($_POST['hidden_user_id'])){

	$hidden_user_idupd = $_POST['hidden_user_id'];
	$firstnameupd = $_POST['firstnameupd'];
    $emailupd = $_POST['emailupd'];

    $query = " UPDATE `users` SET `user_name`='$firstnameupd',`email`='$emailupd' WHERE id= '$hidden_user_idupd' ";
     if (!$result = mysqli_query($conn,$query)) {
        exit(mysqli_error());
    }
}
?>