<div class="col-xs-10">
    <div class="container">
        <div class="main-container col-xs-12">
            <h1>Appointment</h1>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td width="20%" class="cell-1">ID</td>
                        <td width="*" class="cell-2"><?php echo $id; ?></td>
                    </tr>
                    <tr>
                        <td width="20%" class="cell-1">Customer</td>
                        <td width="*" class="cell-2"><?php echo $customer; ?></td>
                    </tr>
                    <tr>
                        <td width="20%" class="cell-1">Pet</td>
                        <td width="*" class="cell-2"><?php echo $pet; ?></td>
                    </tr>
                    <tr>
                        <td width="20%" class="cell-1">Doctor</td>
                        <td width="*" class="cell-2"><?php echo $doctor; ?></td>
                    </tr>
                    <tr>
                        <td width="20%" class="cell-1">Date</td>
                        <td width="*" class="cell-2"><?php echo $app_date; ?></td>
                    </tr>
                    <tr>
                        <td width="20%" class="cell-1">Time</td>
                        <td width="*" class="cell-2"><?php echo $app_time; ?></td>
                    </tr>
                    <tr>
                        <td width="20%" class="cell-1">Note</td>
                        <td width="*" class="cell-2"><?php echo $note; ?></td>
                    </tr>
                    <tr>
                        <td width="20%" class="cell-1">Status</td>
                        <td width="*" class="cell-2"><?php echo $status_caption; ?></td>
                    </tr>
                    <?php //echo $list; ?>
                </tbody>
            </table>
            <h3>Services List</h3>
            <table class="table table-striped">
                <tr class="tb-header">
                    <th>Service ID</th>
                    <th>Service</th>
                    <th class="centered">Price</th>
                </tr>
                <tbody>
                    <?php echo $list; ?>
                </tbody>
<!--                <tr>
                    <td colspan="4"><span class="grand-total">Grand Total:</span></td>
                    <td><span class="grand-total"><?php echo $total; ?></span></td>
                </tr>-->
            </table>
        </div>
    </div>
</div>