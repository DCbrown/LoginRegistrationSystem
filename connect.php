<?php

	$con = mysqli_connect("localhost","root","password","registration");

	if(mysqli_connect_errno())
	{
		echo"Error!!!".mysqli_connect_errno();
	}

	session_start();

?>