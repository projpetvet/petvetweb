
<div class="col-xs-10">
    <div class="container">
        <div class="main-container col-xs-12">
            <div class="addNewHeaderText">Add New Breed</div>
            <div class="col-sm-12 ">
                <div id="saveStatus">
                    <!-- Error messages -->
                </div>
            </div>
            <form id="frmBreed">
                <div class="col-xs-12 no-gutter">
                    <div class="col-sm-6">
                        Breed Name:
                        <input type="text" id="breedName" class="form-control" required/>
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
                    <button type="submit" class="btn btn-success btn-space">Add Breed</button>
                </div>
            </form>
        </div>
    </div>
</div>