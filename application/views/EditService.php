
<div class="col-xs-10">
    <div class="container">
        <div class="main-container col-xs-12">
            <div class="addNewHeaderText">Edit Service Details</div>
            <div class="col-sm-12 ">
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
            </div>
            <?php echo form_open_multipart('admin/updateService'); ?>
            <div class="col-sm-6">
                <input type="hidden" name="serviceid" id="serviceid">
                <input type="text" class="form-control" name="editServiceName" id="editServiceName" placeholder="Service Name" required/>
            </div>
            <div class="col-sm-6">
                <select class="form-control" name="service_category" id="service_category" required>
                    <?php echo $service_category_list; ?>
                </select>
            </div>
            <div class="col-sm-12">
                <br/>
                Service Description:
                <textarea name="editServiceDescription" id="textareatinymce"></textarea>
            </div>
            <div class="col-sm-6">
                <br/>
                <input type="number" class="form-control" name="editServicePrice" id="editServicePrice" placeholder="Service Price" required/>
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
                <input id="btnUpdateService" type="submit" class="btn btn-success" value="Update service"/>
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
            url: "/admin/getEditServiceDetails",
            type: "POST",
            data: {lastSegment: lastSegment},
            dataType: "json",
            success: function (data)
            {
                $('#editServiceName').val(data[0]['id']);
                $('#editServiceName').val(data[0]['name']);
                setTimeout(function () {
                    tinyMCE.activeEditor.setContent(data['decoded']);
                }, 1000);
                $('#editServicePrice').val(data[0]['price']);
                $('#service_category').val(data[0]['service_category']);
                $('#currentImage').html("<img src='" + window.location.origin + "/www/images/services/" + data[0]['image'] + "' style='width:300px'>");
            }
        });
    });
</script>