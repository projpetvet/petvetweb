
<div class="col-xs-10">
    <div class="container">
        <div class="main-container col-xs-12">
            <h1 class="left-header">Admin Users</h1>
            <div class="pull-right">
                <div class="btnAdd">
                    <a href="/admin/addNewUser">
                        <button class="btn btn-default">Add new user</button>
                    </a>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr class="tb-header">
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $users_list; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function DeleteAdminUser(id,element)
{
    var response = confirm("Are you sure you want to delete this user?");
    if(response)
    {
        $.ajax({
            url : "/admin/DeleteUser",
            method : "POST",
            data : {
                id : id
            },
            dataType : "json",
            success : function(data)
            {
                if(data.success)
                {
                    alert("User successfully deleted.");
                    $(element).parents('tr').remove();
                }
                else
                {
                    alert("Error connecting to server.");
                }
            },
            error : function()
            {
                alert("Error connecting to server.");
            }
        });
    }
}
</script>