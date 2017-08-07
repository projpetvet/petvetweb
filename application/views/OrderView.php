<div class="col-xs-10">
    <div class="container">
        <div class="main-container col-xs-12">
            <h1>Order</h1>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td width="20%" class="cell-1">ID</td>
                        <td width="*" class="cell-2"><?php echo $id; ?></td>
                    </tr>
                    <tr>
                        <td width="20%" class="cell-1">Customer</td>
                        <td width="*" class="cell-2"><?php echo $billing_name; ?></td>
                    </tr>
                    <tr>
                        <td width="20%" class="cell-1">Address</td>
                        <td width="*" class="cell-2"><?php echo $billing_address; ?></td>
                    </tr>
                    <tr>
                        <td width="20%" class="cell-1">Email Address</td>
                        <td width="*" class="cell-2"><?php echo $billing_email; ?></td>
                    </tr>
                    <tr>
                        <td width="20%" class="cell-1">Mobile Number</td>
                        <td width="*" class="cell-2"><?php echo $billing_mobile; ?></td>
                    </tr>
                    <tr>
                        <td width="20%" class="cell-1">Note</td>
                        <td width="*" class="cell-2"><?php echo $note; ?></td>
                    </tr>
                    <tr>
                        <td width="20%" class="cell-1">Date</td>
                        <td width="*" class="cell-2"><?php echo $date_added; ?></td>
                    </tr>
                    <tr>
                        <td width="20%" class="cell-1">Status</td>
                        <td width="*" class="cell-2"><?php echo $status_caption; ?></td>
                    </tr>
                    <?php //echo $list; ?>
                </tbody>
            </table>
            <h3>Product List</h3>
            <table class="table table-striped">
                <tr class="tb-header">
                    <th>Product ID</th>
                    <th>Product</th>
                    <th class="centered">Quantity</th>
                    <th class="centered">Price</th>
                    <th class="centered">Total</th>
                </tr>
                <tbody>
                    <?php echo $list; ?>
                </tbody>
                <tr>
                    <td colspan="4"><span class="grand-total">Grand Total:</span></td>
                    <td><span class="grand-total"><?php echo $total; ?></span></td>
                </tr>
            </table>
        </div>
    </div>
</div>