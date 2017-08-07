
<div class="col-xs-10">
    <div class="container">
        <div class="main-container col-xs-12">
            <div class="btnAdd">
                <a href="/admin/addNewPet">
                    <button class="btn btn-default">Add new pet</button>
                </a>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr class="tb-header">
                        <th>Name</th>
                        <th>Owner</th>
                        <th>Specie</th>
                        <th>Breed</th>
                        <th>Gender</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $pets_list; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="myModalEditPets" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Pet Details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 ">
                        <div id="editStatus">
                            <!-- Error messages -->
                        </div>
                    </div>
                    <input type="hidden" id="editid" />
                    <div class="col-sm-6">
                        Name:
                        <input type="text" id="petName" class="form-control"/>
                    </div>
                    <div class="col-sm-6">
                        Specie:
                        <select class="form-control" id="optSpecie">
                            <option disabled selected>Choose here...</option>
                            <?php echo $species_list; ?>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <br/>
                        Breed:
                        <select class="form-control" id="optBreed">
                            <option>none</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <br/>
                        Gender:
                        <select class="form-control" id="petGender">
                            <option value="1">Male</option>
                            <option value="2">Female</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btnUpdatePet">Update Details</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>