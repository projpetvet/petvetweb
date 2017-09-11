
<div class="col-xs-10">
    <div class="container">
        <div class="main-container col-xs-12">
            <div class="addNewHeaderText">Add New Pet</div>
            <div class="col-sm-12 ">
                <div id="saveStatus">
                    <!-- Error messages -->
                </div>
            </div>
            <div class="col-sm-6">
                Owner:
                <select class="form-control" id="optOwnerName">
                    <?php echo $owners_list; ?>
                </select>
            </div>
            <div class="col-sm-6">
                Name:
                <input type="text" id="petName" class="form-control"/>
            </div>
            <div class="col-sm-6">
                <br/>
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
                    <option>Male</option>
                    <option>Female</option>
                </select>
            </div>
            <div class="col-sm-6">
                <br/>
                Color:
                <input type="text" class="form-control" id="petColor" name="petColor">
            </div>
            <div class="col-sm-6">
                <br/>
                Birthday:
                <input type="date" class="form-control" id="petBirthday" name="petBirthday">
            </div>
            <div class="col-sm-12">
                <br/>
                <button id="btnAddNewPet" class="btn btn-success">Add pet</button>
            </div>
        </div>
    </div>
</div>