<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use App\Traits\Admin\FiltersTrait;
use App\Traits\ImagesManagerTrait;

class PagesController extends Controller
{
    use FiltersTrait, ImagesManagerTrait;

    public function index()
    {
        if(!\auth()->user()->ability('admin', 'manage_pages,show_pages')){
            return redirect('admin/index');
        }

        $this->setFilters(request()->keyword, request()->status, request()->sort_by, request()->order_by, request()->limit_by);
        $pages = Page::wherePostType('page');

        if($this->getKeyword() != null){
            $pages = $pages->search($this->getKeyword());
        }

        if($this->FiltersCategoryId(request()->category_id) != null){
            $pages = $pages->whereCategoryId($this->FiltersCategoryId(request()->category_id));
        }

        if($this->getStatus() != null){
            $pages = $pages->whereStatus($this->getStatus());
        }

        $pages = $pages->orderBy($this->getSortBy(), $this->getOrderBy())->paginate($this->getLimitBy());
        $categories = Category::orderBy('id', 'desc')->pluck('name', 'id');

        return view('admin.pages.index', compact('pages', 'categories'));
    }

    public function create()
    {
        if(!\auth()->user()->ability('admin', 'create_pages')){
            return redirect('admin/index');
        }

        $categories = Category::orderBy('id', 'desc')->pluck('name', 'id');
        return view('admin.pages.create', compact('categories'));
    }

    public function store(PageRequest $request)
    {
        if(!\auth()->user()->ability('admin', 'create_pages')){
            return redirect('admin/index');
        }

        $page = auth()->user()->posts()->create(array_merge($request->validated(),[
            'post_type' => 'page',
            'comment_able' => 0
        ]));
        
        $this->PostImagesUploade($request->images, $page);

        return redirect()->route('admin.pages.index')->with([
            'message' => 'Page created successfully',
            'alert-type' => 'success'
        ]);
    }

    public function show($id)
    {
        if(!\auth()->user()->ability('admin', 'display_pages')){
            return redirect('admin/index');
        }

        $page = Page::with(['media'])->whereId($id)->wherePostType('page')->first();
        return view('admin.pages.show', compact('page'));
    }

    public function edit($id)
    {
        if(!\auth()->user()->ability('admin', 'update_pages')){
            return redirect('admin/index');
        }
        $categories = Category::orderBy('id', 'desc')->pluck('name', 'id');
        $page = Page::with(['media'])->whereId($id)->wherePostType('page')->first();
        return view('admin.pages.edit', compact('page', 'categories'));
    }

    public function update(PageRequest $request, $id)
    {
        if(!\auth()->user()->ability('admin', 'update_pages')){
            return redirect('admin/index');
        }

        $page = Page::whereId($id)->wherePostType('page')->first();
        if($page){

            $page->update($request->validated());
            $this->PostImagesUploade($request->images, $page);
            
            return redirect()->back()->with([
                'message' => 'Page updated successfully',
                'alert-type' => 'success'
            ]);
        }
        return redirect()->back()->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($id)
    {
        if(!\auth()->user()->ability('admin', 'delete_pages')){
            return redirect('admin/index');
        }

        $page = Page::whereId($id)->wherePostType('page')->first();

        if($page){
            $this->destroyPostMedia($page);
            $page->delete();

            return redirect()->back()->with([
                'message' => 'Page deleted successfully',
                'alert-type' => 'success'
            ]);
        }
        return redirect()->back()->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger'
        ]);
    }

    public function removeImage(Request $request)
    {
        if(!\auth()->user()->ability('admin', 'delete_pages')){
            return redirect('admin/index');
        }

        return $this->destroyPostImage($request->media_id);
    }
}
