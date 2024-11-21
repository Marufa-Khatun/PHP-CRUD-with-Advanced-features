<?php
if (file_exists(__DIR__ . '/autoload.php')) {
	require_once __DIR__ . '/autoload.php';
}

//parmanently delete id
if (isset($_GET['parmanentDeleteID'])) {
	try {
		$parmanentDeleteID = $_GET['parmanentDeleteID'];
		$deletePhoto = $_GET['deletePhoto'];

		$sql = "DELETE FROM devs WHERE id ='$parmanentDeleteID'";
		$statement = connect()->prepare($sql);
		$statement->execute();


		if (!empty($deletePhoto) && file_exists('media/photos/' . $deletePhoto)) {
			unlink('media/photos/' . $deletePhoto);
		}

		setMessage('deleteMsg', 'Permanently deleted this ID!');

		header('location:trash.php');
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
}

//restore
if (isset($_GET['restoreId'])) {
	$restoreId = $_GET['restoreId'];

	$sql = "UPDATE devs SET trash=0, status=1 WHERE id='$restoreId'";
	$statement = connect()->prepare($sql);
	$statement->execute();
	setMessage('deleteMsg', 'Successfully Restore this id!');

	header('location:trash.php');
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
				<a class="btn btn-sm bg-info  my-3" href="index.php">Back </a>
				<div class="card">
					<div class="crad-header">
						<h3>All Trash Data</h3>
						<?php echo getMessage('deleteMsg') ?>
					</div>
					<div class="card-body">
						<table class="table">
							<tr>
								<thead>
									<td>#ID</td>
									<td>Photo</td>
									<td>Name</td>
									<td>Email</td>
									<td>Phone</td>
									<td>Age</td>
									<td>Skill</td>
									<td>Location</td>
									<td>Gender</td>
									<td>Status</td>
									<td>CreatedAt</td>
									<td>Actions</td>
								</thead>
							</tr>
							<?php
							$sql = 'SELECT * FROM devs WHERE trash = 1; ';
							$statement = connect()->prepare($sql);
							$statement->execute();
							$datas = $statement->fetchAll(PDO::FETCH_OBJ);
							$i = 1;
							foreach ($datas as $item):

							?>
								<tr>
									<tbody>
										<td><?php echo $i++; ?></td>
										<td><img src="media/photos/<?php echo $item->photo ?>" alt=""></td>
										<td><?php echo $item->name ?></td>
										<td><?php echo $item->email ?></td>
										<td><?php echo $item->phone ?></td>
										<td><?php echo $item->age ?></td>
										<td><?php echo $item->skill ?></td>
										<td><?php echo $item->location ?></td>
										<td><?php echo $item->gender ?></td>
										<td><button class="btn btn-sm bg-danger text-white"><i class="fa-solid fa-thumbs-down"></i></button></td>
										<td><?php echo timeAgo($item->createdAT) ?></td>
										<td>

											<a class="btn btn-sm bg-info text-white" href="trash.php?restoreId=<?php echo  $item->id ?>">Restore</a>
											<a class="btn btn-sm bg-danger text-white" href="trash.php?parmanentDeleteID=<?php echo  $item->id ?>&deletePhoto=<?php echo $item->photo ?>"><i class="fa-solid fa-trash-can"></i></a>
										</td>
									</tbody>
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