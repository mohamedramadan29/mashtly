  <!-- ADD NEW CATEGORY MODAL   -->
  <div class="modal fade" id="edit-Modal_<?php echo $faq['id']; ?>" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title"> تعديل السؤال </h4>
              </div>
              <form action="main.php?dir=products/faqs&page=edit" method="post" enctype="multipart/form-data">
                  <div class="modal-body">
                      <div class="form-group">
                          <input type="hidden" name="faq_id" value="<?php echo $faq['id']; ?>">
                          <input type="hidden" name="product_id" value="<?php echo $faq['product_id']; ?>">
                          <label for="Company-2" class="block"> السؤال </label>
                          <input value="<?php echo  $faq['faq_head']  ?>" required id="Company-2" name="faq_head" type="text" class="form-control required">
                      </div>
                      <div class="form-group">
                          <label for="Company-2" class="block"> الوصف </label>
                          <textarea id="Company-2" name="faq_descriptiion" class="form-control"><?php echo $faq['faq_descriptiion'] ?></textarea>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" name="edit_faq" class="btn btn-primary waves-effect waves-light "> حفظ </button>
                      <button type="button" class="btn btn-default waves-effect " data-dismiss="modal"> رجوع </button>
                  </div>
              </form>
          </div>
      </div>
  </div>
  <?php
    if (isset($_POST['edit_faq'])) {
        $faq_head = $_POST['faq_head'];
        $faq_descriptiion = $_POST['faq_descriptiion'];
        $faq_id = $_POST['faq_id'];
        $product_id = $_POST['product_id'];
        $formerror = [];
        if (empty($faq_head) || empty($faq_descriptiion)) {
            $formerror[] = 'من فضلك ادخل عنوان ووصف السؤال بشكل صحيح ';
        }
        if (empty($formerror)) {
            $stmt = $connect->prepare("UPDATE product_faqs SET faq_head=?,faq_descriptiion=? WHERE id=?");
            $stmt->execute(array(
                $faq_head,
                $faq_descriptiion,
                $faq_id,
            ));
            if ($stmt) {
                $_SESSION['success_message'] = " تمت التعديل  بنجاح  ";
                header('Location:main?dir=products/faqs&page=report&pro_id=' . $product_id);
            }
        } else {
            $_SESSION['error_messages'] = $formerror;
            header('Location:main?dir=products/faqs&page=report&pro_id=' . $product_id);

            exit();
        }
    }
