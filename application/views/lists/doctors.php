<tr id="doctor<?php echo $id; ?>">
	<td id="firstName<?php echo $id; ?>"><?php echo $firstname; ?></td>
	<td id="lastName<?php echo $id; ?>"><?php echo $lastname; ?></td>
	<td id="mobileNumber<?php echo $id; ?>"><?php echo $mobile; ?></td>
	<td>
		<button id="btnEditDoctor" class="btn btn-default" data-id="<?php echo $id; ?>">Edit</button>
		<button id="btnRemoveDoctor" class="btn btn-danger" data-id="<?php echo $id; ?>">Remove</button>
	</td>
</tr>