<?php
echo"
<tr>
    <td>$id</td>
    <td>$name</td>
    <td>$specie</td>
    <td><a href='/admin/editBreed/$id' class='edit_breed pointer-link' data-id='$id' data-specie-id='$specie_id' data-name='$name'>Edit</a> | <a class='delete_breed pointer-link' data-id='$id'>Delete</a></td>
</tr>
";
?>