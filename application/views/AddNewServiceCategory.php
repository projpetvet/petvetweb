
<div class="col-xs-10">
    <div class="container">
        <div class="main-container col-xs-12">
            <div class="addNewHeaderText">Add New Service Category </div>
            <div class="col-sm-12 ">
                <?php
                    echo $message;
                ?>
            </div>
            <form action="/admin/saveServiceCategory" method="post">
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" id="name" placeholder="Service Category Name" required/>
                </div>
                <div class="col-sm-12">
                    <br/>
                    Description:
                    <textarea name="description" id="textareatinymce"></textarea>
                </div>
                <div class="col-sm-6">
                    <br/>
                    <input type="submit" class="btn btn-success" value="Add service category"/>
                </div>
            </form>
        </div>
    </div>
</div>