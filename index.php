<?php
	
	include("connect.php");
	include("functions.php");

	if(logged_in() == true)
	{
		header("location:profile.php");
		exit();
	}
	
	$error ="";

	if(isset($_POST['submit']))
	{
		$firstName = mysql_real_escape_string($_POST['fname']);
		$lastName = mysql_real_escape_string($_POST['lname']);
		$email = mysql_real_escape_string ($_POST['email']);
		$password = mysql_real_escape_string ($_POST['password']);
		$passwordConfirm = mysql_real_escape_string ($_POST['passwordConfirm']);

		$image = $_FILES['image']['name'];
		$tmp_image = $_FILES['image']['tmp_name'];
		$imageSize = $_FILES['image']['size'];

		$conditions = isset($_POST['conditions']);

		$date = date("F, d Y");

		if(strlen($firstName) < 3)
		{
			$error = "First Name is too short";
		}

		else if (strlen($lastName) < 3)
		{
			$error = "Last Name is too short";
		}

		else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$error = "please enter valid email address.";
		}
		else if(email_exists($email, $con))
		{
			$error = "This email has already been registered.";
		}
		else if(strlen($password) < 8)
		{
			$error= "Password must be greater than 8 charcters.";
		}
		else if($password !== $passwordConfirm)
		{
			$error = "Password dose not match.";
		}	

		else if ($image == "")
		{
			$error = "Please upload your image.";
		}
		else if ($imageSize > 1048576)
		{
			$error = "Image size must be less than 1 MB";
		}
		else if(!$conditions)
		{
			$error = "You must agree to the terms and conditions";
		}
		else
		{
			$password = md5($password);

			$imageExt = explode(".", $image);
			$imageExtension = $imageExt[1];

			if($imageExtension == 'PNG' || $imageExtension == 'png' || $imageExtension == 'JPG' || $imageExtension == 'jpg')
			{


				$image = rand(0, 100000).rand(0, 1000000).rand(0, 100000).time().".".$imageExtension;

					$insertQuery = "INSERT INTO users(firstName, lastName, email, password, image, date) VALUES('$firstName','$lastName','$email','$password','$image','$date')";
					if (mysqli_query($con, $insertQuery))
					{
						if(move_uploaded_file($tmp_image,"images/$image"))
						{
							$error = "Your are successfully registered";
						}
						else
						{
							$error = "Image is not uploaded";
						}
				}

			}
			else
			{
				$error = "File must be an image";
			}

		}	


	}

?>


<!doctype html>

<html>
	<head>
		<title>Registration Page</title>
		<link rel="stylesheet" href="css/style.css" />
	</head>	

	<body>
		<div id="wrapper">
			<div id ="error"><?php echo $error ?></div>
			<div id ="menu">
				<a href="index.php">Sign Up</a>
				<a href="login.php">Login</a>	
			</div>
			<div id="formDiv">
				<form method="POST" action="index.php" enctype="multipart/form-data">

					<lable>First Name:</label></br>
					<input type="text" name="fname" required/><br/><br/>
					<lable>Last Name:</label></br>
					<input type="text" name="lname" required/><br/><br/>
					<lable>Email:</label></br>
					<input type="text" name="email" required/><br/><br/>
					<lable>Password:</label></br>
					<input type="password" name="password" required/><br/><br/>
					<lable>Confirm Password:</label></br>
					<input type="password" name="passwordConfirm" required/><br/><br/>
					<lable>Upload Photo:</label></br>
					<input type="file" name="image" /><br/><br/>
					<input type="checkbox" name="conditions" />
					<lable>I agree with terms and conditiosn</label></br></br>

					<input type="submit" name="submit" />

				</form>

			</div>

		</div>	
	</body>	
</html>