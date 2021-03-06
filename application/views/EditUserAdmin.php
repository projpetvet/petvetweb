
<div class="col-xs-10">
    <div class="container">
        <div class="main-container col-xs-12">
            <div class="addNewHeaderText">Edit User Admin</div>
            <div class="col-sm-12 ">
                <div id="saveStatus">
                    <!-- Error messages -->
                </div>
            </div>
            <form id="edituserform">
                <input type="hidden" id="edit_id" value="<?php echo $id; ?>">
            <div class="col-sm-6">
                <input type="text" id="userName" class="form-control" value="<?php echo $username; ?>" placeholder="Username" required/>
            </div>
            <div class="col-sm-6">
                <select id="userType" class="form-control">
                    <?php
                        switch($type)
                        {
                            case "1":
                                echo '<option value="2">Admin</option>
                                        <option value="1" selected>Super Admin</option>';
                                break;
                            case "2":
                                echo '<option value="2" selected>Admin</option>
                                        <option value="1">Super Admin</option>';
                                break;
                        }
                    ?>
                </select>
            </div>
            <div class="col-sm-6">
                <br/>
                <input type="password" id="password" class="form-control" placeholder="Password" required/>
            </div>
            <div class="col-sm-6">
                <br/>
                <input type="password" id="confirmPassword" class="form-control" placeholder="Confirm Password" required/>
            </div>
            <div class="col-sm-6">
                <br/>
                <button type="submit" class="btn btn-success">Update user admin</button>
            </div>
            </form>
        </div>
    </div>
</div>