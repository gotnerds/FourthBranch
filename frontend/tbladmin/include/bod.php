<?php
$id = $_POST['id'];
var_dump($_POST);
echo '<tr><td style="padding:0;border-top:none;"><div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal'.$id.'">
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h3 id="myModalLabel">Bill Of The Day</h3>
    </div>
    <div class="modal-body">
        <form action="" method="post" id="bod'.$id.'">
            <table id="modalTable" class="table">
                <tr>
                    <td style="font-weight:bold">Bill of The Day Live Date:</td>
                    <td>
                        <input id="alive_date" type="date" name="alive_date" class="input-large hasDatepicker">
                    </td>
                </tr>
                <tr>
                    <td style="font-weight:bold">Summary:<br><span style="font-size:10px;">HINT: you can type DEFAULT</span></td>
                    <td>
                        <textarea name="submitted_summary" class="input-large" rows="10" cols="100"></textarea>
                    </td>
                </tr>    
                <input type="hidden" name="billId" value="'.$id.'">
            </table>
        </form>        
    </div>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn">Close</button>
        <button class="btn btn-primary" onclick="document.getElementById(\'bod'.$id.'\').submit();">Save changes</button>
    </div>
</div></td></tr>';