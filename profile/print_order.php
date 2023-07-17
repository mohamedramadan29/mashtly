<?php
ob_start();
session_start();
$page_title = ' طباعه فاتورة | مشتلي ';
include 'init.php';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $order_number = $_GET['order_number'];
?>

    <style>
        @media print {


            .footer,
            .bottom_footer,
            .main_navbar,
            .instagrame_footer {
                display: none !important;
            }

            .print_order {
                max-width: 100% !important;
            }

            body {
                background-color: #fff;
            }

            #print_Button {
                display: none !important;
            }

            .print-link {
                display: none !important;
            }

            @page {
                margin: 0;
            }

            body {
                margin: 1.6cm;
            }
        }
    </style>
    <div class="profile_page">
        <div class='container'>
            <div class="data">
                <div class="print_order">
                    <div class="print printable-content" id="print">
                        <div class="print_head">
                            <div class="logo">
                                <img src="<?php echo $uploads ?>/logo.png" alt="">
                            </div>
                            <div class="person_data">
                                <h2> مرحبا أحمد سمير </h2>
                                <p> شكرا لطلبك، من مشتلي تم تأكيد طلبك وسوف يصلك في الوقت المحدد لإلغاء الطلب أو تعديله يرجي زيارة الموقع قسم <span style="color: var(--second-color);"> مشترياتي </span> </p>
                                <p> يوجد أدناه فاتورة برقم الطلب وتفاصيله </p>
                            </div>
                            <ul class="list-unstyled">
                                <li> <span> رقم الطلب: </span> #62403441 </li>
                                <li> <span> تاريخ الطلب: </span> 30 مايو 2023 | 10:31 مساءً </li>
                                <li> <span> الاسم: </span> أحمد سمير </li>
                                <li> <span> رقم الجوال: </span> +201092508803 </li>
                            </ul>
                        </div>
                        <div class="order_details">
                            <h4> تفاصيل الطلب </h4>
                            <div class="order">
                                <div>
                                    <h6> المنتج </h6>
                                </div>
                                <div>
                                    <h6> الكمية </h6>
                                </div>
                                <div>
                                    <h6> إجمالي السعر </h6>
                                </div>
                            </div>
                            <div class="order" style="display: flex;">
                                <div>
                                    <div class="product_data">
                                        <div class="image">
                                            <img src="<?php echo $uploads ?>/product.png" alt="">
                                        </div>
                                        <div>
                                            <h4>شجيرة التيكوما</h4>
                                            <p> 87.00 ر.س </p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <span> 1 </span>
                                </div>
                                <div>
                                    <span> 87.00 ر.س </span>
                                </div>
                            </div>
                            <div class="order">
                                <div>
                                    <div class="product_data">
                                        <div class="image">
                                            <img src="<?php echo $uploads ?>/product.png" alt="">
                                        </div>
                                        <div>
                                            <h4>شجيرة التيكوما</h4>
                                            <p> 87.00 ر.س </p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <span> 1 </span>
                                </div>
                                <div>
                                    <span> 87.00 ر.س </span>
                                </div>
                            </div>
                        </div>
                        <div class="order_totals">
                            <div class="price_sections">
                                <div class="first">
                                    <div>
                                        <h3> المجموع الفرعي: </h3>
                                        <p> إجمالي سعر المنتجات في السلة </p>
                                    </div>
                                    <div>
                                        <h2 class="total"> <?php echo number_format(50, 2); ?> ر.س </h2>
                                    </div>
                                </div>
                                <div class="first">
                                    <div>
                                        <h3> تكلفة الإضافات: </h3>
                                        <p> تكلفة الزراعة + تكلفة التغليف كهدية </p>
                                    </div>
                                    <div>
                                        <h2 class="total"> <?php echo number_format(40, 2); ?> ر.س </h2>
                                    </div>
                                </div>
                                <div class="first">
                                    <div>
                                        <h3> الشحن والتسليم: </h3>
                                        <p> يحدد سعر الشحن حسب الموقع </p>
                                    </div>
                                    <div>
                                        <h2 class="total"><?php echo number_format(30, 2); ?> ر.س </h2>
                                    </div>
                                </div>
                                <div class="first">
                                    <div>
                                        <h3> ضريبة القيمة المضافة VAT: </h3>
                                        <p> القيمة المضافة تساوي 15% من اجمالي الطلب </p>
                                    </div>
                                    <div>
                                        <h2 class="total"> <?php echo number_format(20, 2); ?> ر.س </h2>
                                    </div>
                                </div>
                                <hr>
                                <div class="first">
                                    <div>
                                        <h3> إجمالي المبلغ: </h3>
                                        <p> المبلغ المطلوب دفعه </p>
                                    </div>
                                    <div>
                                        <h2 class="total"> <?php echo number_format(20, 2); ?> ر.س </h2>
                                    </div>
                                </div>
                            </div>
                            <p class="thanks"> شكرا لتسوقكم من <a href="#"> مشتلي </a> </p>
                        </div>
                    </div>
                    <button id="print_Button" onclick="window.print(); return false;" class="global_button btn print-link"> طباعة الفاتورة <i class="fa fa-print"></i> </button>
                </div>
            </div>
        </div>
    </div>


<?php
    include $tem . 'footer.php';
    ob_end_flush();
} else {
    header("Location:../index");
}
?>