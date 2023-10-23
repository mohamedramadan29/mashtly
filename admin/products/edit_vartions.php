<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <p class="btn btn-primary btn-sm" id="var_product"> منتج متغير </p>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
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
                    <p class="btn btn-success btn-sm verify_variations2" id="verify_variations"> تاكيد المتغيرات الجديدة </p>

                    <script>
                        jQuery(document).ready(function($) {
                            $(document).on('click', '#verify_variations', function() {
                                var selectedGroups = $('.pro-attribute');
                                var productVariantsHTML = ''; // يحتوي على المتغيرات المنتج في شكل HTML
                                // قم بتخزين القيم المختارة من كل مجموعة في مصفوفة
                                var selectedValuesPerGroup = [];
                                if (selectedGroups.length > 0) {
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
                                            <div class="form-group" style="width:80%">
                                            <label> الأسم  </label>
                                                <input name='vartions_name[]' readonly class="form-control" type="text" value="${variantText.slice(0, -3)}">
                                            </div>
                                            <div class="form-group">
                                            <label> سعر المنتج  </label>
                                                <input placeholder="السعر" class="form-control" type="text" name='vartions_price[]'>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                `;
                                        // إضافة النص HTML إلى المتغير productVariantsHTML
                                        productVariantsHTML += variationInputsHTML;
                                    }
                                    // عرض المتغيرات المنتج في العنصر المحدد
                                    $('#product-variants2').html(productVariantsHTML);
                                } else {
                                    alert("من فضلك اختر المتغيرات ");
                                }
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
                    <div id="product-variants2"></div>
                    <button name="save_vartion" class="btn btn-warning btn-sm " id="save_vartion" style="display: none;"> حفظ المتغيرات الجديدة للمنتج </button>
                </form>
                <div id="product-variants">
                    <?php
                    $stmt = $connect->prepare("SELECT * FROM product_details2 WHERE product_id = ?");
                    $stmt->execute(array($pro_id));
                    $proudct_attributes = $stmt->fetchAll();
                    ?>

                    <div class="vartions_inputs">
                        <?php
                        foreach ($proudct_attributes as $pro_attribut) {
                        ?>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="d-flex justify-content-between">
                                    <div class="form-group d-flex align-items-center">
                                        <div>
                                            <input type="hidden" name="vartion_id" value="<?php echo $pro_attribut['id']; ?>">
                                            <img src="product_images/<?php echo $pro_attribut['image']; ?>" width="60px" height="60px" alt="">
                                        </div>
                                        <div>
                                            <label style='display:block'> صورة المنتج </label>
                                            <input value="<?php echo $pro_attribut['image'];  ?>" type='file' class='form-control' name='vartion_image'>
                                            <input placeholder="اسم الصورة" name='var_image_name' class="form-control" type="text" value="<?php echo $pro_attribut['image_name'] ?>">
                                            <input placeholder="الاسم البديل" name='var_image_alt' class="form-control" type="text" value="<?php echo $pro_attribut['image_alt'] ?>">
                                            <input placeholder="وصف مختصر" name='var_image_desc' class="form-control" type="text" value="<?php echo $pro_attribut['image_desc'] ?>">
                                            <input placeholder="كلمات مفتاحية للصورة" name='var_image_keys' class="form-control" type="text" value="<?php echo $pro_attribut['image_keys'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group" style="width:80%">
                                        <label> الأسم </label>
                                        <input name='vartions_name' readonly class="form-control" type="text" value="<?php echo $pro_attribut['vartions_name'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label> سعر المنتج </label>
                                        <input placeholder="السعر" class="form-control" type="text" name='vartions_price' value="<?php echo $pro_attribut['price'] ?>">
                                    </div>
                                    <div class="form-group d-flex justify-content-between align-items-center" style="margin-top: 30px;">
                                        <button type="submit" name="edit_vartion" class="btn btn-success btn-sm"> <i class="fa fa-pen"></i> </button>
                                        <button name="delete_vartion" type="submit" class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i> </button>
                                    </div>
                                </div>
                            </form>
                            <hr>
                        <?php
                        }
                        ?>
                    </div>

                </div>
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

<?php
if (isset($_POST['save_vartion'])) {
    $stmt = $connect->prepare("DELETE FROM product_details2 WHERE product_id = ?");
    $stmt->execute(array($pro_id));
    $vartions_name = $_POST['vartions_name'];
    $vartions_price = $_POST['vartions_price'];
    $var_image_names = $_POST['var_image_name'];
    $var_image_alts = $_POST['var_image_alt'];
    $var_image_descs = $_POST['var_image_desc'];
    $var_image_keyss = $_POST['var_image_keys'];
    ////////////////////////////////
    if ($vartions_name > 0) {
        for ($i = 0; $i < count($vartions_name); $i++) {
            $vartion_name =   $vartions_name[$i];
            $vartion_price =  $vartions_price[$i];
            $var_image_name = $var_image_names[$i];
            $var_image_alt = $var_image_alts[$i];
            $var_image_desc = $var_image_descs[$i];
            $var_image_keys = $var_image_keyss[$i];
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
            $stmt = $connect->prepare("INSERT INTO product_details2 (product_id,vartions_name,price,image,image_name,image_alt,image_desc,image_keys) VALUES 
            (:zpro_id,:zvartion_name,:zprice,:zimage,:zimage_name,:zimage_alt,:zimage_desc,:zimage_keys)");
            $stmt->execute(array(
                "zpro_id" => $pro_id,
                "zvartion_name" => $vartion_name,
                "zprice" => $vartion_price,
                "zimage" => $main_image_uploaded,
                "zimage_name" => $var_image_name,
                "zimage_alt" => $var_image_alt,
                "zimage_desc" => $var_image_desc,
                "zimage_keys" => $var_image_keys,
            ));
        }
        if ($stmt) {
            header('Location:main?dir=products&page=edit&pro_id=' . $pro_id);
        }
    }
}
// START Delete Vartion
if (isset($_POST['delete_vartion'])) {
    $vartion_id = $_POST['vartion_id'];
    $stmt = $connect->prepare("DELETE FROM product_details2 WHERE id = ?");
    $stmt->execute(array($vartion_id));
    if ($stmt) {
        header('Location:main?dir=products&page=edit&pro_id=' . $pro_id);
    }
}

if (isset($_POST['edit_vartion'])) {
    $vartion_id = $_POST['vartion_id'];
    $vartions_price = $_POST['vartions_price'];
    $var_image_name = $_POST['var_image_name'];
    $var_image_alt = $_POST['var_image_alt'];
    $var_image_desc = $_POST['var_image_desc'];
    $var_image_keys = $_POST['var_image_keys'];

    if (!empty($_FILES['vartion_image']['name'])) {
        $vartion_image_name = $_FILES['vartion_image']['name'];
        $vartion_image_name = str_replace(' ', '-', $vartion_image_name);
        $vartion_image_temp = $_FILES['vartion_image']['tmp_name'];
        $vartion_image_type = $_FILES['vartion_image']['type'];
        $vartion_image_size = $_FILES['vartion_image']['size'];
        // حصل على امتداد الصورة من اسم الملف المرفوع
        $image_extension = pathinfo($vartion_image_name, PATHINFO_EXTENSION);
        if (!empty($image_name)) {
            $image_name = str_replace(' ', '-', $image_name);
            $vartion_image_uploaded = $image_name . '.' . $image_extension;
            move_uploaded_file(
                $main_image_temp,
                'product_images/' . $vartion_image_uploaded
            );
        } else {
            $vartion_image_uploaded = $vartion_image_name;
            move_uploaded_file(
                $vartion_image_temp,
                'product_images/' . $vartion_image_uploaded
            );
        }
    }
    $stmt = $connect->prepare("UPDATE product_details2 SET price= ?,image_name=?,image_alt=?,image_desc=?,image_keys=? WHERE id = ? ");
    $stmt->execute(array($vartions_price, $var_image_name, $var_image_alt, $var_image_desc, $var_image_keys, $vartion_id));
    if (!empty($_FILES['vartion_image']['name'])) {
        $stmt = $connect->prepare("UPDATE product_details2 SET  image= ? WHERE id = ? ");
        $stmt->execute(array($vartion_image_uploaded, $vartion_id));
    }
    if ($stmt) {
        header('Location:main?dir=products&page=edit&pro_id=' . $pro_id);
    }
}
?>