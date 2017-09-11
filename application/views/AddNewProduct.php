
<div class="col-xs-10">
    <div class="container">
        <div class="main-container col-xs-12">
            <div class="addNewHeaderText">Add New Product </div>
            <div class="col-sm-12 ">
                <?php
                if (isset($error)) {
                    echo $error;
                }
                ?>
            </div>
            <?php echo form_open_multipart('admin/saveProduct'); ?>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="productName" id="productName" placeholder="Product Name" required/>
            </div>
            <div class="col-sm-6">
                <select class="form-control" name="product_category" id="product_category" required>
                    <?php echo $product_category_list; ?>
                </select>
            </div>
            <div class="col-sm-12">
                <br/>
                Product Description:
                <textarea name="productDescription" id="textareatinymce"></textarea>
            </div>
            <div class="col-sm-6">
                <br/>
                <input type="number" class="form-control" name="productPrice" id="productPrice" placeholder="Product Price" required/>
                <br/>
            </div>
            <div class="col-sm-6">
                <br/>
                <input type="number" class="form-control" name="productStock" id="productStock" placeholder="Product Stocks" required/>
                <br/>
            </div>
            <div class="col-sm-12" id="uploadDiv">
                <label>Product Image:</label>
                <input id="file" name="userfile" type="file" required/>
            </div>
            <div class="col-sm-6">
                <br/>
                <input type="hidden" name="filename" id="filename"/> <!-- This is the filename -->
                <input type="submit" class="btn btn-success" value="Add product"/>
            </div>
            </form>
        </div>
    </div>
</div>