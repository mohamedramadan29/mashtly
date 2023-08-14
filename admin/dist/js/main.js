$(document).ready(function () {

    $("#show_details_image").click(function () {
        $(".image_details").toggle();
    });
    $("#var_product").click(function () {
        $("#attributes-containerxx").toggle();
    });

    $('.select2').select2();

    // Datatable 

    $('#my_table').DataTable({
        "paging": true,
        "lengthChange": true,
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

