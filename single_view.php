<?php

if (file_exists(__DIR__ . '/autoload.php')) {
	require_once __DIR__ . '/autoload.php';
}

if (isset($_GET['singleViewID'])) {
	$singleViewID = $_GET['singleViewID'];

	$sql = "SELECT * FROM devs where id='$singleViewID'";
	$statement = connect()->prepare($sql);
	$statement->execute();
	$datas = $statement->fetch(PDO::FETCH_OBJ);
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="assets/style.css">
	<title>Developers</title>
</head>

<body class="single-developer-page">

	<div class="container my-5">
		<div class="backbutton text-center">
			<a class="btn   text-white my-3" href="index.php">Back to All List</a>
		</div>
		<div class="row justify-content-center">
			<div class="col-md-8">

				<div class="card">
					<div class="card-header">
						<h3>Single Developer Information</h3>
					</div>
					<div class="card-body">
						<div class="my-3 singleViewPhoto">
							<img src="media/photos/<?php echo $datas->photo ?>" alt="Developer Photo">
						</div>
						<div class="devInfo">
							<h3><b>Name:</b> <?php echo $datas->name ?></h3>
							<p><b>Email:</b> <?php echo $datas->email ?></p>
							<p><b>Phone:</b> <?php echo $datas->phone ?></p>
							<p><b>Age:</b> <?php echo $datas->age ?></p>
							<p><b>Skill:</b> <?php echo $datas->skill ?></p>
							<p><b>Location:</b> <?php echo $datas->location ?></p>
							<p><b>Gender:</b> <?php echo $datas->gender ?></p>
							<p><b>Status:</b> <?php echo $datas->status == 1 ? 'Active' : 'Deactive' ?></p>
						</div>
					</div>
					<button onclick="window.print()" class="btn  text-white mb-3 ">Print Page</button>
				</div>
			</div>
		</div>

	</div>

</body>


</html>