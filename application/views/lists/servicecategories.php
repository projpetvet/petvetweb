<tr>
        <td><?php echo $id; ?></td>
	<td><?php echo $name; ?></td>
	<td>
		<a href="editServiceCategory/<?php echo $id; ?>"><button class="btn btn-default" data-id="<?php echo $id; ?>">Edit</button></a>
		<button class="btn btn-danger btnRemoveServiceCategory" data-id="<?php echo $id; ?>">Remove</button>
	</td>
</tr>