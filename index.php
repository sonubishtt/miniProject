<?php
	$login = false;
	$showAlert= false;
	$showError= false;

    // connection
    if(isset($_POST['studentId'])){
        $con = mysqli_connect("localhost","root","");

        if(!$con){
            die("connection failed". mysqli_connect_error());
        }

         // variable declaration
        $studentId=$_POST['studentId'];
		$email=$_POST['email'];
		$password=$_POST['password'];
		$cpassword=$_POST['cpassword'];
    
		// check whether acct exists or not and confirm password match or not

		$existSql = " SELECT * FROM `studentRecords`.`studentrecord` WHERE studentId = '$studentId' ";
		$result = mysqli_query($con, $existSql);
		$numExistRows = mysqli_num_rows($result);

		if($numExistRows>0){
			$showError ="Account Already Exists";
		}
		else{
			if($password==$cpassword){
				$hash= password_hash($password , PASSWORD_DEFAULT );
				$sql = "INSERT INTO `studentRecords`.`studentrecord` (`studentId`, `email`, `password` ,`dateTime`) VALUES ('$studentId', '$email', '$hash', current_timestamp())";
				$result=mysqli_query($con,$sql);
				if($result){
					$showAlert= true;
				}

			}
			else{
				$showError= "Passwords do not match";
			}
		}

		// $lstudentId=$_POST['lstudentId'];
		// $lpassword=$_POST['lpassword'];
		

		// $sql2 = " SELECT * FROM `studentRecords`.`studentrecord` WHERE studentId = '$lstudentId' AND password = '$lpassword'";
		// $result2 = mysqli_query($con,$sql2);
		// $numExistRows2 = mysqli_num_rows($result2);
		// if($numExistRows2 == 1){
		// 	$login= true;
		// 	session_start();
		// 	$_SESSION['loggedin'] = true;
		// 	$_SESSION['lstudentId'] = $lstudentId;
		// 	header("location: welcome.php");
		// }
		// else{
		// 	$showError = "Invalid Cradentials";
		// }


		//$sql = "INSERT INTO `studentRecords`.`studentrecord` (`studentId`, `email`, `password`) VALUES ('$studentId', '$email', '$password')";

		// if($con->query($sql)==true){
        //     echo " Succesfully inserted";
            
        // }
        // else{
        //     echo "ERROR: $sql <br> $con->error";
        // }
        $con->close();
    } 
	if(isset($_POST['lstudentId'])){
        $con = mysqli_connect("localhost","root","");

        if(!$con){
            die("connection failed". mysqli_connect_error());
        }

		$lstudentId=$_POST['lstudentId'];
		$lpassword=$_POST['lpassword'];
		

		// $sql2 = " SELECT * FROM `studentRecords`.`studentrecord` WHERE studentId = '$lstudentId' AND password = '$lpassword'";
		$sql2 = " SELECT * FROM `studentRecords`.`studentrecord` WHERE studentId = '$lstudentId'";
		$result2 = mysqli_query($con,$sql2);
		$numExistRows2 = mysqli_num_rows($result2);
		if($numExistRows2 == 1){
			while($row= mysqli_fetch_assoc($result2)){
				if(password_verify($lpassword, $row['password'])){
					$login= true;
					session_start();
					$_SESSION['loggedin'] = true;
					$_SESSION['lstudentId'] = $lstudentId;
					header("location: welcome.php");
				}
				else{
					$showError = "Invalid Cradentials";
				}
				
			}
		}
		else{
			$showError = "Invalid Cradentials";
		}
	}
?> 


<?php
		if($showAlert){
		echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Success!</strong> Your account is now created and you can login

		</div> ';
		}
		if($login){
			echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Success!</strong>logged in
	
			</div> ';
			}		
		if($showError){
		echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong>Error!</strong> '. $showError.'

		</div> ';
		}
    ?>

<div class="container" id="container">
	<div class="form-container sign-up-container">
		<form action="index.php" method="post">
			<h1>Create Account</h1>
<!-- 			<div class="social-container">
				<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
				<a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
				<a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
			</div> -->
<!-- 			<span>or use your email for registration</span> -->
			<input type="number" placeholder="Student ID" name="studentId" id="studentId" required/>
			<input type="email" placeholder="Email" name="email" id="email" required/>
			<input type="password" placeholder="Password" name="password" id="password" required/>
			<input type="password" placeholder="Confirm Password" name="cpassword" id="cpassword" required/>
			<button>Sign Up</button>
		</form>
	</div>
	<div class="form-container sign-in-container">
		<form action="index.php" method="post">
			<h1>Sign in</h1>
<!-- 			<div class="social-container">
				<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
				<a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
				<a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
			</div> -->
<!-- 			<span>or use your account</span> -->
			<input type="number" placeholder="Student ID" name="lstudentId" id="lstudentId" required/>
			<input type="password" placeholder="Password" name="lpassword" id="lpassword"  required/>
			<a href="#">Forgot your password?</a>
			<button>Sign In</button>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>Welcome Back!</h1>
				<p>To keep connected with us please login with your personal info</p>
				<button class="ghost" id="signIn">Sign In</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1>Hello, BCA 3<sup>rd</sup> B!</h1>
				<p><b>Plz.. Let us Show the World! What u have Achieve..</b></p>
				<button class="ghost" id="signUp">Sign Up</button>
			</div>
		</div>
	</div>
</div>

<footer>

</footer>
<script>const signUpButton = document.getElementById('signUp');
  const signInButton = document.getElementById('signIn');
  const container = document.getElementById('container');
  
  signUpButton.addEventListener('click', () => {
    container.classList.add("right-panel-active");
  });
  
  signInButton.addEventListener('click', () => {
    container.classList.remove("right-panel-active");
  });</script>
</body>
</html>