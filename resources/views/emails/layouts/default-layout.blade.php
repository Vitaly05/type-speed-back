<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Password Reset</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f4f4f4;
			margin: 0;
			padding: 0;
		}

		.email-container {
			max-width: 600px;
			margin: 20px auto;
			background-color: #ffffff;
			padding: 20px;
			border-radius: 8px;
			box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
		}

		.header {
			text-align: center;
			font-size: 24px;
			color: #000000;
			margin-bottom: 20px;
		}

		.header span {
			font-weight: bold;
			color: #FFD700; /* Gold color */
		}

		.content {
			font-size: 16px;
			line-height: 1.5;
			color: #333333;
		}

		.content h1 {
			font-size: 20px;
			margin: 0 0 10px;
		}

		.content p {
			margin: 10px 0;
		}

		.button {
			display: block;
			width: 200px;
			margin: 20px auto;
			text-align: center;
			background-color: #000000;
			color: #ffffff;
			text-decoration: none;
			padding: 10px 20px;
			border-radius: 4px;
			font-size: 16px;
		}

		.button:hover {
			background-color: #444444;
		}

		.code {
			text-align: center;
			font-size: 24px;
			font-weight: bold;
		}
	</style>
</head>

<body>
<div class="email-container">
	@yield('content')
</div>
</body>
</html>
