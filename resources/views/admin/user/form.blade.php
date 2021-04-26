<form action="" method="POST">
    <div class="box-body">
        {{ csrf_field() }}

        <div class="form-group {{ $errors->has('txtName') ? 'has-error' : '' }}">
            <label>Name</label>
            <input type="text" class="form-control" name="txtName" placeholder="Enter a name" value="{{ old('txtName', isset($user) ? $user->name : '') }}"/>
            @if($errors->has('txtName'))
                <span class="help-block">{{$errors->first('txtName')}}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('txtEmail') ? 'has-error' : '' }}">
            <label>Email</label>
            <input type="email" class="form-control" name="txtEmail" placeholder="Enter member email" value="{{ old('txtEmail', isset($user) ? $user->email : '') }}"/>
            @if($errors->has('txtEmail'))
                <span class="help-block">{{$errors->first('txtEmail')}}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('txtPassword') ? 'has-error' : '' }}">
            <label>Password {{ isset($user) ? '(Leave it blank to remain unchanged)' : ''}}</label>
            <input type="password" class="form-control" name="txtPassword" placeholder="Enter the member password" />
            @if($errors->has('txtPassword'))
                <span class="help-block">{{$errors->first('txtPassword')}}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('txtPassword_confirmation') ? 'has-error' : '' }}">
            <label>Confrim password</label>
            <input type="password" class="form-control" name="txtPassword_confirmation" placeholder="Enter the member password" />
            @if($errors->has('txtPassword_confirmation'))
                <span class="help-block">{{$errors->first('txtPassword_confirmation')}}</span>
            @endif
        </div>

        <div class="form-group">
            <label>Position</label>
            <select class="form-control" name="txtLevel" placeholder="Position">
                <option value="0">Member</option>
                <option value="1" {{ isset($user) && ($user->level == 1) ? 'selected' : '' }}>Editor</option>
                <option value="2" {{ isset($user) && ($user->level == 2) ? 'selected' : '' }}>Compilation</option>
                <option value="3" {{ isset($user) && ($user->level == 3) ? 'selected' : '' }}>Administrators</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary"> @if(isset($user)) Update @else Add new @endif</button>
        <button type="reset" class="btn btn-danger">Reset</button>

    </div>
</form>