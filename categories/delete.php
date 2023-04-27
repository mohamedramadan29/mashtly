<?php
if (isset($_GET['cat_id']) && is_numeric($_GET['cat_id'])) {
    $cat_id = $_GET['cat_id'];

    $stmt = $connect->prepare('SELECT * FROM category WHERE id= ?');
    $stmt->execute([$cat_id]);
    $count = $stmt->rowCount();
    if ($count > 0) {
        $stmt = $connect->prepare('DELETE FROM category WHERE id=?');
        $stmt->execute([$cat_id]);
        if ($stmt) {  
          $_SESSION['success_message'] = " Deleted successfully ";
            header('Location:main?dir=categories&page=report'); 
        }
    }
}
