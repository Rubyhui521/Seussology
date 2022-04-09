<?php 
    require_once "db.php";

    if (isset($_POST['book_title'])) {
        // prepared stmt
        $sql = "UPDATE books SET 
            book_title = :book_title,
            book_title_sort = :book_title_sort,
            book_year = :book_year,
            book_pages = :book_pages,
            book_description = :book_description
            WHERE book_id = :book_id";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ":book_title" => $_POST['book_title'],
            ":book_title_sort" => $_POST['book_title_sort'],
            ":book_year" => $_POST['book_year'],
            ":book_pages" => $_POST['book_pages'],
            ":book_description" => $_POST['book_description'],
            ":book_id" => $_POST['book_id']
        ]);

        if ($stmt->rowCount()) {
            header ("Location: book.php?id={$_POST['book_id']}");
        }
    }

    // the 'id' is the id in the url that's why we call it 'id'
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
    } else {
        header("Location: index.php");
    }
?>

    <?php include 'header.php'; ?>
    <form class="form" method="POST">
        <h2>Edit Book</h2>
        <!-- we need to use book_id in this html file so that the book_id in $stmt->execute() will be valid therefore will not cause an error -->
        <!-- book_id will be a data that the user won't change, in this case we give the type of the input "hidden" -->
        <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
        <label>Title</label>
        <input type="text" name="book_title" value="<?php echo $book['book_title']; ?>" required>
        <label>Sort Title</label>
        <input type="text" name="book_title_sort" value="<?php echo $book['book_title_sort']; ?>" required>
        <label>Published Year</label>
        <input type="number" name="book_year" value="<?php echo $book['book_year']; ?>" required>
        <label>Number of Pages</label>
        <input type="number" name="book_pages" value="<?php echo $book['book_pages']; ?>" required>
        <label>Book Description</label>
        <input type="text" name="book_description" value="<?php echo $book['book_description']; ?>" required>
        <button type="submit">Update Book</button>
    </form>
    <form class="delete" method="POST" action="delete.php">
        <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
        <button type="submit">Delete Book</button>
    </form>
</body>
</html>