<?php

if (isset($_POST['add_pro'])) {

    $formerror = [];
    $vartions_name = $_POST['vartions_name'];

    $vartions_price = $_POST['vartions_price'];

    if (empty($formerror)) {
        // get the last product
        $stmt = $connect->prepare("SELECT * FROM products ORDER BY id DESC LIMIT 1");
        $stmt->execute();
        $last_product = $stmt->fetch();
        $last_pro_id = $last_product['id'];

        ////////////////////////////////
        if ($vartions_name > 0) {
            for ($i = 0; $i < count($vartions_name); $i++) {
                $vartion_name =   $vartions_name[$i];
                $vartion_price =  $vartions_price[$i];
                //////////// attribute images //////////////
                $image_att_name = $_FILES['vartions_image']['name'][$i];
                $image_att_name = str_replace(' ', '-', $image_att_name);
                $image_att_temp = $_FILES['vartions_image']['tmp_name'][$i];
                $image_att_type = $_FILES['vartions_image']['type'][$i];
                $image_att_size = $_FILES['vartions_image']['size'][$i];
                $image_extension = pathinfo($image_att_name, PATHINFO_EXTENSION);
                $main_image_uploaded = $image_att_name;
                move_uploaded_file(
                    $image_att_temp,
                    'product_images/' . $main_image_uploaded
                );
                $stmt = $connect->prepare("INSERT INTO product_details2 (product_id,vartions_name,price,image) VALUES 
                (:zpro_id,:zvartion_name,:zprice,:zimage)");
                $stmt->execute(array(
                    "zpro_id" => $last_pro_id,
                    "zvartion_name" => $vartion_name,
                    "zprice" => $vartion_price,
                    "zimage" => $main_image_uploaded,
                ));
            }
        }
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            if (isset($_SESSION['success_message'])) {
                $message = $_SESSION['success_message'];
                unset($_SESSION['success_message']);
?>
                <?php
                ?>
                <script src="plugins/jquery/jquery.min.js"></script>
                <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
                <script>
                    $(function() {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: '<?php echo $message; ?>',
                            showConfirmButton: false,
                            timer: 2000
                        })
                    })
                </script>
            <?php
            }
            //header('Location:main?dir=products&page=add');
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        foreach ($formerror as $error) {
            ?>
            <div class="alert alert-danger alert-dismissible" style="max-width: 800px; margin:20px">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $error; ?>
            </div>
<?php
        }
        unset($_SESSION['error_messages']);
    }
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                <p class="btn btn-primary btn-sm" id="var_product"> منتج متغير </p>
                </div>
                
                <div id="attributes-containerxx">
                    <?php
                    $uniqueId = uniqid();
                    ?>
                    <div class="attribute-group">
                        <div class="form-group">
                            <br>
                            <label for="inputStatus">اختر السمة</label>
                            <select class="form-control custom-select   pro-attribute" name="pro_attribute[]" data-new=<?php echo $uniqueId; ?> data-uniqueId="<?php echo $uniqueId; ?>">
                                <option selected disabled>-- اختر --</option>
                                <?php
                                $stmt = $connect->prepare("SELECT * FROM product_attribute");
                                $stmt->execute();
                                $allatt = $stmt->fetchAll();
                                foreach ($allatt as $index => $att) {
                                    $selected = (isset($_REQUEST['pro_attribute']) && in_array($att['id'], $_REQUEST['pro_attribute'])) ? 'selected' : '';
                                    echo '<option value="' . $att['id'] . '" ' . $selected . '>' . $att['name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputStatus">المتغيرات</label>
                            <select class="form-control custom-select   pro-variation" name="pro_variations[]" multiple data-uniqueId="<?php echo $uniqueId; ?>">
                                <option disabled>-- اختر --</option>
                            </select>
                        </div>
                    </div>
                    <p class="btn btn-warning btn-sm" id="add_attribute_btn"> اضافة سمه جديد <i class="fa fa-plus"></i> </p>
                    
                </div>
                <script src="plugins/jquery/jquery.js"></script>
                <script>
                    jQuery(function($) {
                        // استهداف زر "اضافة سمة جديدة"
                        $(document).on('click', '#add_attribute_btn', function() {
                            var uniqueId = Date.now(); // إنشاء معرف فريد جديد
                            var newAttributeItem = `
                                <div class="attribute-group">
                                <div class="form-group">
                                    <br>
                                    <label for="inputStatus">اختر السمة</label>
                                    <select class="form-control custom-select   pro-attribute" name="pro_attribute[]" data-new="${uniqueId}" data-uniqueId="${uniqueId}">
                                    <option selected disabled>-- اختر --</option>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM product_attribute");
                                    $stmt->execute();
                                    $allatt = $stmt->fetchAll();
                                    foreach ($allatt as $index => $att) {
                                        $selected = (isset($_REQUEST['pro_attribute']) && in_array($att['id'], $_REQUEST['pro_attribute'])) ? 'selected' : '';
                                        echo '<option value="' . $att['id'] . '" ' . $selected . '>' . $att['name'] . '</option>';
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputStatus">المتغيرات</label>
                                    <select multiple class="form-control custom-select   pro-variation" name="pro_variations[]" data-uniqueId="${uniqueId}">
                                    <option disabled>-- اختر --</option>
                                    </select>
                                </div>  
                                <button class="btn btn-sm btn-danger delete_attribute_btn"> حذف   <i class='fa fa-trash'></i> </button>
                                </div>
                            `;
                            $('#attributes-container').append(newAttributeItem); // إضافة العنصر الجديد إلى الصفحة
                        });
                        // استهداف زر "حذف العنصر"
                        $(document).on('click', '.delete_attribute_btn', function() {
                            $(this).closest('.attribute-group').remove(); // حذف العنصر
                        });
                    });
                </script>
                <div class="new_attributes" id="attributes-container"></div>
                <p class="btn btn-success btn-sm" id="verify_variations"> تاكيد المتغيرات </p>
                <script>
                    jQuery(document).ready(function($) {
                        $(document).on('click', '#verify_variations', function() {
                            var selectedGroups = $('.pro-attribute');
                            var productVariantsHTML = ''; // يحتوي على المتغيرات المنتج في شكل HTML

                            // قم بتخزين القيم المختارة من كل مجموعة في مصفوفة
                            var selectedValuesPerGroup = [];
                            selectedGroups.each(function() {
                                var groupId = $(this).data('uniqueid');
                                var selectedVariations = $('.pro-variation[data-uniqueid="' + groupId + '"]').val();
                                selectedValuesPerGroup.push(selectedVariations);
                            });
                            // استخدم مفهوم الطرقة البيانية لإنشاء المتغيرات المنتج بشكل ديناميكي
                            var productVariants = cartesianProduct(selectedValuesPerGroup);
                            // تكرار النتائج وإنشاء العناصر HTML بناءً على المتغيرات
                            for (var i = 0; i < productVariants.length; i++) {
                                var variantText = '';
                                for (var j = 0; j < selectedGroups.length; j++) {
                                    var attributeName = selectedGroups.eq(j).find('option:selected').text();
                                    var attributeValue = productVariants[i][j];
                                    var attributeText = $('.pro-variation[data-uniqueid="' + j + '"] option[value="' + attributeValue + '"]').text();
                                    variantText += attributeName + ': ' + attributeText + ' (' + attributeValue + ')' + ' - ';
                                }
                                // إضافة النص HTML إلى المتغير productVariantsHTML
                                var variationInputsHTML = `
                                    <div class="vartions_inputs">
                                        <div class="d-flex justify-content-between">
                                            <div class="form-group">
                                            <label style='display:block'> صورة المنتج  </label>
                                                <img src="" width="30px" height="30px" alt="">
                                                <input type='file' class='form-control' name='vartions_image[]'>
                                            </div> 
                                            <div class="form-group">
                                            <label> الأسم  </label>
                                                <input name='vartions_name[]' readonly class="form-control" type="text" value="${variantText.slice(0, -3)}">
                                            </div>
                                            <div class="form-group">
                                            <label> سعر المنتج  </label>
                                                <input placeholder="السعر" class="form-control" type="text" name='vartions_price[]'>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                // إضافة النص HTML إلى المتغير productVariantsHTML
                                productVariantsHTML += variationInputsHTML;
                            }

                            // عرض المتغيرات المنتج في العنصر المحدد
                            $('#product-variants').html(productVariantsHTML);
                        });

                        // دالة لحساب الطرقة البيانية
                        function cartesianProduct(arrays) {
                            return arrays.reduce(function(a, b) {
                                var result = [];
                                a.forEach(function(a) {
                                    b.forEach(function(b) {
                                        result.push(a.concat([b]));
                                    });
                                });
                                return result;
                            }, [
                                []
                            ]);
                        }
                    });
                </script>
                <div id="product-variants"></div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
<style>
    #attributes-containerxx {
        display: none;
    }
</style>