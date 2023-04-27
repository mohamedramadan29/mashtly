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
         <!-- Notifications Dropdown Menu -->
         <!-- START Goal NOTIFICATION  -->
         <?php
            $emp_id = $_SESSION['emp_id'];
            $date = date("Y-m-d");
            $stmt = $connect->prepare("SELECT * FROM  goals WHERE client_id=? AND date = ? AND status = 0");
            $stmt->execute(array($emp_id, $date));
            $data = $stmt->fetch();
            $count = $stmt->rowCount();
            if ($count > 0) {
                $stmt = $connect->prepare("SELECT * FROM notification WHERE emp_id=? AND noti_desc=? AND date=?");
                $stmt->execute(array($emp_id, "Remmber Goals Notification", $date));
                $count_noti_goal = $stmt->rowCount();
                if ($count_noti_goal > 0) {
                } else {
                    $stmt = $connect->prepare("INSERT INTO notification (emp_id, noti_desc,date) VALUES (:zemp_id,:znoti_desc,:zdate)");
                    $stmt->execute(array(
                        'zemp_id' => $emp_id,
                        "znoti_desc" => "Remmber Goals Notification",
                        'zdate' => $date
                    ));
                }
            }
            ?>
         <!-- END Goal NOTIFICATION -->
         <li class="nav-item dropdown">
             <?php
                $stmt = $connect->prepare("SELECT * FROM notification WHERE emp_id=? AND status = 0");
                $stmt->execute(array($emp_id));
                $allnoti = $stmt->fetchAll();
                $allnoti_count = $stmt->rowCount();
                ?>
             <a class="nav-link" data-toggle="dropdown" href="#">
                 <i class="far fa-bell"></i>
                 <span class="badge badge-warning navbar-badge"><?php echo $allnoti_count; ?></span>
             </a>
             <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                 <?php
                    if ($allnoti_count > 0) {
                        foreach ($allnoti as $noti) {
                            if ($noti['noti_desc'] == "Remmber Goals Notification") {
                    ?>
                             <div class="dropdown-divider"></div>
                             <a href="main.php?dir=goals&page=report&goal_noti=<?php echo $noti['id']; ?>" class="dropdown-item">
                                 <i class="fas fa-file mr-2"></i> <?php echo $noti['noti_desc'] ?>
                             </a>
                         <?php
                            } elseif ($noti['name'] == "accept_order") {
                            ?>
                             <div class="dropdown-divider"></div>
                             <a href="main.php?dir=main_menu&page=emp_orders" class="dropdown-item">
                                 <i class="fas fa-file mr-2"></i> <?php echo $noti['noti_desc'] ?>
                             </a>
                         <?php
                            } elseif ($noti['name'] == "reject_order") {
                            ?>
                             <div class="dropdown-divider"></div>
                             <a href="main.php?dir=main_menu&page=emp_orders" class="dropdown-item">
                                 <i class="fas fa-file mr-2"></i> <?php echo $noti['noti_desc'] ?>
                             </a>
                         <?php
                            } elseif ($noti['name'] == 'goal_progress') { ?>
                             <div class="dropdown-divider"></div>
                             <a href="main.php?dir=clients&page=report" class="dropdown-item">
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
     <a href="main.php?dir=dashboard&page=emp_dashboard" class="brand-link">
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
                    $stmt = $connect->prepare("SELECT * FROM emplyees WHERE id=?");
                    $stmt->execute(array($_SESSION['emp_id']));
                    $emp_data = $stmt->fetch();
                    ?>
                 <a href="main.php?dir=profile&page=report" class="d-block"> <?php echo $emp_data['emp_name']; ?> </a>
             </div>
         </div>
         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                 <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                 <li class="nav-item menu-open">
                     <a href="main.php?dir=dashboard&page=emp_dashboard" class="nav-link active">
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
                             Orders Tool
                             <i class="fas fa-angle-left right"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="main.php?dir=main_menu&page=report" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p> Make Order </p>
                             </a>
                             <a href="main.php?dir=main_menu&page=emp_orders" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p> All Orders </p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">
                         <i class="nav-icon fas fa-chart-pie"></i>
                         <p>
                             statistics & Reports
                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="main.php?dir=sessions&page=report" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p> sessions </p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="main.php?dir=statistics&page=report" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p> Daily Tracker </p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="main.php?dir=reports&page=report" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p> Reports </p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <li class="nav-item">
                     <a href="main.php?dir=calculator&page=report" class="nav-link">
                         <i class="fa fa-calculator"></i>
                         <p>
                             calculator
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">
                         <i class="nav-icon fas fa-users"></i>
                         <p>
                             Behavior Changes Tool
                             <i class="fas fa-angle-left right"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="main.php?dir=clients&page=report" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p> All Patients </p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">
                         <i class="nav-icon fa fa-bell"></i>
                         <p>
                             Dietition Reminders
                             <i class="fas fa-angle-left right"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="main.php?dir=goals&page=report" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p> All goals </p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">
                         <i class="nav-icon fa fa-book"></i>
                         <p>
                             Dietition Library
                             <i class="fas fa-angle-left right"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="main.php?dir=pdf_files&page=report" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p> All files </p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <li class="nav-item">
                     <a href="main.php?dir=items_desc&page=report" class="nav-link">
                         <i class="nav-icon fa fa-audio-description"></i>
                         <p>
                             Food & Drug Interaction Cheacker
                             <i class="fas fa-angle-left right"></i>
                         </p>
                     </a>
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