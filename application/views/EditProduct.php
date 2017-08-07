
<div class="col-xs-10">
    <div class="container">
        <div class="main-container col-xs-12">
            <div class="addNewHeaderText">Edit Product Details </div>
            <div class="col-sm-12 ">
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
            </div>
            <?php echo form_open_multipart('admin/updateProduct'); ?>
            <div class="col-sm-6">
                <input type="hidden" name="productid" id="productid">
                <input type="text" class="form-control" name="editProductName" id="editProductName" placeholder="Product Name" required/>
            </div>
            <div class="col-sm-12">
                <br/>
                Product Description:
                <textarea name="editProductDescription" id="textareatinymce"></textarea>
            </div>
            <div class="col-sm-6">
                <br/>
                <input type="number" class="form-control" name="editProductPrice" id="editProductPrice" placeholder="Product Price" required/>
                <br/>
            </div>
            <div class="col-sm-12">
                Current Image:
                <div id="currentImage"></div>
            </div>
            <div class="col-sm-12" id="uploadDiv">
                <input id="file" name="userfile" type="file"/>
            </div>
            <div class="col-sm-6">
                <br/>
                <input type="hidden" name="filename" id="filename"/> <!-- This is the filename -->
                <input type="hidden" name="edit_id" id="edit_id" value="<?php echo $edit_id; ?>"/> <!-- This is the filename -->
                <input id="btnUpdateProduct" type="submit" class="btn btn-success" value="Update product"/>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    var parts = window.location.href.split('/');
    var lastSegment = parts.pop() || parts.pop();

    $(document).ready(function () {
        $.ajax({
            url: "/admin/getEditProductDetails",
            type: "POST",
            data: {lastSegment: lastSegment},
            dataType: "json",
            success: function (data)
            {
                $('#editProductName').val(data[0]['id']);
                $('#editProductName').val(data[0]['name']);
                setTimeout(function () {
                    tinyMCE.activeEditor.setContent(data['decoded']);
                }, 1000);
                $('#editProductPrice').val(data[0]['price']);
                $('#currentImage').html("<img src='" + window.location.origin + "/www/images/products/" + data[0]['image'] + "' style='width:300px'>");
            }
        });
    });
</script>