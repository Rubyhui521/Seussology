<?php 
    require_once "db.php";

    // check to see if the form has been submitted
    // use book_title as a key to indicate that the form has been submitted
    if (isset($_POST['book_title'])) {
        // use prepared stmt bc we are dealing with the data come from the users
        $sql = "INSERT INTO books (book_title, book_title_sort, book_year, book_pages, book_description) VALUES (:book_title, :book_title_sort, :book_year, :book_pages, :book_description)";
        $stmt = $db->prepare($sql);
        // binding the values while excute the stmt by using this shortcut below
        $stmt->execute([
            ":book_title" => $_POST['book_title'],
            ":book_title_sort" => $_POST['book_title_sort'],
            ":book_year" => $_POST['book_year'],
            ":book_pages" => $_POST['book_pages'],
            ":book_description" => $_POST['book_description'],
        ]);

        // use rowCount() method to check if a row has been affected to see if our query was successful
        // one row has been affected: return 1
        // zero row has been affected: return 0 (false)
        if ($stmt->rowCount()) {
            // redirect from the new form to the index.php page when we submitted the form
            header ("Location: book.php?id={$db->lastInsertId()}");
        };

        // $sql = "INSERT INTO quotes (quote) VALUE (:quote)";
        // $stmt = $db->prepare($sql);
        // $stmt->execute([":quote" => $_POST['quote']]);
    }
?>

    <?php include 'header.php'; ?>
    <form class="form" method="POST">
        <h2>Add Book</h2>
        <label>Title</label>
        <input type="text" name="book_title" required>
        <label>Sort Title</label>
        <input type="text" name="book_title_sort" required>
        <label>Published Year</label>
        <input type="number" name="book_year" required>
        <label>Number of Pages</label>
        <input type="number" name="book_pages" required>
        <label>Book Description</label>
        <input type="text" name="book_description" required>
        <!-- <input type="hidden" name="quote"> -->
        <button type="submit">Add Book</button>
    </form>
</body>
</html>