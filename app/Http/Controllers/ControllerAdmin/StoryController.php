<?php

namespace App\Http\Controllers\ControllerAdmin;

use Faker\Provider\Image;
use Illuminate\Http\Request;;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoryRequest;
use App\Models\Story;
use App\Models\Chapter;
use App\Models\Category;
use App\Models\Author;
use Auth;

class StoryController extends Controller
{

    public function index(Request $request)
    {
        if(Auth::user()->isAdmin()) {
            $level = Auth::user()->level;
            if($level == 1) {
                $datas = Story::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
            } else {
                $datas = Story::orderBy('id', 'DESC')->get();
            }
        } else {
            $datas = Auth::user()->stories()->orderBy('id', 'DESC')->get();
        }


        return view('admin.story.index', compact('datas'));
    }

    public function create()
    {
        $categories = Category::select('id', 'name', 'parent_id')->orderBy('id', 'DESC')->get()->toArray();
        $authors = Author::select('id', 'name')->orderBy('id', 'DESC')->get()->toArray();
        return view('admin.story.create', compact('categories', 'authors'));
    }

    public function store(StoryRequest $request)
    {
        $story = new Story;
        $story->name      = $request->txtName;
        $story->alias     = changeTitle($request->txtName);
        $story->content   = $request->txtContent;
        $story->source    = $request->txtSource;
        $story->active    = isset($request->active) ? $request->active : 0;
        if($request->hasFile('fImages'))
        {
            $story->image = uploadURI( $story->alias );
            $imageName = $story->alias . '.jpeg';
            $request->file('fImages')->move(uploadPath(), $imageName);
            $fullPath    = public_path($story->image);
            // addWatermark($fullPath);
            // $pathResize1 = uploadURI( $story->alias . '-thumb' );
            // $pathResize2 = uploadURI( $story->alias . '-thumbw' );
            // resizeImage($fullPath, $pathResize1, 180, 80, 1);
            // resizeImage($fullPath, $pathResize2, 60, 85);
        }
        $story->view      = 0;
        $story->keyword   = $request->txtKeyword;
        // $story->description = $request->txtDescription;
        $story->status    = $request->selStatus;
        $story->user_id = Auth::user()->id;
        $story->save();
        $story->categories()->attach($request->intCategory);
        $story->authors()->attach($request->intAuthor);

        return redirect()->route('admin.story.create')->with('success', 'Add new stories successfully!');
    }


    public function edit($id)
    {
        $story = Story::find($id);

        if (!$story) {
            return redirect()->route('admin.story.index')->with('danger','Data does not exist');
        }

        if(!Auth::user()->isAdmin() && Auth::user()->id != $story->user_id)
            return redirect()->route('admin.story.index')->with('danger','This article is not yours!');
        $categories = Category::select('id', 'name', 'parent_id')->orderBy('id', 'DESC')->get()->toArray();
        $authors = Author::select('id', 'name')->orderBy('id', 'DESC')->get()->toArray();

        return view('admin.story.edit', compact('story', 'categories', 'authors'));
    }


    public function update(StoryRequest $request, $id)
    {

        $story = Story::find($id);
        $story->name      = $request->txtName;
        $story->alias     = changeTitle($request->txtName);
        $story->content   = $request->txtContent;
        $story->source    = $request->txtSource;
        $story->categories()->sync($request->intCategory);
        $story->authors()->sync($request->intAuthor);
        $story->keyword   = $request->txtKeyword;
        // $story->description = $request->txtDescription;
        $story->status    = $request->selStatus;
        $story->active    = isset($request->active) ? $request->active : 0;
        if(($request->hasFile('fImages')))
        {
            @unlink(public_path() . '/' . $story->image);
            @unlink(public_path() . '/' . imageThumb($story->image));
            @unlink(public_path() . '/' . imageThumb($story->image, true));
            $story->image = uploadURI( $story->alias );
            $imageName = $story->alias . '.jpeg';
            $request->file('fImages')->move(uploadPath(), $imageName);
            $fullPath    = public_path($story->image);
            // addWatermark($fullPath);
            // $pathResize1 = uploadURI( $story->alias . '-thumb' );
            // $pathResize2 = uploadURI( $story->alias . '-thumbw' );
            // resizeImage($fullPath, $pathResize1, 180, 80, true);
            // resizeImage($fullPath, $pathResize2, 60, 85);
        }
        $story->save();
        return redirect()->route('admin.story.update', $id)->with('success', 'Successful editing!');
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        $story = Story::find($id);

        if (!$story) {
            return redirect()->route('admin.story.index')->with('danger','Data does not exist');
        }

        $user_id = $story->user_id;
        if(!Auth::user()->isAdmin() && $user_id != Auth::user()->id)
            return redirect()->route('admin.story.index')->with('danger','This article is not yours!');

        if(!empty($story->image))
        {
            @unlink(public_path() . '/' . $story->image);
            @unlink(public_path() . '/' . imageThumb($story->image));
            @unlink(public_path() . '/' . imageThumb($story->image, true));
        }
        $story->delete();
        return redirect()->route('admin.story.index')->with('success', 'Successfully deleted the story!');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activeStatus(Request $request, $id)
    {
        $story = Story::find($id);
        if (!$story) {
            return redirect()->route('admin.story.index')->with('danger','Data does not exist');
        }
        $story->active = 1;
        $story->save();
        return redirect()->route('admin.story.index')->with('success', 'Successful browsing!');
    }

}
