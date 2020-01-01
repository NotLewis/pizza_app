<?php 

    //connect to database from external file
    include('config/db_connect.php');


$email = $title = $ingredients = "";

//error ouput
$errors = ['email' => '', 'title' => '', 'ingredients' => ''];


	if(isset($_POST['submit'])){
		$email = $title = $ingredients = '';
		
		// check email
		if(empty($_POST['email'])){
			$errors['email'] =  'An email is required <br />';
		} else{
			$email = $_POST['email'];
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$errors['email'] =  'Email must be a valid email address';
			}
		}
		// check title
		if(empty($_POST['title'])){
			$errors['title'] =  'A title is required <br />';
		} else{
			$title = $_POST['title'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $title)){ //REGEX (MUST BE ATLEAST 1 CHAR IN LENGTH AND ONLY INCLUDE LETTERS)
				$errors['title'] =  'Title must be letters and spaces only';
			}
		}
		// check ingredients
		if(empty($_POST['ingredients'])){
			$errors['ingredients'] =  'At least one ingredient is required <br />';
		} else{
			$ingredients = $_POST['ingredients'];
			if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)){
				$errors['ingredients'] =  'Ingredients must be a comma separated list';
			}
        }

        // Check for errors
        if(array_filter($errors)){
            //errors in the form which. wont pass until there are no errors
        } else {
			//form is valid - add data to database
				//override previous email variable
			$email = mysqli_real_escape_string($conn, $_POST['email']); // like the htmlspecialchars -> (connection, value to store)
			$title = mysqli_real_escape_string($conn, $_POST['title']);
			$ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

			//create sql - insert data from above into the pizzas table. Update columns with x data
			$sql ="INSERT INTO pizzas(title,email,ingredients) VALUES('$title', '$email', '$ingredients')";

			//save to db and check it works
			if(mysqli_query($conn, $sql)){ //same as the one to get the result from index.php
				//success. Has saved to the databse
				header('Location: index.php'); //redirect to homepage.
			} else {
				//error
				echo 'query error: ' . mysqli_error($conn);
			} 
        }
	} // end POST check (Submit button)
?>





<!DOCTYPE html>
<html lang="en">

    <?php include('templates/header.php') ?>

    <section class="container grey-text">
        <h4 class="center">Add a Pizza</h4>
        <form  class="white" action="add.php" method="POST">
            <label>Your email:</label>
            <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>" >
            <div class="red-text"><?php echo $errors['email']; ?></div>

            <label>Pizza Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>" >
            <div class="red-text"><?php echo $errors['title']; ?></div>

            <label>Ingredients (comma seperated)</label>
            <input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients) ?>" >
            <div class="red-text"><?php echo $errors['ingredients']; ?></div>

            <div class="center">
                <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
            </div>
        </form>
    </section>

    <?php include('templates/footer.php') ?>


</html>