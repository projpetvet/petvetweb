<div class="col-xs-10">
    <div class="container">
        <div class="main-container col-xs-12">
            <div class="addNewHeaderText">Add New Doctor </div>
            <div class="col-sm-12 ">
                <div id="saveStatus">
                    <!-- Error messages -->
                </div>
            </div>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="firstName" placeholder="First Name" />
            </div>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="lastName" placeholder="Last Name" />
            </div>
            <div class="col-sm-6">
                <br/>
                <input type="number" class="form-control" id="mobileNumber" placeholder="Mobile Number" />
            </div>
            <div class="col-sm-12">
                <br/>
                Set Schedule:
                <div class="checkbox">
                    <label><input class="dayOption" type="checkbox" id="sunday">Sunday</label>
                </div>
                <div class="checkbox">
                    <label><input class="dayOption" type="checkbox" id="monday">Monday</label>
                </div>
                <div class="checkbox">
                    <label><input class="dayOption" type="checkbox" id="tuesday">Tuesday</label>
                </div>
                <div class="checkbox">
                    <label><input class="dayOption" type="checkbox" id="wednesday">Wednesday</label>
                </div>
                <div class="checkbox">
                    <label><input class="dayOption" type="checkbox" id="thursday">Thursday</label>
                </div>
                <div class="checkbox">
                    <label><input class="dayOption" type="checkbox" id="friday">Friday</label>
                </div>
                <div class="checkbox">
                    <label><input class="dayOption" type="checkbox" id="saturday">Saturday</label>
                </div>
                <br/>
            </div>
            <div class="col-sm-6">
                Time in:
                <input type="time" id="timeIn" class="form-control" />
            </div>
            <div class="col-sm-6">
                Time out:
                <input type="time" id="timeOut" class="form-control" />
            </div>
            <div class="col-sm-6">
                <br/>
                <button id="btnSaveDoctor" class="btn btn-success">Save doctor details</button>
            </div>
        </div>
    </div>
</div>