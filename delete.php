<?php 
    require_once "db.php";

    if (isset($_POST['book_id'])) {
        $sql = "DELETE FROM books WHERE book_id = :book_id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':book_id', $_POST['book_id']);
        $stmt->execute();     
    }
        
    header("Location: index.php");  
?>