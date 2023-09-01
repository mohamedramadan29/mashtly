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
                                        <div class="form-group d-flex align-items-center">
                                            <div>
                                            <img src="" width="30px" height="30px" alt="">
                                            </div>
                                            <div>
                                            <label style='display:block'> صورة المنتج  </label>
                                            <input type='file' class='form-control' name='vartions_image[]'>
                                            <input placeholder="اسم الصورة" name='var_image_name[]'  class="form-control" type="text">
                                            <input placeholder="الاسم البديل" name='var_image_alt[]'  class="form-control" type="text">
                                            <input placeholder="وصف مختصر" name='var_image_desc[]'  class="form-control" type="text">
                                            <input placeholder="كلمات مفتاحية للصورة" name='var_image_keys[]'  class="form-control" type="text">
                                            </div>
                                            
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