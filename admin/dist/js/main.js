$(document).ready(function () {

    $("#show_details_image").click(function () {
        $(".image_details").toggle();
    });
    $("#var_product").click(function () {
        $("#attributes-containerxx").toggle();
    });
    $(".verify_variations2").click(function () {
        $("#product-variants").hide();
        $("#save_vartion").css("display", "block");
    });
    $('.select2').select2();
    $("#add_new_vartionss").click(function () {
        $(".add_new_vartions_form").toggle();
    });
    // Datatable 

    $('#my_table').DataTable({
        "paging": true,
        "lengthChange": false,
        "pageLength": 1000, // هنا تقوم بتعيين عدد الصفوف إلى 30
        "searching": true,
        "ordering": true,
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
            },
            "decimal": ",",
            "infoFiltered": "(مرشحة من مجموع _MAX_ مُدخل)",
            "searchPlaceholder": "بحث"
        },
        "dom": 'Bfrtip',
        // "buttons": [
        //     {
        //         extend: 'excel',
        //         text: ' تصدير الملف ',
        //         exportOptions: {
        //             columns: [1,2,3,4,5,12,13] // تحديد الأعمدة التي تحتاجها بواسطة مؤشرات الأعمدة
        //         }
        //     },
        //     // زر تصدير آخر إلى PDF إذا كنت بحاجة إليه
        // ]
        //"responsive": true,
    });

    

    // Use Dropify 

    $('.dropify').dropify({
        messages: {
            'default': 'قم بسحب وإفلات الصورة هنا أو انقر للتصفح',
            'replace': 'قم بسحب وإفلات الصورة هنا أو انقر للتصفح لتعويض الصورة',
            'remove': 'إزالة',
            'error': 'عذرًا ، حدث خطأ أثناء تحميل الملف'
        }
    });
    // Summernote
    $('#summernote').summernote({
        tabsize: 2,
        height: 200,
        lang: 'ar-EG'
    });
    // Summernote
    $('.summernote').summernote({
        tabsize: 2,
        height: 200,
        lang: 'ar-EG'
    });
});

