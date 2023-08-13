  <!-- ADD NEW CATEGORY MODAL   -->
  <div class="modal fade" id="add-faqs" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title"> اضافة سؤال جديد </h4>
              </div>
              <form action="main.php?dir=products/faqs&page=add" method="post" enctype="multipart/form-data">
                  <div class="modal-body">
                      <div id="attributes-container">
                          <div class="form-group">
                              <input type="hidden" name="pro_id" value="<?php echo $product_id ?>">
                              <label for="Company-2" class="block"> السؤال </label>
                              <input required id="Company-2" name="faq_head" type="text" class="form-control required">
                          </div>
                          <div class="form-group">
                              <label for="Company-2" class="block "> الوصف </label>
                              <textarea id="Company-2" name="faq_descriptiion" class="summernote form-control"></textarea>
                          </div>
                      </div>
                  </div>


                  <div class="modal-footer">
                      <button type="submit" name="add_faq" class="btn btn-primary waves-effect waves-light "> حفظ </button>
                      <button type="button" class="btn btn-default waves-effect " data-dismiss="modal"> رجوع </button>
                  </div>
              </form>
          </div>
      </div>
  </div>


  <?php
    if (isset($_POST['add_faq'])) {
        $faq_head = $_POST['faq_head'];
        $faq_descriptiion = $_POST['faq_descriptiion'];
        $product_id = $_POST['pro_id'];
        $formerror = [];
        if (empty($faq_head) || empty($faq_descriptiion)) {
            $formerror[] = 'من فضلك ادخل عنوان ووصف السؤال بشكل صحيح ';
        }
        if (empty($formerror)) {
            $stmt = $connect->prepare("INSERT INTO product_faqs (faq_head , faq_descriptiion, product_id)
        VALUES (:zfaq_head,:zfaq_desc,:zpro_id)");
            $stmt->execute(array(
                "zfaq_head" => $faq_head,
                "zfaq_desc" => $faq_descriptiion,
                "zpro_id" => $product_id,
            ));
            if ($stmt) {
                $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
                header('Location:main?dir=products/faqs&page=report&pro_id=' . $product_id);
            }
        } else {
            $_SESSION['error_messages'] = $formerror;
            header('Location:main?dir=products/faqs&page=report');
            exit();
        }
    }
