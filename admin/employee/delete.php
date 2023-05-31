<?php
if (isset($_GET['emp_id']) && is_numeric($_GET['emp_id'])) {
    $emp_id = $_GET['emp_id'];

    $stmt = $connect->prepare('SELECT * FROM employes WHERE id= ?');
    $stmt->execute([$emp_id]);
    $count = $stmt->rowCount();
    if ($count > 0) {
        $stmt = $connect->prepare('DELETE FROM employes WHERE id=?');
        $stmt->execute([$emp_id]);
        if ($stmt) {  
          $_SESSION['success_message'] = " تم الحذف بنجاح  ";
            header('Location:main?dir=employee&page=report'); 
        }
    }
}
