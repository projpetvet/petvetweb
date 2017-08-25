
<div class="col-xs-10">
    <div class="container">
        <div class="main-container col-xs-12">
            <div class="addNewHeaderText">Edit Breed</div>
            <div class="col-sm-12 ">
                <div id="saveStatus">
                    <!-- Error messages -->
                </div>
            </div>
            <form id="frmEditBreed">
                <div class="col-xs-12 no-gutter">
                    <div class="col-sm-6">
                        Breed Name:
                        <input type="text" id="breedName" class="form-control" value="<?php echo $name; ?>" required/>
                    </div>
                </div>
                <div class="col-xs-12 no-gutter">
                    <div class="col-sm-6">
                        Specie:
                        <select id="specie" class="form-control" required>
                            <?php echo $specie_list; ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <input type="hidden" id="edit_id" value="<?php echo $id; ?>">
                    <button type="submit" class="btn btn-success btn-space">Update Breed</button>
                </div>
            </form>
        </div>
    </div>
</div>