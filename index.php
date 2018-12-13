<?php 
error_reporting(0);
require 'db/connect.php';
require 'security.php';

$records = array();

if(!empty($_POST)) {
	if(isset($_POST['first_name'], $_POST['last_name'], $_POST['bio'])){

		$first_name = $_POST['first_name'];
		$last_name 	= $_POST['last_name'];
		$bio 		= $_POST['bio'];

		if(!empty($first_name) && !empty($last_name) && !empty($bio)) {
			$insert = $db->prepare("	INSERT INTO people (first_name, last_name, bio, created) 
										VALUES (?,?,?, NOW()) 
				");
			$insert->bind_param('sss', $first_name, $last_name, $bio);
			if ($insert->execute()) {
				header('Location: index.php');
			}
			
		}
	}
}



if($result = $db->query("SELECT * FROM people")){
	if($result->num_rows){

		while ($row = $result->fetch_object()){
			$records[] = $row;
		}
		$result->free();

	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>People</title>
</head>
<body>

	<h3>People</h3>

	<?php if(!count($records)) {
		echo "No Records";
	} else {
	?>
	<table>
		<thead>
			<tr>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Bio</th>
				<th>Created</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($records as $r) { ?>
			<tr>
				<td><?= escape($r->first_name); ?></td>
				<td><?= escape($r->last_name); ?></td>
				<td><?= escape($r->bio); ?></td>
				<td><?= escape($r->created); ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>

	<?php } ?>
	<hr>

	<form action="" method="post">
		<div class="field">
			<label for="first_name">First Name</label>
			<input type="text" name="first_name" id="first_name" autocomplete="off">
		</div>
		<div class="field">
			<label for="last_name">Last Name</label>
			<input type="text" name="last_name" id="last_name" autocomplete="off">
		</div>
		<div class="field">
			<label for="bio">Bio</label>
			<textarea name="bio" id="bio"></textarea>
		</div>
		<input type="submit" value="Insert">

	</form>



</body>
</html>