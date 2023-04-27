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
     <a href="main.php?dir=dashboard&page=dashboard" class="brand-link">
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
                    $stmt = $connect->prepare("SELECT * FROM supervisor WHERE id=?");
                    $stmt->execute(array($_SESSION['super_id']));
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
                     <a href="main.php?dir=dashboard&page=dashboard" class="nav-link active">
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
                             Request Order
                             <i class="fas fa-angle-left right"></i>
                             <span class="badge badge-info right">6</span>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="main.php?dir=categories&page=report" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Categories</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="main.php?dir=items&page=report" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Category Items</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="main.php?dir=menus&page=report" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Menus Options</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="main.php?dir=main_menu&page=report" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Main Menus</p>
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
                             <a href="main.php?dir=setting&page=report_emp" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p> Emplyees </p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="main.php?dir=setting&page=report_pre" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Suppliers</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="main.php?dir=login_page&page=report" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Login Page</p>
                             </a>
                         </li>
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