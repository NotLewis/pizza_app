<?php  
    //connect to database from external file
    include('config/db_connect.php');


    //Write query to get all pizzas
    $sql = 'SELECT title, ingredients, id FROM pizzas ORDER BY created_at';

    //make query and get result. $sql = data from the query to get the title, ingredients and id from the table.
    $result = mysqli_query($conn, $sql);#

    //fetch the resulting rows as an array. stores pizzas in this array
    $pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // free result from memory
    mysqli_free_result($result);

    //close connection to db
    mysqli_close($conn);


    // print_r($pizzas)
    // print_r (explode(',', $pizzas[0]['ingredients']));       //splits a string into an array after each comma
?>

<!DOCTYPE html>
<html lang="en">
    <?php include('templates/header.php') ?>



    <h4 class="center grey-text">Pizzas!</h4>

    <div class="container">
        <div class="row">

            <?php foreach($pizzas as $pizza){ ?>
            <div class="col s6 md3">
                <div class="card z-depth-0">
                    <div class="card-content center">
                        <p><?php echo htmlspecialchars($pizza['title']); ?></p>
                        <ul>
                            <?php foreach(explode(',', $pizza['ingredients'])as $ing){ ?> <!-- refer to each seperate ingredient as ing -->
                                <li> <?php echo htmlspecialchars($ing) ?> </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="card-action right-align">
                        <a href="details.php?id=<?php echo $pizza['id']; ?>" class="brand-text">More info</a> 
                        <!-- for individual page about pizza. Redirect to details page alongside pizza id -->
                    </div>
                </div>
            </div>
            <?php } ?>

        </div>
    </div>



    <!-- https://www.youtube.com/watch?v=3T8bp9DlypU -->




    <?php include('templates/footer.php') ?>
</html>