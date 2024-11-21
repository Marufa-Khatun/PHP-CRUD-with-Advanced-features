<?php
if (file_exists(__DIR__ . '/autoload.php')) {
	require_once __DIR__ . '/autoload.php';
}

//search all location query
$sql = 'SELECT location FROM devs';
$statement = connect()->prepare($sql);
$statement->execute();
$datas = $statement->fetchAll(PDO::FETCH_OBJ);

$locationList = [];

foreach ($datas as $item) {
	array_push($locationList, $item->location);
}
$locationList = array_unique($locationList);




//search all gender query
$sql = 'SELECT gender FROM devs ';
$statement = connect()->prepare($sql);
$statement->execute();
$datas = $statement->fetchAll(PDO::FETCH_OBJ);

$genderList = [];
foreach ($datas as $item) {
	array_push($genderList, $item->gender);
}
$genderList = array_unique($genderList);



// Search form submit handling
$searchLocation = null;
$searchGender = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search_submit'])) {
	$searchLocation = $_POST['location'];
	$searchGender = $_POST['gender'];
}

//active deactive

if (isset($_GET['toggleStatusID'])) {
	$toggleStatusID = $_GET['toggleStatusID'];
	$currentStatus = $_GET['currentStatus'];
	$newStatus = $currentStatus == 1 ? 0 : 1;
	$sql = "UPDATE devs SET status=$newStatus WHERE id='$toggleStatusID' ";
	$statement = connect()->prepare($sql);
	$statement->execute();
	header('location:index.php');
}



