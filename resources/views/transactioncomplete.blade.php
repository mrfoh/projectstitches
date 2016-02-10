<!DOCTYPE html>
<html lang="en-gb">
<head>
	<title>Payment Proccessing</title>
	<style type="text/css">
		body {
			background: #ddd;
		}

		.container {
			display: block;
			width: 90%;
			margin: 50px auto;
			background: #FFF;
			position: relative;
			padding: 15px;
			text-align: center;
		}

		.container h3 {
			margin: 0;
			padding: 10px 0px;
			text-align: center;
		}

		.container p {
			text-align: center;
			padding: 10px 10px;
		}

		.container .button {
			padding: 10px 20px;
			background: #29303f;
			color: #FFF;
			border: none;
		}
	</style>
</head>
<body>
	<div class="container">
		<h3>Almost Done!</h3>
		<p>Your payment is processing, <br>Please tap the button below to proceed.</p>
		<p><strong>Transaction Reference: </strong> {{ $transaction->ref }}</p>
		<p><strong>Transaction Amount: </strong> N{{ number_format($transaction->amount/100,2) }}</p>
		<button id="done" class="button">Continue</button>
	</div>

	<script>
		var doneButton = document.getElementById("done");
		doneButton.addEventListener('click', function(event) {
			window.close();
		});
	</script>
</body>
</html>