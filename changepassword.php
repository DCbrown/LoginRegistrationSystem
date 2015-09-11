<?php
	
	include("connect.php");
	include("functions.php");

	$error = "";
	if(isset($_POST['savepass']))
	{
		$password = $_POST['password'];
		$confirmPassword = $_POST['passwordConfirm'];

		if(strlen($password) < 8)
		{
			$error = "Password must be greater than 8 characters";
		}
		else if($password !== $confirmPassword)
		{
			$error = "Password dose not match";
		}
		else
		{
			$password = md5($password);

			$email = $_SESSION['email'];
			if(mysqli_query($con, "UPDATE users SET password='$password' WHERE email='$email'"))
			{
				$error = "Password change successfully, <a href='profile.php'>click here</a> to got to the profile";
			}
		}
	}


	if(logged_in())
	{


	
	?>
	<?php echo $error;  ?>
		<form method="POST" action="changepassword.php">
			<lable>Password:</label></br>
			<input type="password" name="password" /><br/><br/>
		
			<lable>Confirm Password:</label></br>
			<input type="password" name="passwordConfirm" /><br/><br/>

			<input type="submit" name="savepass" value="save"/><br/><br/>
		</form>	

	<?php
	}
	else
	{
		header("location: profile.php");
	}


?>