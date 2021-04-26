<?php

namespace App\Http\Controllers\ControllerAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorRequest;
use App\Models\Author;

class AuthorController extends Controller
{
    /**
     * activer menu
     */
    public function __construct()
    {
        view()->share([
            'author_menu' => true,
        ]);
    }
    /*
     * show list of authors
     */
    public function index()
    {
        $datas = Author::select('id', 'name')->orderBy('id', 'DESC')->get();
        return view('admin.author.index', compact('datas'));
    }

    /*
     * Display the new author's interface
     */
    public function create()
    {
        return view('admin.author.create');
    }
    /*
     * Performs insert data
     */
    public function store(AuthorRequest $request)
    {
        $author = new Author;
        $author->name      = $request->name;
        $author->alias     = changeTitle($request->name);
        $author->keyword   = $request->keyword;
        $author->description = $request->description;
        $author->save();
        if ($author->save()) {
            return redirect()->route('admin.author.create')->with('success', 'New successfully added');
        } else {
            return redirect()->route('admin.author.create')->with('danger', 'An error could not add data');
        }
    }

    /*
     * load data editing interface
     */
    public function edit($id)
    {
        if(!\Auth::user()->isAdmin()) {
            return redirect()->route('dashboard.author.index')->with('danger','You are not an administrator !');
        }

        $author = Author::find($id);
        if (!$author) {
            return redirect()->route('admin.author.index')->with('danger','Data does not exist');
        }

        return view('admin.author.edit', compact('author'));
    }
    /*
     * Perform data update
     */
    public function update(AuthorRequest $request, $id)
    {
        $author = Author::find($id);
        $author->name      = $request->name;
        $author->alias     = changeTitle($request->name);
        $author->keyword   = $request->keyword;
        $author->description = $request->description;

        if ($author->save()) {
            return redirect()->route('admin.author.update', $id)->with('success','Successful editing');
        } else {
            return redirect()->route('admin.author.update', $id)->with('danger','An error could not add data');
        }
    }
    /*
     *Delete author
     */
    public function destroy($id)
    {
        if(!\Auth::user()->isAdmin())
            return redirect()->route('admin.author.index')->with('danger','You are not an administrator !');
        $author    = Author::find($id);
        if (!$author) {
            return redirect()->route('admin.author.index')->with('danger','Data does not exist');
        }
        $author->delete();
        return redirect()->route('admin.author.index')->with('success','Deleted successfully');
    }

}
