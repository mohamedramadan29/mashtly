<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" >
</head>
<body>

 <?php 
  require_once("connect.php");
  $stmt = $connect->prepare("SELECT * FROM products limit 10");
  $stmt->execute();
  $products = $stmt->fetchAll();
  $html = '<table class="table table-striped table-hover table-bordered border-primary text-center">
              <tr>
                 <th style="width:100px">Sl No</th>
                 <th style="width:100px">Name</th>
                 <th style="width:100px">Price</th>
                 <th style="width:100px">Image</th>
              </tr>';
             
              foreach ($products as $data) {
              $html.='<tr style="height:100px">
              <td>'.$data['id'].'</td>
              <td>'.$data['name'].'</td>
              <td>'.$data['price'].'</td>
              <td><img src="https://www.mshtly.com/logo.webp"></td>
              </tr> ';

              }

              


              $html.='</table>';
             header('Content-Type:application/xls');
             header('Content-Disposition:attatchment;filename=student.xls');
             echo $html;
             

 ?>

</table>

</body>
</html>