<?php
echo"
<tr>
    <td>$id</td>
    <td>$customer</td>
    <td>$pet</td>
    <td>$doctor</td>
    <td>$app_date</td>
    <td>$app_time</td>
    <td>$status_caption</td>
    <td>
        <a href='/admin/viewAppointment/$id'  target='_blank'>
            <button class='btn btn-info'>View Appointment</button>
        </a>
    </td>
</tr>
";
?>