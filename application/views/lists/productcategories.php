<tr>
        <td><?php echo $id; ?></td>
	<td><?php echo $name; ?></td>
	<td>
		<a href="editProductCategory/<?php echo $id; ?>"><button id="btnEditProduct" class="btn btn-default" data-id="<?php echo $id; ?>">Edit</button></a>
		<button class="btn btn-danger btnRemoveProductCategory" data-id="<?php echo $id; ?>">Remove</button>
	</td>
</tr>