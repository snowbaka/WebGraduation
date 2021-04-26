<form action="" method="POST">
    <div class="box-body">
        {{ csrf_field() }}
        <!-- <div class="form-group">
            <label>Category parent</label>
            <select name="parent_id" class="form-control">
                <option value="0">[NA]</option>
                @if (isset($category))
                    {{ category_parent($parent, $category->parent_id) }}
                @else
                    {{ category_parent($parent) }}
                @endif
            </select>

        </div> -->
        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            <label>Category name</label>
            <input class="form-control" name="name" placeholder="Enter the name of the category" value="{{ old('name', isset($category) ? $category->name : '') }}"/>
            @if($errors->has('name'))
                <span class="help-block">{{$errors->first('name')}}</span>
            @endif
        </div>
        <div class="form-group">
            <label>Keyword search</label>
            <input class="form-control" name="keyword" placeholder="Keyword 1, keyword 2, keyword 3" value="{{ old('keyword', isset($category) ? $category->keyword : '') }}"/>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', isset($category) ? $category->description : '') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary"> @if(isset($category)) Update @else Add new @endif</button>
        <button type="reset" class="btn btn-danger">Reset</button>
    </div>
</form>