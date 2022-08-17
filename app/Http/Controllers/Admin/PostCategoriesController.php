<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Traits\Admin\FiltersTrait;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class PostCategoriesController extends Controller
{
    use FiltersTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!\auth()->user()->ability('admin', 'manage_post_categories,show_post_categories')){
            return redirect('admin/index');
        }

        $this->setFilters(request()->keyword, request()->status, request()->sort_by, request()->order_by, request()->limit_by);
        $categories = Category::withCount('posts');
        if($this->getKeyword() != null){
            $categories = $categories->search($this->getKeyword());
        }

        if($this->getStatus() != null){
            $categories = $categories->whereStatus($this->getStatus());
        }
        $categories = $categories->orderBy($this->getSortBy(), $this->getOrderBy())->paginate($this->getLimitBy());
        return view('admin.post_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!\auth()->user()->ability('admin', 'create_post_categories')){
            return redirect('admin/index');
        }
        return view('admin.post_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        if(!\auth()->user()->ability('admin', 'create_post_categories')){
            return redirect('admin/index');
        }

        Category::create($request->validated());
        if($request->status == 1){
            Cache::forget('global_categories');
        }

        return redirect()->route('admin.post_categories.index')->with([
            'message' => 'Category created successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!\auth()->user()->ability('admin', 'update_post_categories')){
            return redirect('admin/index');
        }
        $category = Category::whereId($id)->first();
        return view('admin.post_categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        if(!\auth()->user()->ability('admin', 'update_post_categories')){
            return redirect('admin/index');
        }

        $category = Category::whereId($id)->first();

        if($category){
            $category->update($request->validated());

            if($request->status == 1){
                Cache::forget('global_categories');
            }
            return redirect()->route('admin.post_categories.index')->with([
                'message' => 'Category updated successfully',
                'alert-type' => 'success'
            ]);
        }
        return redirect()->back()->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!\auth()->user()->ability('admin', 'delete_post_categories')){
            return redirect('admin/index');
        }

        $category = Category::whereId($id)->first();

        if($category){
            foreach($category->posts as $post){
                if($post->media->count() > 0){
                    foreach($post->media as $media){
                        if(File::exists('assets/posts/' . $media->file_name)){
                            unlink('assets/posts/' . $media->file_name);
                        }
                    }
                }
            }

            $category->delete();

            return redirect()->back()->with([
                'message' => 'Category deleted successfully',
                'alert-type' => 'success'
            ]);
        }
        return redirect()->back()->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger'
        ]);
    }
}
