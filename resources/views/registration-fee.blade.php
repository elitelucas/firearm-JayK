<h3 class="pt-3 pb-1" style="border-bottom:1px solid lightgray"><i class="bx bx-calculator mr-2"></i> Registration Fees</h3>
<h5 style="margin-top:10px">Admission  $ <span id="fee">{{number_format($price, 2)}}</span></h5>
<div class="col-lg-3 col-md-4 col-sm-5 col-xs-6 mb-3 mt-2" title="Class">
    <select name="QTY" id="QTY" class="form-control" onchange="total_fee(this)">
        @for($i=0; $i<=$qty; $i++)
            @if($i<=6)
            <option value="{{$i}}">{{$i}}</option>
            @endif
        @endfor
    </select>
</div>
<div class="col-md-8 col-sm-8 col-xs-12" id="fees_table" style="display: none">
    <table width="100%" class="table table-bordered">
        <tbody>
            <tr>
                <td style="vertical-align:middle" width="60%">Registration Fees</td>
                <td width="40%" align="right">
                    <input class="form-control" style="width: 100px" type="text" name="fees" id="fees" size="10" value="0.00" readonly onfocus="this.form.elements[0].focus()">
                </td>
            </tr>
            <tr style="display:none;">
                <td>
                    <input type="hidden" id="discount" name="discount" size="10" value="0" readonly="readyonly" onfocus="this.form.elements[0].focus()">
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td style="vertical-align:middle">Total</td>
                <td align="right">
                    <input class="form-control" style="width: 100px" type="text" name="displaytotal" id="displaytotal" size="10" value="0.00" readonly onfocus="this.form.elements[0].focus()">
                    <input type="hidden" name="total" id="total" size="10" value="" onfocus="this.form.elements[0].focus()">
                </td>
            </tr>
        </tfoot>
    </table>
</div>