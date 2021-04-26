
<form action="" method="POST" enctype="multipart/form-data">
    <div class="box-body">
        {{ csrf_field() }}
        <div class="form-group {{ $errors->has('txtName') ? 'has-error' : '' }}">
            <label>Story name</label>
            <input class="form-control" name="txtName" value="{{ old('txtName', isset($story) ? $story->name : '') }}"/>
            @if($errors->has('txtName'))
                <span class="help-block">{{$errors->first('txtName')}}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('intCategory') ? 'has-error' : '' }}">
            <label>Categories </label>
            <select name="intCategory[]" data-placeholder="Select categories" id="selectCategory" class="form-control chosen-select" multiple>
                <option value=""></option>
                @if(isset($story))
                    {{ category_parent($categories, $story->categories) }}
                @else
                    {{ category_parent($categories) }}
                @endif
            </select>
            @if($errors->has('intCategory'))
                <span class="help-block">{{$errors->first('intCategory')}}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('intAuthor') ? 'has-error' : '' }}">
            <label>Author</label>
            <select name="intAuthor[]" data-placeholder="Choose an author" class="form-control chosen-select" id="selectAuthor" multiple>
                <option value=""></option>
                @if(isset($story))

                    {{ author_options($authors, $story->authors) }}
                @else
                    {{ author_options($authors) }}
                @endif
            </select>
            @if($errors->has('intAuthor'))
                <span class="help-block">{{$errors->first('intAuthor')}}</span>
            @endif
        </div>

        <!-- <div class="form-group {{ $errors->has('txtDescription') ? 'has-error' : '' }}">
            <label>Short description</label>
            <textarea name="txtDescription" id="txtDescription" class="form-control" rows="3">{{ old('txtDescription', isset($story) ? $story->description : '') }}</textarea>
            <script>
                ckeditor(txtDescription);
            </script>
        </div> -->

        <div class="form-group {{ $errors->has('txtContent') ? 'has-error' : '' }}">
            <label>Content description</label>
            <textarea class="form-control editor" rows="10" name="txtContent" id="txtContent" >{{ old('txtContent', isset($story) ? $story->content : '') }}</textarea>
            <script>
                ckeditor(txtContent);
            </script>
        </div>
        <div class="form-group  {{ $errors->has('fImages') ? 'has-error' : '' }}">
            <label>Avatar</label>
            <input type="file" name="fImages">
            @if (isset($story) && !empty($story->image))
                <div style="width: 300px; height: 400px; background: url({{ url($story->image) }}); background-size: 100% 100%; margin-top: 20px"></div>
            @endif
            @if($errors->has('fImages'))
                <span class="help-block">{{$errors->first('fImages')}}</span>
            @endif
        </div>
        <div class="form-group">
            <label>Keywords</label>
            <input class="form-control" name="txtKeyword" value="{{ old('txtKeyword', isset($story) ? $story->keyword : '') }}"/>
        </div>


        <div class="form-group {{ $errors->has('txtSource') ? 'has-error' : '' }}">
            <label>Story source</label>
            <input class="form-control" name="txtSource" value="{{ old('txtSource', isset($story) ? $story->source : '') }}" />
            @if($errors->has('txtSource'))
                <span class="help-block">{{$errors->first('txtSource')}}</span>
            @endif
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="selStatus" class="form-control">
                <option value="0" {{ isset($story) && $story->status == 0 ? 'selected="selected"' : '' }}>Updating</option>
                <option value="1" {{ isset($story) && $story->status == 1 ? 'selected="selected"' : '' }}>Finish</option>
                <option value="2" {{ isset($story) && $story->status == 2 ? 'selected="selected"' : '' }} >Stop updating</option>
            </select>
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

        <button type="submit" class="btn btn-primary">@if(isset($story)) Update stories  @else Post stories @endif</button>
        <button type="reset" class="btn btn-danger">Reset</button>
    </div>
</form>