
<div class="col-xs-10">
    <div class="container">
        <div class="main-container col-xs-12">
            <div class="btnAdd">
                <a href="/admin/addNewDoctor">
                    <button class="btn btn-default">Add new doctor</button>
                </a>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr class="tb-header">
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Mobile Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $doctors_list; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="myModalEditDoctor" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Doctor Details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 ">
                        <div id="editStatus">
                            <!-- Error messages -->
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <input type="hidden" id="doctorId" />
                        First Name:
                        <input type="text" class="form-control" id="editFirstName" placeholder="First Name" />
                    </div>
                    <div class="col-sm-6">
                        Last Name:
                        <input type="text" class="form-control" id="editLastName" placeholder="Last Name" />
                    </div>
                    <div class="col-sm-6">
                        <br/>
                        Mobile Number:
                        <input type="number" class="form-control" id="editMobileNumber" placeholder="Mobile Number" />
                    </div>
                    <div class="col-sm-12">
                        <br/>
                        Set New Schedule:
                        <div class="checkbox">
                            <label><input class="dayOption" type="checkbox" id="editsunday">Sunday</label>
                        </div>
                        <div class="checkbox">
                            <label><input class="dayOption" type="checkbox" id="editmonday">Monday</label>
                        </div>
                        <div class="checkbox">
                            <label><input class="dayOption" type="checkbox" id="edittuesday">Tuesday</label>
                        </div>
                        <div class="checkbox">
                            <label><input class="dayOption" type="checkbox" id="editwednesday">Wednesday</label>
                        </div>
                        <div class="checkbox">
                            <label><input class="dayOption" type="checkbox" id="editthursday">Thursday</label>
                        </div>
                        <div class="checkbox">
                            <label><input class="dayOption" type="checkbox" id="editfriday">Friday</label>
                        </div>
                        <div class="checkbox">
                            <label><input class="dayOption" type="checkbox" id="editsaturday">Saturday</label>
                        </div>
                        <br/>
                    </div>
                    <div class="col-sm-6">
                        Time in:
                        <input type="time" id="editTimeIn" class="form-control" />
                    </div>
                    <div class="col-sm-6">
                        Time out:
                        <input type="time" id="editTimeOut" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btnUpdateDoctor">Update Details</button>
                <button type="button" id="btnCloseEditDoctor" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>