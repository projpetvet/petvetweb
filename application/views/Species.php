<div class="col-xs-10">
    <div class="container">
        <div class="main-container col-xs-12">
            <h1 class="left-header">Species</h1>
            <div class="btnAdd pull-right">
                <a href="/admin/addSpecie">
                    <button class="btn btn-default">Add Specie</button>
                </a>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr class="tb-header">
                        <th>ID</th>
                        <th>Specie</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $list; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>