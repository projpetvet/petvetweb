
<div class="col-xs-10">
    <div class="container">
        <div class="main-container col-xs-12">
            <div class="addNewHeaderText">Edit Service Category </div>
            <div class="col-sm-12 ">
                <?php
                    echo $message;
                ?>
            </div>
            <form action="/admin/updateServiceCategory" method="post">
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" id="name" placeholder="Service Category Name" value="<?php echo $name; ?>"required/>
                </div>
                <div class="col-sm-12">
                    <br/>
                    Description:
                    <textarea name="description" id="textareatinymce"><?php echo html_entity_decode($description); ?></textarea>
                </div>
                <div class="col-sm-6">
                    <br/>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" class="btn btn-success" value="Update service category"/>
                </div>
            </form>
        </div>
    </div>
</div>