<footer class="main-footer">
  <strong>Created by Dietitian: <a> SULAIMAN ALHARBI </a>.</strong>
  Under the supervision of Ms. Hanaa Noor, Head of Nutrition Care

</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

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

<!-- jQuery Timepicker Addon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.0/jquery.timepicker.min.css" integrity="sha512-wlq3zFYkFJpXnb4v4A4p4KUJ10C4sB6xv2Sxum+8RLGhLXb/VyMDvQJH7DN/GvtJzGZcY+JrSErV7LmGm/ZuEg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.0/jquery.timepicker.min.js" integrity="sha512-vQYMD3qZh+pcpxmAHXcQT/rO9LJWmp4ev4vM6UzWWBb/ty6WTEfg8TQxLyRGJ/l1+m0NkV7n8a2zEdV7Jg+1eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- End Time Picker -->

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- jQuery -->

<!-- Bootstrap 4 -->
<script src="dist/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/adminlte/js/adminlte.min.js"></script>
<!-- Page specific script -->
<!-- Page specific script -->
<script>
  $(function() {
    //Initialize Select2 Elements
    $('.select2').select2()
    /*
        $("#example1").DataTable({
          "responsive": true,
          "lengthChange": false,
          "autoWidth": false,
          //  "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
          "buttons": ["excel", "pdf"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');*/
    $('#my_table').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "info": false,
      "autoWidth": false,
      language: {
        "search": "ابحث:",
        "emptyTable": " لا يوجد بيانات ",
        "infoEmpty": " لا يوجد بيانات ",
        "infoFiltered": " لا يوجد بيانات ",
        "paginate": {
          "first": "الأول",
          "previous": "السابق",
          "next": "التالي",
          "last": "الأخير"
        },
        "searchBuilder": {
          "add": "اضافة شرط",
          "clearAll": "ازالة الكل",
          "condition": "الشرط",
          "data": "المعلومة",
          "logicAnd": "و",
          "logicOr": "أو",
          "value": "القيمة",
          "conditions": {
            "date": {
              "after": "بعد",
              "before": "قبل",
              "between": "بين",
              "empty": "فارغ",
              "equals": "تساوي",
              "notBetween": "ليست بين",
              "notEmpty": "ليست فارغة",
              "not": "ليست "
            },
            "number": {
              "between": "بين",
              "empty": "فارغة",
              "equals": "تساوي",
              "gt": "أكبر من",
              "lt": "أقل من",
              "not": "ليست",
              "notBetween": "ليست بين",
              "notEmpty": "ليست فارغة",
              "gte": "أكبر أو تساوي",
              "lte": "أقل أو تساوي"
            },
            "string": {
              "not": "ليست",
              "notEmpty": "ليست فارغة",
              "startsWith": " تبدأ بـ ",
              "contains": "تحتوي",
              "empty": "فارغة",
              "endsWith": "تنتهي ب",
              "equals": "تساوي",
              "notContains": "لا تحتوي",
              "notStartsWith": "لا تبدأ بـ",
              "notEndsWith": "لا تنتهي بـ", 

            },
            "array": {
              "equals": "تساوي",
              "empty": "فارغة",
              "contains": "تحتوي",
              "not": "ليست",
              "notEmpty": "ليست فارغة",
              "without": "بدون"
            }
          },
          "button": {
            "0": "فلاتر البحث",
            "_": "فلاتر البحث (%d)"
          },
          "deleteTitle": "حذف فلاتر",
          "leftTitle": "محاذاة يسار",
          "rightTitle": "محاذاة يمين",
          "title": {
            "0": "البحث المتقدم",
            "_": "البحث المتقدم (فعال)"
          }
        },
        "searchPanes": {
          "clearMessage": "ازالة الكل",
          "collapse": {
            "0": "بحث",
            "_": "بحث (%d)"
          },
          "count": "عدد",
          "countFiltered": "عدد المفلتر",
          "loadMessage": "جارِ التحميل ...",
          "title": "الفلاتر النشطة",
          "showMessage": "إظهار الجميع",
          "collapseMessage": "إخفاء الجميع",
          "emptyPanes": "لا يوجد مربع بحث"
        },
        "infoThousands": ",",
        "datetime": {
          "previous": "السابق",
          "next": "التالي",
          "hours": "الساعة",
          "minutes": "الدقيقة",
          "seconds": "الثانية",
          "unknown": "-",
          "amPm": [
            "صباحا",
            "مساءا"
          ],
          "weekdays": [
            "الأحد",
            "الإثنين",
            "الثلاثاء",
            "الأربعاء",
            "الخميس",
            "الجمعة",
            "السبت"
          ],
          "months": [
            "يناير",
            "فبراير",
            "مارس",
            "أبريل",
            "مايو",
            "يونيو",
            "يوليو",
            "أغسطس",
            "سبتمبر",
            "أكتوبر",
            "نوفمبر",
            "ديسمبر"
          ]
        },

        "decimal": ",",
        "infoFiltered": "(مرشحة من مجموع _MAX_ مُدخل)",
        "searchPlaceholder": "بحث"
      },
      //"responsive": true,
    });
  });
  $(function() {
    bsCustomFileInput.init();
  });
</script>


</body>

</html>