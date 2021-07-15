<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">@if($admin_user==null){{'Add Admin User'}}@else{{'Edit Admin User'}}@endif</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form action="{{Url('admin-users/save')}}" method="GET">
    <div class="modal-body">
        <input type="hidden" name="id" value="@if($admin_user!=null){{$admin_user->id}}@else{{0}}@endif">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" class="form-control" name="firstname" id="firstname" value="@if($admin_user!=null){{explode(' ', $admin_user->name)[0]}}@endif" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" class="form-control" name="lastname" id="lastname" value="@if($admin_user!=null){{explode(' ', $admin_user->name)[1]}}@endif" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="company">Company</label>
                    <input type="text" class="form-control" name="company" id="company" value="@if($admin_user!=null){{$admin_user->company}}@endif">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="phone">Cell Phone</label>
                    <input type="tel" class="form-control" name="phone" id="phone" value="@if($admin_user!=null){{$admin_user->phone}}@endif" required onkeypress = "check_format(this)">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" name="address" id="address" value="@if($admin_user!=null){{$admin_user->address}}@endif" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="paypal_payout_email">Paypal Payout Email</label>
                    <input type="email" class="form-control" name="paypal_payout_email" id="paypal_payout_email" value="@if($admin_user!=null){{$admin_user->paypal_payout_email}}@endif" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="commission_fee">Commission Fee</label>
                    <input type="text" class="form-control" name="commission_fee" id="commission_fee" value="@if($admin_user!=null){{$admin_user->commission_fee}}@endif">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="commission">Mannual pay</label>
                    <input type="text" class="form-control" name="commission" id="commission" value="@if($admin_user!=null){{$admin_user->commission}}@else{{'0'}}@endif" @if($admin_user==null) disabled @endif>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" value="@if($admin_user!=null){{$admin_user->email}}@endif" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username" value="@if($admin_user!=null){{$admin_user->username}}@endif" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-info">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
</form>
<script>
    $(document).ready(function() {
        $("#phone").keypress(function(event) {
            return /\d/.test(String.fromCharCode(event.keyCode));
        });
    });

    function check_format(phone){
        var phone_number = $(phone).val();
        if(phone_number.length==3){
            $(phone).val(phone_number+'-');
        }else if(phone_number.length==7){
            $(phone).val(phone_number+'-');
        }else if(phone_number.length>=12){
            $(phone).val(phone_number.substr(0, 11));
        }
    }
</script>