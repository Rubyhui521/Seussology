<?php 
    require_once "db.php";

    if (isset($_GET['id'])) {
        // the 1st query stmt
        // prepared stmt
        $sql = "SELECT * FROM books WHERE book_id = :book_id";
        // send the prepared stmt to the database by a prepare() method
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':book_id', $_GET['id']);
        $stmt->execute();
        // fetch() method is used to fetch the next row from a result set
        $book = $stmt->fetch();

        // the 2nd query stmt
        // we can reuse $sql
        // we are not using the prepared stmt here bc we are not using a data coming from the user but from the $book array
        // {$book['book_id']} is a string interpolation
        $sql = "SELECT quote FROM quotes WHERE book_id = {$book['book_id']}";
        // use a query() method on this straight query
        $result = $db->query($sql);
        $quotes = $result->fetchAll();
    } else {
        header("Location: index.php");
    }
?>

    <?php include 'header.php'; ?>
    <div class="detail">
        <h2><?php echo $book['book_title']; ?></h2>
        <div class="detail-content">
            <div class="datail-img">
                <?php if($book['book_image']) { 
                        echo "<img src='book-covers/".$book['book_image']."'>";
                } else { 
                        echo "<div>".$book['book_title']."</div>"; 
                }?>
            </div>
            <div class="detail-text">
                <div>
                    <h3>About the book</h3>
                    <p><?php echo $book['book_description']; ?></p>
                    <p>Published: <?php echo $book['book_year']; ?></p>
                    <?php if ($book['book_pages']) {
                        echo "<p>Pages: ".$book['book_pages']."</p>";
                    } else {
                        echo "";
                    }
                    ?>
                </div>
                <?php foreach ($quotes as $quote): ?>
                    <?php if ($quote['quote']) {
                        echo "
                        <h3>Book Quotes</h3>
                        <p>".$quote['quote']."</p>
                        ";
                    } else {
                        echo "";
                    }
                    ?>
                <?php endforeach; ?>
                <!-- insert the current book_id into the href -->
                <button><a href="edit.php?id=<?php echo $book['book_id']; ?>">Edit</a></button>
            </div>
        </div>
    </div> 
</body>
</html>