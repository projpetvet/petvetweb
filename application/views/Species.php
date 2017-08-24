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
<div class="modal fade" id="editSpecieModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Specie</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <input type="text" class="form-control" id="edit_specie_name" value="">
                        <input type="hidden" class="form-control" id="edit_specie_id" value="">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btnUpdateSpecie">Update</button>
                <button type="button" id="btnCloseEditDoctor" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>