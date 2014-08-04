<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Cambio Azul - Login</title>
	<meta name="keywords" content="Cambio Azul - Login" />
    <meta name="description" content="Cambio Azul - Login" />
<style type='text/css'>
body
{
	font-family: Arial;
	font-size: 14px;
}
a {
    color: blue;
    text-decoration: none;
    font-size: 14px;
}
a:hover
{
	text-decoration: underline;
}
</style>
</head>
<body>
    <div>
		<?php if($error) echo "<p>" . $error . "</p>";?>
		
		<form action="" method="POST">
			<p>email: <input type="text" name="email" id="email" /></p>
			<p>password: <input type="password" name="pwd" id="pwd" /></p>
			<p>
				<input type="submit" name="submit" value="enviar" />
			</p>
		</form>
    </div>
</body>
</html>
