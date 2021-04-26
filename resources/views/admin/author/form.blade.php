<form action="" method="POST">
    <div class="box-body">
        {{ csrf_field() }}
        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            <label>The writer's name</label>
            <input class="form-control" name="name" placeholder="Enter the name of the author" value="{{ old('name', isset($author) ? $author->name : '') }}"/>
            @if($errors->has('name'))
                <span class="help-block">{{$errors->first('name')}}</span>
            @endif
        </div>
        <div class="form-group">
            <label>Keyword search</label>
            <input class="form-control" name="keyword" placeholder="Keyword 1, keyword 2, keyword 3" value="{{ old('keyword', isset($author) ? $author->keyword : '') }}"/>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', isset($author) ? $author->description : '') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary"> @if(isset($author)) Update @else Add new @endif</button>
        <button type="reset" class="btn btn-danger">Reset</button>

    </div>
</form>