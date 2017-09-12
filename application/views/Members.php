
<div class="col-xs-10">
    <div class="container">
        <div class="main-container col-xs-12">
            <h1 class="left-header">Members</h1>
            <div class="pull-right">
                <div class="btnAdd">
                    <a href="/admin/addNewMember">
                        <button class="btn btn-default">Add new member</button>
                    </a>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr class="tb-header">
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Mobile Number</th>
                        <th class="txt-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $members_list; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="myModalEditMembers" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Member Details</h4>
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
                        First Name:
                        <input type="text" class="form-control" id="editFirstName" placeholder="First Name" />
                    </div>
                    <div class="col-sm-6">
                        Last Name:
                        <input type="text" class="form-control" id="editLastName" placeholder="Last Name" />
                    </div>
                    <div class="col-sm-12">
                        <br/>
                        Address:
                        <textarea class="form-control" id="editAddress" placeholder="Address"></textarea>
                    </div>
                    <div class="col-sm-6">
                        <br/>
                        Mobile Number:
                        <input type="number" class="form-control" id="editMobileNumber" placeholder="Mobile Number" />
                    </div>
                    <div class="col-sm-6">
                        <br/>
                        Email Address:
                        <input type="email" class="form-control" id="editEmailAddress" placeholder="Email Address" />
                    </div>
                    <div class="col-sm-6">
                        <br/>
                        Username:
                        <input type="text" class="form-control" id="editUsername" placeholder="Username" />
                    </div>
                    <div class="col-sm-6">
                        <br/>
                        Password:<i>Please leave blank if you want to retain old password</i>
                        <input type="password" class="form-control" id="editPassword" placeholder="Password" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btnUpdateMember">Update Details</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModalViewMembers" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Member Details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        Full Name:
                        <div id="fullName">Hello</div>
                    </div>
                    <div class="col-sm-6">
                        Address:
                        <div id="address">Hello</div>
                    </div>
                    <div class="col-sm-6">
                        <br/>
                        Mobile Number:
                        <div id="mobile">Hello</div>
                    </div>
                    <div class="col-sm-6">
                        <br/>
                        Email Address:
                        <div id="email">Hello</div>
                    </div>
                    <div class="col-sm-6">
                        <br/>
                        Pets:
                        <div id="petsList">Hello</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>