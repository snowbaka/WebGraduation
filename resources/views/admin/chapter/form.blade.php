<form action="" method="POST">
    <div class="box-body">
        {{ csrf_field() }}
        @if (isset($story))
        <input class="form-control" name="story_id" type="hidden" value="{{ old('story_id', $story->id) }}"/>
        @endif
        <div class="form-group {{ $errors->has('txtSubname') ? 'has-error' : '' }}">
            <input class="form-control" name="txtSubname" value="{{ old('txtSubname', isset($chapter) ? $chapter->subname : $chapterSubname) }}"/>
            @if($errors->has('txtSubname'))
                <span class="help-block">{{$errors->first('txtSubname')}}</span>
            @endif
        </div>

        <div class="form-group {{ $errors->has('txtName') ? 'has-error' : '' }}">
            <label>Name chapter</label>
            <input class="form-control" name="txtName" placeholder="Name chapter" value="{{ old('txtName', isset($chapter) ? $chapter->name : '') }}"/>
            @if($errors->has('txtName'))
                <span class="help-block">{{$errors->first('txtName')}}</span>
            @endif
        </div>

        <div class="form-group {{ $errors->has('txtContent') ? 'has-error' : '' }}">
            <label>Content</label>
            <textarea name="txtContent" id="txtContent" class="form-control" rows="3">{{ old('txtContent', isset($chapter) ? $chapter->content : '') }}</textarea>
            <script>
                ckeditor(txtContent);
            </script>
            @if($errors->has('txtContent'))
                <span class="help-block">{{$errors->first('txtContent')}}</span>
            @endif
        </div>

        @php
            $level = \Auth::user()->level
        @endphp
        @if($level == 2 || $level == 3)
            <div class="form-group">
                <label>Status</label>
                <select name="active" class="form-control">
                    <option value="1" {{ isset($story) && $story->active == 1 ? 'selected="selected"' : '' }}>Approved</option>
                    <option value="0" {{ isset($story) && $story->active == 0 ? 'selected="selected"' : '' }}>Unapproved</option>
                </select>
            </div>
        @endif
        <button type="submit" class="btn btn-primary"> @if(isset($chapter)) Update @else Add new @endif</button>
        <button type="reset" class="btn btn-danger">Reset</button>

    </div>
</form>