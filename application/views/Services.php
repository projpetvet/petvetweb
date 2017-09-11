
<div class="col-xs-10">
    <div class="container">
        <div class="main-container col-xs-12">
            <h1 class="left-header">Services</h1>
            <div class="pull-right">
                <div class="btnAdd">
                    <a href="/admin/addNewService">
                        <button class="btn btn-default">Add new service</button>
                    </a>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr class="tb-header">
                        <th>Name</th>
                        <th>Price</th>
                        <th>Preview</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $services_list; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>