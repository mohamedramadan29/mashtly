<!--<footer class="main-footer">
  <strong>Created by Mohamed Ramadan </strong>
 

</footer>
-->
<!-- Control Sidebar -->
<aside style="display: none;" class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>

<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- bs-custom-file-input -->
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!--  START TIME PICKER -->

<!-- jQuery UI -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>

<!-- End Time Picker -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- jQuery -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<!-- Ekko Lightbox -->
<script src="plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/dropify.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/main.js"></script>
<!-- confirm delete message   -->
<script>
  // Select all the buttons with the "confirm-button" class
  var buttons = document.querySelectorAll('.confirm');
  // Loop through the buttons and add a click event listener
  buttons.forEach(function(button) {
    button.addEventListener('click', function(event) {
      // Display the confirmation dialog
      if (!confirm("هل انت متاكد من عملية الحذف ؟ ")) {
        event.preventDefault(); // Prevent the button from doing anything
      }
    });
  });
</script>
<script>
  jQuery(function($) {
    $('.pro-attribute').change(function() {
      var pro_attribute = $(this).val();
      var uniqueId = $(this).data('new'); // استخدام الـ data-uniqueId للوصول إلى القيمة الفريدة
      console.log(uniqueId);
      if (pro_attribute != '') {
        $.ajax({
          url: "products/get_variation.php",
          method: "POST",
          data: {
            pro_attribute: pro_attribute
          },
          success: function(data) {
            $('.pro-variation[data-uniqueId="' + uniqueId + '"]').html(data); // استخدام الـ uniqueId لتحديد العنصر المستهدف بشكل فريد
          }
        });
      } else {
        $('.pro-variation[data-uniqueId="' + uniqueId + '"]').html('<option value="">-- اختر --</option>'); // استخدام الـ uniqueId لتحديد العنصر المستهدف بشكل فريد
      }
    });
  });
</script>

<script>
  // استهداف زر "اضافة الى المعرض"
  let addToGalleryBtn = document.getElementById('add_to_gallary');

  addToGalleryBtn.addEventListener('click', function() {
    // إنشاء العنصر الجديد
    let newGalleryItem = document.createElement('div');
    newGalleryItem.classList.add('form-group');

    // إضافة الأكواد التي تحتوي على إضافة الصورة وتفاصيلها داخل العنصر الجديد
    newGalleryItem.innerHTML = `
    <div class="form-group">
      <label for="customFile"> اضافة صورة </label>
      <div class="custom-file">
        <input type="file" class="dropify form-control" multiple data-height="150" data-allowed-file-extensions="jpg jpeg png svg" data-max-file-size="4M" name="more_images[]" data-show-loader="true" />
      </div>
      <div class="image_gallary_details">
        <br>
        <input type="text" class="form-control" name="image_name_gallary[]" placeholder="اسم الصورة">
        <br>
        <input type="text" class="form-control" name="image_alt_gallary[]" placeholder="الاسم البديل">
        <br>
        <input type="text" class="form-control" name="image_desc_gallary[]" placeholder="وصف مختصر ">
      </div>
      <br>
      <button class="btn btn-sm btn-danger delete_gallery_item"> حذف الصورة <i class='fa fa-trash'></i>  </button>
    </div>
  `;

    // إضافة العنصر الجديد إلى الصفحة
    let imageGallery = document.querySelector('.image_gallary');
    imageGallery.appendChild(newGalleryItem);

    // استهداف زر "حذف" داخل العنصر الجديد
    let deleteBtn = newGalleryItem.querySelector('.delete_gallery_item');

    // إضافة حدث النقر على زر "حذف" لحذف العنصر الجديد
    deleteBtn.addEventListener('click', function() {
      newGalleryItem.remove();
    });
  });
</script>
</body>

</html>