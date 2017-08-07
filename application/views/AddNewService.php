
<div class="col-xs-10">
    <div class="container">
        <div class="main-container col-xs-12">
            <div class="addNewHeaderText">Add New Service</div>
            <div class="col-sm-12 ">
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
            </div>
            <?php echo form_open_multipart('admin/saveService'); ?>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="serviceName" id="serviceName" placeholder="Service Name" required/>
            </div>
            <div class="col-sm-12">
                <br/>
                Service Description:
                <textarea name="serviceDescription" id="textareatinymce"></textarea>
            </div>
            <div class="col-sm-6">
                <br/>
                <input type="number" class="form-control" name="servicePrice" id="servicePrice" placeholder="Service Price" required/>
                <br/>
            </div>
            <div class="col-sm-12" id="uploadDiv">
                <input id="file" name="userfile" type="file" required/>
            </div>
            <div class="col-sm-6">
                <br/>
                <input type="hidden" name="filename" id="filename"/> <!-- This is the filename -->
                <input id="btnAddService" type="submit" class="btn btn-success" value="Add service"/>
            </div>
            </form>
        </div>
    </div>
</div>