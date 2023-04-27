 <?php $supp_id = $_SESSION['supp_id']; ?>
 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
   <!-- Left navbar links -->
   <ul class="navbar-nav">
     <li class="nav-item">
       <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
     </li>
   </ul>

   <!-- Right navbar links -->
   <ul class="navbar-nav ml-auto">

     <!-- Notifications Dropdown Menu  -->
     <li class="nav-item dropdown">
       <?php
        $stmt = $connect->prepare("SELECT * FROM sup_notification WHERE supp_id=? AND status = 0");
        $stmt->execute(array($supp_id));
        $allnoti = $stmt->fetchAll();
        $allnoti_count = $stmt->rowCount();
        ?>
       <a class="nav-link" data-toggle="dropdown" href="#">
         <i class="far fa-bell"></i>
         <span class="badge badge-warning navbar-badge"><?php echo $allnoti_count; ?></span>
       </a>
       <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

         <div class="dropdown-divider"></div>
         <?php
          if ($allnoti_count > 0) {
            foreach ($allnoti as $noti) {
              if ($noti['name'] == "Add New Order") {
          ?>
               <div class="dropdown-divider"></div>
               <a href="main.php?dir=supp_dash&page=report&sup_id=<?php echo $noti['supp_id'] ?>&emp_id=<?php echo $noti['emp_id'] ?>" class="dropdown-item">
                 <i class="fas fa-file mr-2"></i> <?php echo $noti['noti_desc'] ?>
               </a>
             <?php
              } elseif ($noti['name'] == "Edit Order") {
              ?>
               <div class="dropdown-divider"></div>
               <a href="main.php?dir=supp_dash&page=order_details&from=<?php echo $noti['from_date'] ?>&to=<?php echo $noti['to_date']?>&sup_id=<?php echo $noti['supp_id'] ?>&emp_id=<?php echo $noti['emp_id'] ?>" class="dropdown-item">
                 <i class="fas fa-file mr-2"></i> <?php echo $noti['noti_desc'] ?>
               </a>
           <?php
              }
            }
          } else {
            ?>
           <div class="dropdown-divider"></div>
           <a class="dropdown-item">
             <i class="fas fa-file mr-2"></i> There are no notifications
           </a>
         <?php
          }

          ?>

       </div>
     </li>

     <li class="nav-item">
       <a class="nav-link" data-widget="fullscreen" href="#" role="button">
         <i class="fas fa-expand-arrows-alt"></i>
       </a>
     </li>

   </ul>
 </nav>
 <!-- /.navbar -->

 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
   <!-- Brand Logo -->
   <a href="main.php?dir=dashboard&page=sup_dashboard" class="brand-link">
     <img src="uploads/new_logo.png" alt="di-tech" class="brand-image img-circle elevation-3" style="opacity: .8">
     <span style="color:#fff;" class="brand-text font-weight-bold">Di-Tech</span>
   </a>

   <!-- Sidebar -->
   <div class="sidebar">
     <!-- Sidebar user panel (optional) -->
     <div class="user-panel mt-3 pb-3 mb-3 d-flex">
       <div class="image">
         <img src="uploads/avatar.gif" class="img-circle elevation-2" alt="User Image">
       </div>
       <div class="info">
         <?php
          $stmt = $connect->prepare("SELECT * FROM presentions WHERE id=?");
          $stmt->execute(array($_SESSION['supp_id']));
          $data = $stmt->fetch();
          ?>
         <a href="main.php?dir=profile&page=report" class="d-block"> <?php echo $data['name']; ?> </a>
       </div>
     </div>


     <!-- Sidebar Menu -->
     <nav class="mt-2">
       <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
         <li class="nav-item menu-open">
           <a href="main.php?dir=dashboard&page=sup_dashboard" class="nav-link active">
             <i class="nav-icon fas fa-tachometer-alt"></i>
             <p>
               Dashboard

             </p>
           </a>
         </li>
         <li class="nav-item">
           <a href="#" class="nav-link">
             <i class="nav-icon fas fa-copy"></i>
             <p>
               Orders
               <i class="fas fa-angle-left right"></i>
             </p>
           </a>
           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="main.php?dir=supp_dash&page=all_emp" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>All Orders</p>
               </a>
             </li>
           </ul>
         </li>
         <li class="nav-item">
           <a href="#" class="nav-link">
             <i class="nav-icon fas fa-edit"></i>
             <p>
               Setting
               <i class="fas fa-angle-left right"></i>
             </p>
           </a>
           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="main.php?dir=profile&page=report" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p> Profile </p>
               </a>
             </li>
           </ul>
         </li>
         <li class="nav-item">
           <a href="logout" class="nav-link">
             <i class="fa fa-sign-out-alt"></i>
             <p>
               Logout
             </p>
           </a>
         </li>
       </ul>
     </nav>
     <!-- /.sidebar-menu -->
   </div>
   <!-- /.sidebar -->
 </aside>