<?php

namespace App\Http\Controllers\ControllerAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * activer menu
     */
    public function __construct()
    {
        view()->share([
            'category_menu' => true,
        ]);
    }
    /*
     * Load category data
     */
    public function index()
    {
        $datas = Category::select('id', 'name', 'parent_id')->with('parent')->orderBy('id', 'DESC')->get();
        return view('admin.category.index', compact('datas'));
    }
    /*
     * Display the interface to add new categories
     */
    public function create()
    {
        // displays parent categories
        $parent = Category::select('id', 'name', 'parent_id')->orderBy('id', 'DESC')->get()->toArray();
        return view('admin.category.create', compact('parent'));
    }
    /*
     * Perform new categories
     */
    public function store(CategoryRequest $request)
    {
        $category = new Category;
        $category->name      = $request->name;
        $category->alias     = changeTitle($request->name);
        $category->parent_id = (int) $request->parent_id;
        $category->keyword   = $request->keyword;
        $category->description = $request->description;
        if ($category->save()) {
            return redirect()->route('admin.category.create')->with('success','New successfully added');
        } else {
            return redirect()->route('admin.category.create')->with('danger','An error could not add data');
        }

    }

    public function edit($id)
    {

        $category = Category::find($id);
        if (!$category) {
            return redirect()->route('admin.category.index')->with('danger','Data does not exist');
        }
        $parent = Category::select('id', 'name', 'parent_id')->orderBy('id', 'DESC')->get();
        return view('admin.category.edit', compact('parent', 'category'));
    }

    public function update(CategoryRequest $request, $id)
    {

        $category = Category::find($id);
        $category->name      = $request->name;
        $category->alias     = changeTitle($request->name);
        $category->parent_id = (int) $request->parent_id;
        $category->keyword   = $request->keyword;
        $category->description = $request->description;

        if ($category->save()) {
            return redirect()->route('admin.category.update', $request->id)->with('success','Successful editing');
        } else {
            return redirect()->route('admin.category.update', $request->id)->with('danger','An error could not add data');
        }
    }


    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return redirect()->route('admin.category.index')->with('danger','Data does not exist');
        }

        $parent = Category::where('parent_id', $id)->count();
        if($parent == 0){
            $category->delete();
            return redirect()->route('admin.category.index')->with('success','Deleted successfully');
        }
        return redirect()->route('admin.category.index')->with('success','Deleting a category was unsuccessful, and there is a sub category!');
    }
}
