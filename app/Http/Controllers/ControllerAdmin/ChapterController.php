<?php

namespace App\Http\Controllers\ControllerAdmin;

use Illuminate\Http\Request;
use App\Http\Requests\ChapterRequest;
use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Story;
use Illuminate\Support\Facades\View;
use Auth;

class ChapterController extends Controller
{

    public function index(Request $request)
    {

        $level = Auth::user()->level;
        $chapters = Chapter::select('chapters.*')->leftJoin('stories', 'stories.id', '=', 'chapters.story_id');
        if($level == 1) {
            $chapters = $chapters->where('user_id', Auth::user()->id);
        }
        $chapters = $chapters->orderBy('updated_at', 'DESC')->get();

        return view('admin.chapter.index', compact('chapters'));
    }

    /**
     * @param $storyId
     *  load list chương
     */
    public function listChapter($storyId)
    {
        $chapters = Chapter::select('chapters.*')->leftJoin('stories', 'stories.id', '=', 'chapters.story_id')->where('story_id', $storyId)->orderBy('updated_at', 'DESC')->get();
        $story    = Story::find($storyId);
        return view('admin.chapter.index', compact('story', 'chapters'));
    }


    public function create($storyId)
    {
        $story    = Story::find($storyId);
        $chapterSubname = Chapter::theNextSubname($storyId);

        return view('admin.chapter.create', compact('chapterSubname', 'story'));
    }


    public function store(ChapterRequest $request)
    {
        $chapter = new Chapter;
        $chapter->name      = $request->txtName;
        $chapter->subname   = $request->txtSubname;
        $chapter->alias     = changeTitle($request->txtSubname);
        $chapter->content   = $request->txtContent;
        $chapter->story_id  = $request->story_id;
        $chapter->active   = isset($request->active) ? $request->active : 0;
        $chapter->view      = 0;
        if ($chapter->save()) {
            return redirect()->route('admin.chapter.list', $chapter->story_id)->with('success','New successfully added');
        } else {
            return redirect()->route('admin.category.create')->with('danger', 'An error could not add data');
        }
    }


    public function edit($id)
    {
        $chapter = Chapter::find($id);

        if (!$chapter) {
            return redirect()->route('admin.chapter.index')->with('danger', 'Data does not exist');
        }

        $user_id = $chapter->story->user_id;
        $story = $chapter->story;

        if(!Auth::user()->isAdmin() && $user_id != Auth::user()->id)
            return redirect()->route('admin.chapter.index')->with('danger', 'This article is not yours!');

        return view('admin.chapter.edit', compact('chapter', 'story'));
    }


    public function update(ChapterRequest $request, $id)
    {
        $chapter = Chapter::find($id);
        $chapter->name      = $request->txtName;
        $chapter->subname   = $request->txtSubname;
        $chapter->alias     = changeTitle($request->txtSubname);
        $chapter->content   = $request->txtContent;
        $chapter->active   = isset($request->active) ? $request->active : 0;

        if ($chapter->save()) {
            return redirect()->route('admin.chapter.list', $chapter->story_id)->with('success','Successful editing');
        } else {
            return redirect()->route('admin.chapter.index')->with('danger', 'An error could not add data');
        }
    }


    public function destroy($id)
    {
        $chapter = Chapter::find($id);
        if (!$chapter) {
            return redirect()->route('admin.chapter.index')->with('danger', 'Data does not exist');
        }

        $user_id = $chapter->story->user_id;
        if(!Auth::user()->isAdmin() && $user_id != Auth::user()->id)
            return redirect()->route('admin.chapter.index')->with('danger', 'This article is not yours!');
        $story_id = $chapter->story_id;

        if ($chapter->delete()) {
            return redirect()->route('admin.chapter.list', $story_id)->with('success','Deleted successfully');
        } else {
            return redirect()->route('admin.chapter.index')->with('danger', 'An error cannot be deleted');
        }
    }

    public function activeStatus(Request $request, $id)
    {
        $chapter = Chapter::find($id);
        if (!$chapter) {
            return redirect()->route('admin.chapter.index')->with('danger','Data does not exist');
        }
        $chapter->active = 1;
        $chapter->save();
        return redirect()->route('admin.chapter.list', $chapter->story_id)->with('success', 'Successful browsing!');
    }

}
