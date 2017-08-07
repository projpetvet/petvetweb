<tr id="member<?php echo $id; ?>">
	<td id="memberFname<?php echo $id; ?>"><?php echo $firstname; ?></td>
	<td id="memberLname<?php echo $id; ?>"><?php echo $lastname; ?></td>
	<td id="memberMobile<?php echo $id; ?>"><?php echo $mobile; ?></td>
	<td>
		<button id="btnViewMember" class="btn btn-default" data-id="<?php echo $id; ?>">View</button>
		<button id="btnEditMember" class="btn btn-default" data-id="<?php echo $id; ?>">Edit</button>
		<button id="btnRemoveMember" class="btn btn-danger" data-id="<?php echo $id; ?>">Remove</button>
	</td>
</tr>