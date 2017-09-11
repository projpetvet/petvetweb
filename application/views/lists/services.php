<tr id="service<?php echo $id; ?>">
	<td><?php echo $name; ?></td>
	<td><?php echo $price; ?></td>
	<td>
            <img class="thumbnail" src="<?php echo base_url()."www/images/services/".$image ?>">
	</td>
        <td><?php echo $service_category_caption; ?></td>
	<td>
		<a href="editService/<?php echo $id; ?>"><button id="btnEditService" class="btn btn-default" data-id="<?php echo $id; ?>">Edit</button></a>
		<button id="btnRemoveService" class="btn btn-danger" data-id="<?php echo $id; ?>">Remove</button>
	</td>
</tr>