<?php
if (file_exists(__DIR__ . '/autoload.php')) {
	require_once __DIR__ . '/autoload.php';
}
$singleData = null;
if (isset($_GET['updateID'])) {
	$updateID = $_GET['updateID'];

	$sql = "SELECT * FROM devs Where id='$updateID'";
	$statement = connect()->prepare($sql);
	$statement->execute();
	$singleData = $statement->fetch(PDO::FETCH_OBJ);
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
	<link rel="stylesheet" href="assets/style.css">
</head>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) && $_POST['submit'] == 'Update') {

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

	$uniqueFileName = $singleData->photo;
	if (!empty($fileName)) {
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
			if (!empty($singleData->photo) && file_exists('media/photos/' . $singleData->photo)) {
				unlink('media/photos/' . $singleData->photo);
			}
			move_uploaded_file($tmp_name, 'media/photos/' . $uniqueFileName);

			$sql = "UPDATE devs SET name=:name, email=:email, phone=:phone, age=:age, skill=:skill, location=:location, gender=:gender, photo=:photo WHERE id=:updateID";
			$statement = connect()->prepare($sql);
			$statement->execute([
				'name' => $name,
				'email' => $email,
				'phone' => $phone,
				'age' => $age,
				'skill' => $skill,
				'location' => $location,
				'gender' => $gender,
				'photo' => $uniqueFileName,
				'updateID' => $updateID,

			]);
		}
	}
	setMessage('msg', 'successfully Updated!');

	header('location:index.php');
}
?>
<div class="container  my-5">

	<div class="row justify-content-center">
		<div class="col-md-6">
			<a class="btn btn-sm bg-info  my-3" href="index.php">Back </a>
			<div class="card">

				<div class="card-header">
					<h1 class="text-center bg-secondary p-3 text-white">Update Developer Info</h1>
					<?php echo getMessage('msg') ?>
				</div>
				<div class="card-body">
					<form action="<?php echo $_SERVER['PHP_SELF'] . '?updateID=' . $updateID; ?>" method="POST" enctype="multipart/form-data">

						<div class="my-3">
							<label for="">Name: </label>
							<input type="text" name="name" placeholder="name" value="<?php echo $singleData->name ?>" class="form-control">
							<p class="text-danger"><?php echo $error['name'] ?? '' ?></p>
						</div>
						<div class="my-3">
							<label for="">Email: </label>
							<input type="text" name="email" placeholder="email" value="<?php echo $singleData->email ?>" class="form-control">
							<p class="text-danger"><?php echo $error['email'] ?? '' ?></p>
						</div>

						<div class="my-3">
							<label for="">Phone: </label>
							<input type="text" name="phone" placeholder="phone" value="<?php echo $singleData->phone ?>" class="form-control">
							<p class="text-danger"><?php echo $error['phone'] ?? '' ?></p>
						</div>
						<div class="my-3">
							<label for="">Age: </label>
							<input type="text" name="age" placeholder="age" value="<?php echo $singleData->age ?>" class="form-control">
							<p class="text-danger"><?php echo $error['age'] ?? '' ?></p>
						</div>
						<div class="my-3">
							<label for="">Skill: </label>
							<input type="text" name="skill" placeholder="skill" value="<?php echo $singleData->skill ?>" class="form-control">
							<p class="text-danger"><?php echo $error['skill'] ?? '' ?></p>
						</div>
						<div class="my-3">
							<label for="">Location: </label>
							<input type="text" name="location" placeholder="location" value="<?php echo $singleData->location ?>" class="form-control">
							<p class="text-danger"><?php echo $error['location'] ?? '' ?></p>
						</div>
						<label for="">Gender: </label>
						<div class="my-3">

							<label>
								<input value="Male" <?php echo $singleData->gender == 'Male' ? 'checked' : '' ?> type="radio" name="gender" placeholder="gender">Male
							</label>
							<label>
								<input value="Female" <?php echo $singleData->gender == 'Female' ? 'checked' : '' ?> type="radio" name="gender" placeholder="gender">Female
							</label>

							<p class="text-danger"><?php echo $error['gender'] ?? '' ?></p>
						</div>
						<div class="my-3 photo">
							<label for="">Photo: </label>
							<img src="media/photos/<?php echo $singleData->photo ?> " alt="">
							<input type="file" name="photo" class="form-control" placeholder="photo">
							<p class="text-danger"><?php echo $error['photo'] ?? '' ?></p>
						</div>
						<div class="my-3 d-flex justify-content-end">
							<button type="reset" class="btn btn-sm bg-info text-white m-2">Reset</button>
							<input type="submit" name="submit" value="Update" class="btn btn-sm bg-primary text-white m-2 ">

						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
</div>





<body>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>


<body>


	<script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>