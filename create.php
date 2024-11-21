<?php
if (file_exists(__DIR__ . '/autoload.php')) {
	require_once __DIR__ . '/autoload.php';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
</head>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) && $_POST['submit'] == 'Create+') {

	//get form value
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$age = $_POST['age'];
	$skill = $_POST['skill'];
	$location = $_POST['location'];
	$gender = isset($_POST['gender']) ? $_POST['gender'] : [];


	//file upload
	$fileName = $_FILES['photo']['name'];
	$tmp_name = $_FILES['photo']['tmp_name'];


	$fileArray = explode('.', $fileName);
	$getExtension = strtolower(end($fileArray));
	$uniqueFileName = time() . '_' . rand(1000000, 100000000) . '.' . $getExtension;

	//validations
	$error = [];
	if (empty($name) && empty($email) && empty($phone) && empty($age) && empty($skill) && empty($location)) {
		$error['name'] = 'This field is required!';
		$error['email'] = 'This field is required!';
		$error['phone'] = 'This field is required!';
		$error['age'] = 'This field is required!';
		$error['skill'] = 'This field is required!';
		$error['location'] = 'This field is required!';
	} else {
		move_uploaded_file($tmp_name, 'media/photos/' . $uniqueFileName);
		$sql = "INSERT INTO devs(name,email,phone,age,skill,location,gender,photo)
	VALUES(:name, :email, :phone, :age, :skill, :location, :gender, :photo)";
		$statement = connect()->prepare($sql);
		$statement->bindParam(':name', $name);
		$statement->bindParam(':email', $email);
		$statement->bindParam(':phone', $phone);
		$statement->bindParam(':age', $age);
		$statement->bindParam(':skill', $skill);
		$statement->bindParam(':location', $location);
		$statement->bindParam(':gender', $gender);
		$statement->bindParam(':photo', $uniqueFileName);
		$statement->execute();
	}
	setMessage('msg', 'successfully Created!');

	header('location:index.php');
}
?>
<div class="container  my-5">

	<div class="row justify-content-center">
		<div class="col-md-6">
			<a class="btn btn-sm bg-info  my-3" href="index.php">Back </a>
			<div class="card">

				<div class="card-header">
					<h1 class="text-center bg-secondary p-3 text-white">Add New Developer</h1>
				</div>
				<div class="card-body">
					<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
						<div class="my-3">
							<label for="">Name: </label>
							<input type="text" name="name" placeholder="name" class="form-control">
							<p class="text-danger"><?php echo $error['name'] ?? '' ?></p>
						</div>
						<div class="my-3">
							<label for="">Email: </label>
							<input type="text" name="email" placeholder="email" class="form-control">
							<p class="text-danger"><?php echo $error['email'] ?? '' ?></p>
						</div>

						<div class="my-3">
							<label for="">Phone: </label>
							<input type="text" name="phone" placeholder="phone" class="form-control">
							<p class="text-danger"><?php echo $error['phone'] ?? '' ?></p>
						</div>
						<div class="my-3">
							<label for="">Age: </label>
							<input type="text" name="age" placeholder="age" class="form-control">
							<p class="text-danger"><?php echo $error['age'] ?? '' ?></p>
						</div>
						<div class="my-3">
							<label for="">Skill: </label>
							<input type="text" name="skill" placeholder="skill" class="form-control">
							<p class="text-danger"><?php echo $error['skill'] ?? '' ?></p>
						</div>
						<div class="my-3">
							<label for="">Location: </label>
							<input type="text" name="location" placeholder="location" class="form-control">
							<p class="text-danger"><?php echo $error['location'] ?? '' ?></p>
						</div>
						<label for="">Gender: </label>
						<div class="my-3">

							<label>
								<input value="Male" type="radio" name="gender" placeholder="gender">Male
							</label>
							<label>
								<input value="Female" type="radio" name="gender" placeholder="gender">Female
							</label>

							<p class="text-danger"><?php echo $error['gender'] ?? '' ?></p>
						</div>
						<div class="my-3">
							<label for="">Photo: </label>
							<input type="file" name="photo" class="form-control" placeholder="photo">
							<p class="text-danger"><?php echo $error['photo'] ?? '' ?></p>
						</div>
						<div class="my-3 d-flex justify-content-end">
							<button type="reset" class="btn btn-sm bg-info text-white m-2">Reset</button>
							<input type="submit" name="submit" value="Create+" class="btn btn-sm bg-primary text-white m-2 ">

						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
</div>

<body>


	<script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>