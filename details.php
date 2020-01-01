<?php 

//connect to database from external file
include('config/db_connect.php');



// DELETE FROM DATABASE    
if(isset($_POST['delete'])){

    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

    $sql = "DELETE FROM pizzas WHERE id = $id_to_delete";

    if(mysqli_query($conn, $sql)){
        //success
        header('Location: index.php');
    } {
        //failure
        echo 'query error: ' . mysqli_error($conn); 
    }
}
// END OF DELETE DATABASE




// SELECT A SINGLE ITEM FROM A DATABASE TABLE AND SHOW IN BROWSER USING GET METHOD ---------------------------------------------------

// check GET request id param (from url)
if(isset($_GET['id'])){ // check if the variable is set
    //true
    $id = mysqli_real_escape_string($conn, $_GET['id']);  //connect to the databse and protect it user inputted special characters

    //make sql from database. select everything from the databse where the id from the url matches the database (to get a single result)
    $sql = "SELECT * FROM pizzas WHERE id = $id";

 
    $result = mysqli_query($conn, $sql);    //get query result from sql
    $pizza = mysqli_fetch_assoc($result);    //fetch result in an array format. assosciative array

    mysqli_free_result($result); //free the result.
    mysqli_close($conn); //close connection to db
    // print_r($pizza);

    } else {
        //false
    }
 ?> 
 <!-- end of php -->


<!DOCTYPE html>
<html>
<?php include('templates/header.php') ?>



<div class="container center">
    <?php if($pizza){ ?>
       <!-- if there is a pizza with the same id as the database -->
        <h4><?php  echo htmlspecialchars($pizza['title']); ?></h4>
        <p>Created by: <?php  echo htmlspecialchars($pizza['email']); ?></p>
        <p><?php  echo htmlspecialchars($pizza['created_at']); ?></p>

        <h5>Ingredients</h5>
        <P><?php  echo htmlspecialchars($pizza['ingredients']); ?></P>

        
                <!-- DELETE FORM -->
                <form action="details.php" method="POST">
                    <input type="hidden" name="id_to_delete" value="<?php echo $pizza['id'] ?>">
                    <input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
                </form>


    <?php } else{ ?>
        <!-- if there is no pizza with matching ids -->
        <h5>No such pizza exists</h5>

    <?php } ?>

</div>



<?php include('templates/footer.php') ?>
</html>