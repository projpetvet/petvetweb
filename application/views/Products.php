
<div class="col-xs-10">
    <div class="container">
        <div class="main-container col-xs-12">
            <div class="btnAdd">
                <a href="/admin/addNewProduct">
                    <button class="btn btn-default">Add new product</button>
                </a>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr class="tb-header">
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Preview</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $products_list; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>