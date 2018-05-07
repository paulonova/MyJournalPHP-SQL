<?php   require_once "partials/journal_head.php"; 
        require_once "classes/entry.php";
        require_once 'partials/database.php';

        if(isset($_GET['edit'])){
            $id = $_GET['edit'];
            $edit_state = true;
            $_SESSION['entryID'] = $_GET['edit'];
            
            $statement = $pdo->prepare("SELECT * FROM entries WHERE entryID= :entryID ORDER BY createdAt ASC");
            $statement->execute([
                "entryID" => $_GET['edit']
            ]);

            $record = $statement->fetch();
            $date = explode(" ", $record["createdAt"]);

        }else{
            $edit_state = false;
            $record['title'] = "";
            $record['content'] = "";    
        }

?>

<!-- Alert Dialog -->
<?php if(isset($_SESSION['msg'])):?>
        
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <?php 
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            ?>
        </div> 

<?php endif ?>

<div class="inlamning_title jumbotron">
    <h1 class="journal_title">My Journal</h1>    
</div>


<main class="container">
    
    <section class="jornal_form"> <!-- Section Journal Entries -->
    <h1 class="saved_articles">Create Entry</h1>
        <form action='./partials/get_all_entries.php' method='POST'>

            <label for="journal_title" class="sr-only">Username</label> <!-- Title -->
            <input type="text" name ="journal_title" value= "<?php echo $record['title'] ?>" 
                    id="journal_title" class="form-control" 
                    placeholder="Journal Title.." required autofocus> <!-- Title -->
            
            <label for="journal_area" class="sr-only">Journal:</label>  <!-- Journal annotation -->
            <textarea class="form-control" name="journal_area" id="journal_area" 
                    placeholder="Write you journal here.." rows="4" required autofocus><?php echo $record['content'] ?></textarea>  <!-- Journal annotation -->

            <label for="journal_date" class="sr-only">Date:</label>  <!-- Date -->
            <input type="date" class="form-control" name="journal_date" value="<?php echo $date[0]?>" 
                    placeholder="yyyy/mm/dd" required autofocus/>  <!-- Date -->

            <div class="signin_btn"> <!-- Save/Logout button -->
                <button id="logout" class="btn btn-warning" type="button">
                    <a href='logout.php'>Logout here</a>
                </button>    

                <?php if($edit_state == false): ?>
                    <input class="btn btn-lg btn-primary" name="save" value="Save" type="submit">
                <?php else: ?>
                    <input class="btn btn-lg btn-primary" name="update" value="Update" type="submit">
                <?php endif ?>

                             
                
            <!-- </div> Save/Logout button -->

        </form>
    </section><!-- Section Journal Entries -->
    <hr>
    


    <br/>
    <section> <!-- Section Journals from database -->
        <article class="saved_journal" id="db_articles">
            <h1 class="saved_articles">Saved Articles</h1>
            <div class="journal_container">
                <?php
                $statement = $pdo->prepare("SELECT * FROM entries WHERE userID = :user_id 
                                            ORDER BY createdAt");
                $statement->execute([
                    ":user_id" => $_SESSION['user_id']
                ]);

                $entries = $statement->fetchAll();
                $journalsList = array();

                foreach ($entries as $entry) {
                    $date = explode(" ",$entry["createdAt"]);
                    $journal = new Entries(
                                        $entry["entryID"], 
                                        $entry["title"], 
                                        $entry["content"], 
                                        $date[0],
                                        $entry["userID"]
                                        );
                        array_push($journalsList, $journal);
                        echo $journal-> createCardElement();                    
                }          
                
                ?>
            </div>
        </article>


    </section>
    

</main>



<?php require_once "partials/footer.php";  ?>