//delete id
if (isset($_GET['deleteID'])) {
	$deleteID = $_GET['deleteID'];
	//$deletePhoto = $_GET['deletePhoto'];

	$sql = "UPDATE devs SET trash = 1 , status=0 WHERE id ='$deleteID'";

	$statement = connect()->prepare($sql);
	$statement->execute();

	//unlink('media/photos/' . $deletePhoto);

	setMessage('msg', 'successfully deleted tihs id!');

	header('location:index.php');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	</link>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="assets/style.css">
	</link>
	<title>Develepoers</title>
</head>

<body>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<a class="btn btn-sm bg-info  my-3" href="create.php">Add New Dev</a>

				<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
					<!-- Location Dropdown -->
					<select name="location" id="">
						<option value="">--Select Location--</option>
						<?php
						foreach ($locationList as $location):
						?>
							<option <?php echo  $searchLocation == $location ? 'selected' : '' ?> value="<?php echo $location ?>"><?php echo $location ?></option>
						<?php endforeach; ?>
					</select>

					<!-- Gender Dropdown -->
					<select name="gender" id="">
						<option value="">--Select Gender--</option>
						<?php
						foreach ($genderList as $gender):
						?>
							<option <?php echo  $searchGender == $gender ? 'selected' : '' ?> value="<?php echo $gender ?>"><?php echo $gender ?></option>
						<?php endforeach; ?>
					</select>

					<!-- Submit Button -->
					<button type="submit" name="search_submit">Search</button>
				</form>

				<div class="my-3  d-flex justify-content-end">
					<a class="btn btn-sm bg-warning text-white  " href="trash.php">Trash Data </a>
				</div>

				<div class="card shadow-sm">
					<div class="card-header">
						<h3>All Developers List</h3>
						<?php echo getMessage('msg') ?>
					</div>
					<div class="card-body">
						<table class='table my-3 '>
							<tr>
								<thead>
									<th>#ID</th>
									<th>Photo</th>
									<th>Name</th>
									<th>Email</th>
									<th>Phone</th>
									<th>Age</th>
									<th>Skill</th>
									<th>Location</th>
									<th>Gender</th>
									<th>Status</th>
									<th>CreatedAt</th>
									<th>Actions</th>
								</thead>
							</tr>
							<?php

							//$sql = 'SELECT * FROM devs ';
							//$sql = 'SELECT * FROM devs ORDER BY id DESC LIMIT 2';
							//$sql = 'SELECT * FROM devs ORDER BY name ASC LIMIT 2';
							//$sql = 'SELECT * FROM devs  WHERE location="Uttara" AND gender="Female"';
							//$sql = 'SELECT * FROM devs  WHERE location="Uttara" OR gender="Female"';
							//$sql = 'SELECT * FROM devs  WHERE NOT location="Uttara" && gender="Female"';
							//$sql = 'SELECT * FROM devs   WHERE location IN("Uttara","Mirpur")';
							//$sql = 'SELECT * FROM devs   WHERE location NOT IN("Uttara","Mirpur")';
							//$sql = 'SELECT * FROM devs   WHERE age BETWEEN 32 AND 35';
							//$sql = 'SELECT photo ,name as NAMEE , email,phone,age,skill,location,gender,createdAT  FROM devs   WHERE age BETWEEN 32 AND 35';
							//$sql = 'SELECT*  FROM devs   WHERE name LIKE "_a%"';
							//$sql = 'SELECT*  FROM devs   WHERE name LIKE "%a%"';
							//$sql = 'SELECT MIN(age) as minAGE FROM devs ';
							//$sql = 'SELECT MAX(age) as maxAGE FROM devs ';
							//$sql = 'SELECT SUM(age) as maxAGE FROM devs ';
							//$sql = 'SELECT AVG(age) as maxAGE FROM devs ';
							//$sql = 'SELECT COUNT(age) as maxAGE FROM devs ';
							//$sql = 'SELECT AVG(age) as komBoyos FROM devs ';


							if ($searchLocation && $searchGender) {
								$sql = "SELECT * FROM devs WHERE location='$searchLocation' AND gender='$searchGender' AND trash=0";
							} elseif ($searchLocation && $searchGender === 'Female') {
								$sql = "SELECT * FROM devs WHERE location='$searchLocation' AND gender='Female' AND trash=0";
							} elseif ($searchLocation && $searchGender === 'Male') {
								$sql = "SELECT * FROM devs WHERE location='$searchLocation' AND gender='Male' AND trash=0";
							} elseif ($searchLocation) {
								$sql = "SELECT * FROM devs WHERE location='$searchLocation' AND trash=0";
							} elseif ($searchGender) {
								$sql = "SELECT * FROM devs WHERE gender='$searchGender' AND trash=0";
							} else {
								$sql = "SELECT * FROM devs WHERE  trash=0";
							}


							$statement = connect()->prepare($sql);
							$statement->execute();
							$datas = $statement->fetchAll(PDO::FETCH_OBJ);


							//print_r($datas[0]->countAGE);
							/* 	$averageAge = $datas[0]->komBoyos;

							$sql = 'SELECT * FROM devs WHERE age >=:averageAge';
							$statement = connect()->prepare($sql);
							$statement->execute([':averageAge' => $averageAge]);
							$datas = $statement->fetchAll(PDO::FETCH_OBJ); */
							$i = 1;
							foreach ($datas as $data):
							?>
								<tr>
									<td><?php echo $i++; ?></td>
									<td><img src="media/photos/<?php echo $data->photo ?>" alt=""></td>
									<td><?php echo $data->name ?></td>
									<td><?php echo $data->email ?></td>
									<td><?php echo $data->phone ?></td>
									<td><?php echo $data->age ?></td>
									<td><?php echo $data->skill ?></td>
									<td><?php echo $data->location ?></td>
									<td><?php echo $data->gender ?></td>

									<td><a href="index.php?toggleStatusID=<?php echo $data->id ?>&currentStatus=<?php echo $data->status ?>"
											class="btn btn-sm <?php echo $data->status == 1 ? 'bg-success' : 'bg-danger'; ?> text-white">
											<?php if ($data->status == 1): ?>
												<i class="fa-solid fa-thumbs-up "></i>
											<?php else: ?>
												<i class="fa-solid fa-thumbs-down "></i>
											<?php endif; ?>
										</a></td>
									<td><?php echo timeAgo($data->createdAT) ?></td>
									<td>
										<a class="btn btn-sm bg-info text-white" href="single_view.php?singleViewID=<?php echo $data->id ?>"><i class="fa-regular fa-eye"></i></a>
										<a class="btn btn-sm bg-warning text-white" href="edit.php?updateID=<?php echo $data->id ?>"><i class="fa-regular fa-pen-to-square"></i></a>
										<a class="btn btn-sm bg-danger text-white" href="index.php?deleteID=<?php echo $data->id ?>&deletePhoto=<?php echo $data->photo ?>"><i class="fa-solid fa-trash-can"></i></a>

									</td>
								</tr>
							<?php endforeach; ?>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>


	<script src="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>