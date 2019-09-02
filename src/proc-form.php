<html>
<head></head>
<body>
<title>Display Submitted form</title>
<?php 

ini_set('max_execution_time', 300);
ini_set('default_socket_timeout',300);
    
ob_start();
if(isset($_POST['proc-form'])) {

    $link_address = 'donate-charity.html';
	$validate_credit_card_no = $_POST["credit_card_no"];
	
    //For user name
	if (empty($_POST["username"]) || empty($_POST["selectSection"]) || empty($validate_credit_card_no) || !preg_match('/^[0-9]{15}$/',$validate_credit_card_no)
 || empty($_POST["credit_card_type"])){
        echo "Please check if you have fill in your name, section and credit card details.".'<br /><br />';
		echo "Please re-submit form again - Thank You".'<br /><br />';
		echo "<a href='$link_address'>Back</a>";

    }else {
			$username = $_POST["username"];
			$selectSection = $_POST["selectSection"];
			$credit_card_no = $_POST["credit_card_no"];
			$credit_card_type = $_POST["credit_card_type"];
    
    
    //For section selection
   // if (empty($_POST["selectSection"])){
  //      $sectionErr = "Section is required";
   // }else{
  //      $selectSection = $_POST["selectSection"];
	//}
	 
    // For credit card number
	//if (empty($_POST["credit_card_no"])){
     //   $credit_card_noErr = "Credit card number is required";
    //}else{
    //    $credit_card_no = $_POST["credit_card_no"];
    //}
    
    // For credit card type
	//if (empty($_POST["credit_card_type"])){
     //   $credit_card_typeErr = "Credit card type is required";
    //}else{
    //    $credit_card_type = $_POST["credit_card_type"];
    //}
		
	
	// sanitize the data received from user before use
			
  $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);

  $credit_card_no = filter_var($_POST["credit_card_no"], FILTER_SANITIZE_NUMBER_INT);
    
	
	// after all data sanitized - display the data on screen with amessage

 	echo "<strong>";
 	echo'<br />';
 	echo "You have submitted the following details:-" . '<br /><br />';
	echo "Name               :";
	echo $_POST["username"];
  	echo'<br />';
  	echo "Section            :"; 
  	echo $_POST["selectSection"];
  	echo'<br />';
  	echo "Credit Card Number :"; 
  	echo $_POST["credit_card_no"];
  	echo'<br />';
  	echo "Credit Card Type   :"; 
  	echo $_POST["credit_card_type"];
   
	// open the data text ile to append the data submitted
	
	$fp = fopen('data.txt', 'a');
	fwrite($fp,"$username\t - $selectSection\t - $credit_card_no\t - $credit_card_type\n");	
	fclose($fp);
 
	
	echo "<strong>";
    echo'<br /></br>';
    echo "Here are all the people who have donated:-" . '<br /><br />';
	
	// open data text file to read the content and display
	$read = file('data.txt');
	foreach($read as $read){
		echo $read."<br>";
	}

	// now we need to insert the submitted data to the user_profile table.
	// remeber to create te database charityDB and the table user_profile first using a 	separate program
	// Provide the database credentials
    //$db_user = '???';
    //$db_pass = '';
    //$db_name = '?????';
    //$db_host = '????';

	$db_host = 'localhost' ;
	$db_name = 'root';
	$db_pass = '';
	
	// connect to the database
	
	$mysqli = mysqli_connect($db_host, $db_name, $db_pass);
       
    // Check we're connected
  	if ($mysqli->connect_error) {
		      die('Connect Error '. $mysqli->connect_error.": " . $mysqli->connect_error);
 }
	//insert submitted data to the user_pprofile table  using the object  oriented style
	// Prepare our query

	$insert = mysqli_query($mysqli,"INSERT INTO 'user_profile'('User Name', 'Section', 'Credit Card Number', 'Credit Card Type') VALUES (['$username'],['$selectSection'],['$credit_card_no'],['$credit_card_type']) ");
	
		// bind placeholder with parameters
		
		// Run the query
		
		//  Now we retirev the data from the suer_profile table and display it back for the user

		
		echo '<br></br>';
		echo "New record created successfully in user_profile table".'<br></br>';
		echo "User input as extarcted from user_profile table:-";
		echo '<br></br>';
		echo "<table style='border: 1px solid black;','border-collapse: collapse;'>";
		echo "<tr style='border: 1px solid black;','border-collapse: collapse;'>";
		echo "<td style='border: 1px solid black;','border-collapse: collapse;'>User Name</td>";
		echo "<td style='border: 1px solid black;','border-collapse: collapse;'>Section</td>";
		echo "<td style='border: 1px solid black;','border-collapse: collapse;'>Credit Card Number</td>";
		echo "<td style='border: 1px solid black;','border-collapse: collapse;'>Credit Card Type</td>";
		echo '</tr>';
		echo "<tr style='border: 1px solid black;','border-collapse: collapse;'>";
		echo "<td style='border: 1px solid black;','border-collapse: collapse;'>".$username."</td>";
		echo "<td style='border: 1px solid black;','border-collapse: collapse;'>".$selectSection."</td>";
		echo "<td style='border: 1px solid black;','border-collapse: collapse;'>".$credit_card_no."</td>";
		echo "<td style='border: 1px solid black;','border-collapse: collapse;'>".$credit_card_type."</td>";
		echo '</tr>';
		echo "<table style='border: 1px solid black;','border-collapse: collapse;'>";
	}

  ob_flush();
  die();
}

?>	
</body>
</html>
