<?php
    require_once "db.php";

    // check if the $_GET array contains the search key
    // if does, it means the search form has been submitted, from here we can access to the search item by $_GET['search']
    if (isset($_GET['search'])) {
        // important: anytime we need to make a query where we will be inserting data recieved from a user, we use prepared stmt to protcet from malicious code or malicious insertions
        // prepared stmt
        $sql = "SELECT * FROM books WHERE book_title LIKE 
            -- :search is a placeholder where our prepared stmt will insert the actual value later on
            :search";
        // send the prepared stmt to the database so it's aware of it
        // $stmt is a varieble used to hold the returned prepared stmt
        // $db->prepare($sql) is how we send the prepared stmt
        $stmt = $db->prepare($sql);
        // bind the value to the placeholder
        $stmt->bindValue(':search', "%{$_GET['search']}%");
        $stmt->execute();
        $books = $stmt->fetchAll();
    } else {
        // get the query
        $sql = "SELECT * FROM books";
        // send the query, $result will return a PDO stmt, not an actual result we want
        $result = $db->query($sql);
        // to get the actual result (retrieve the entire array) by fetchAll and store them in $books
        $books = $result->fetchAll();
    }
?>

    <?php include 'header.php'; ?>
    <form class="search">
        <input type="search" name="search" placeholder="Search">
    </form>
    <section>
        <?php foreach ($books as $book) : ?>
            <a href="book.php?id=<?php echo $book['book_id']; ?>">
                <?php if($book['book_image']) { 
                        echo "<img src='book-covers/".$book['book_image']."'>";
                } else { 
                        echo "<div>".$book['book_title']."</div>"; 
                }?>
            </a>
        <?php endforeach; ?>
    </section>
</body>
</html>