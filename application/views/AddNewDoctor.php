<div class="col-xs-10">
    <div class="container">
        <div class="main-container col-xs-12">
            <div class="addNewHeaderText">Add New Doctor </div>
            <div class="col-sm-12 ">
                <div id="saveStatus">
                    <!-- Error messages -->
                </div>
            </div>
            <form id="addDoctorForm" action="/admin/addNewDoctorDetails" method="post" enctype="multipart/form-data">
                <input type="hidden" id="form_data_values" name="form_data_values">
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="firstName" placeholder="First Name" required/>
                </div>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="lastName" placeholder="Last Name" required/>
                </div>
                <div class="col-sm-6">
                    <br/>
                    <input type="number" class="form-control" id="mobileNumber" placeholder="Mobile Number" required/>
                </div>
                <div class="col-sm-6">
                    Image:<br/>
                    <input id="file" name="userfile" class="form-control" type="file" required/>
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
                    <input type="time" id="timeIn" class="form-control" required/>
                </div>
                <div class="col-sm-6">
                    Time out:
                    <input type="time" id="timeOut" class="form-control" required/>
                </div>
                <div class="col-sm-6">
                    <br/>
                    <button id="btnSaveDoctor" class="btn btn-success">Save doctor details</button>
                </div>
            </form>
        </div>
    </div>
</div>