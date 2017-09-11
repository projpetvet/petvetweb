
<div class="col-xs-10">
    <div class="container">
        <div class="main-container col-xs-12">
            <h1 class="left-header">Service Categories</h1>
            <div class="pull-right">
                <div class="btnAdd">
                    <a href="/admin/addNewServiceCategory">
                        <button class="btn btn-default">Add new service category</button>
                    </a>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr class="tb-header">
                        <th>ID</th>
                        <th>Category Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $category_list; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>