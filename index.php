<?php 
session_start(); 
include("db.php");
?>
<?php
$msg = ""; 
if(isset($_POST['submitBtnLogin'])) {
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	if($username != "" && $password != "") {
		try {
			$query = "select * from `User_Details` where `username`=:username and `password`=:password";
			$stmt = $con->prepare($query);
			$stmt->bindParam('username', $username, PDO::PARAM_STR);
			$stmt->bindValue('password', $password, PDO::PARAM_STR);
			$stmt->execute();
			$count = $stmt->rowCount();
			$row   = $stmt->fetch(PDO::FETCH_ASSOC);
			if($count == 1 && !empty($row)) {
				/******************** Your code ***********************/
				$_SESSION['sess_user_id']   = $row['id'];
				$_SESSION['sess_username'] = $row['username'];
				$_SESSION['sess_name'] = $row['name'];
				header('location:index1.php');
			} else {
				$msg = "Invalid username and password!";
			}
		} catch (PDOException $e) {
			echo "Error : ".$e->getMessage();
		}
	} else {
		$msg = "Both fields are required!";
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PDO login with PDO connection || Mitrajit's Tech Blog</title>
<style>
.clearfix { clear:both; }
span { clear:both; display:block; margin-bottom:30px; }
span a { font-weight:bold; color:#0099FF; }
label { margin-top:20px; margin-bottom:3px; font-weight:bold;}
.loginTable {
 margin: auto;
 position:absolute;
 left:0;
 top:0;
 right:0;
 bottom:0;
 width:400px;
 height:200px;
 border:2px solid #0099FF;
 padding:10px;
}
.loginTable label {
	display:block;
	margin-bottom:3px;
	color:#0099FF;
	font-weight:bold;
}
.loginTable .firstLabel {
	margin-top:20px;
}

.loginTable th {
	border-bottom:2px solid #0099FF;
	margin-bottom:10px;
	color:#0099FF;
}
.loginTable #username, #password,#mname {
	width:365px;
	margin-bottom:7px;
	padding:3px 10px;
}
.loginTable #submitBtnLogin {
	padding:5px 20px;
}
.loginTable .loginMsg {
	color:#FF0000;
	text-align: center;
    padding-top: 5px;
	height:10px;
}
</style>

</head>

<body>
	<span>Read the full article -- <a href="http://www.mitrajit.com/2017/02/php-login-pdo-connection/" target="_blank">PDO login with PDO connection</a> in Mitrajit's Tech Blog</span>
	
		<form method="post">
		<table class="loginTable">
		  <tr>
			<th>ADMIN PANEL LOGIN</th>
		  </tr>
		  <tr>
			<td>
				<label class="firstLabel">Username:</label>
		    	<input type="text" name="username" id="username" value="" autocomplete="off" />
			</td>
		  </tr>
		  <tr>
			<td><label>Password:</label>
		    <input type="password" name="password" id="password" value="" autocomplete="off" /></td>
		  </tr>
		  <tr>
			<td><input type="submit" name="submitBtnLogin" id="submitBtnLogin" value="Login" /><span class="loginMsg"><?php echo @$msg;?></span></td>
		  </tr>
		</table>
		</form>
	
</body>
</html>
