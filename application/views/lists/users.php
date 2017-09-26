<tr>
	<td><?php echo $id; ?></td>
	<td><?php echo $username; ?></td>
	<td><?php echo $type_caption; ?></td>
        <td><a href="/admin/EditUser/<?php echo $id; ?>">Edit</a> | <a href="#" onclick="DeleteAdminUser(<?php echo $id; ?>,this)">Delete</a></td>
</tr>