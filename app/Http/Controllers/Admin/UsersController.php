<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Traits\Admin\FiltersTrait;
use App\Traits\ImagesManagerTrait;

class UsersController extends Controller
{
    use FiltersTrait, ImagesManagerTrait;

    public function index()
    {
        if(!\auth()->user()->ability('admin', 'manage_users,show_users')){
            return redirect('admin/index');
        }

        $this->setFilters(request()->keyword, request()->status, request()->sort_by, request()->order_by, request()->limit_by);
        $users = User::whereHas('roles', function($query){
            $query->where('name', 'user');
        });

        if($this->getKeyword() != null){
            $users = $users->search($this->getKeyword());
        }

        if($this->getStatus() != null){
            $users = $users->whereStatus($this->getStatus());
        }

        $users = $users->orderBy($this->getSortBy(), $this->getOrderBy())->paginate($this->getLimitBy());

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        if(!\auth()->user()->ability('admin', 'create_users')){
            return redirect('admin/index');
        }
        return view('admin.users.create');
    }

    public function store(UserRequest $request)
    {
        if(!\auth()->user()->ability('admin', 'create_users')){
            return redirect('admin/index');
        }

        if($user_image = $request->file('user_image')){
            $data['user_image'] = $this->createUserImageUploade($user_image, $request->username);
        }else{
            $data['user_image'] = null;
        }
        
        $user = User::create(array_merge($request->validated(), ['user_image' => $data['user_image']]));
        $user->attachRole(Role::whereName('user')->first()->id);

        return redirect()->route('admin.users.index')->with([
            'message' => 'User created successfully',
            'alert-type' => 'success'
        ]);
    }

    public function show($id)
    {
        if(!\auth()->user()->ability('admin', 'display_users')){
            return redirect('admin/index');
        }

        $user = User::whereId($id)->withCount('posts')->first();
        if($user){
            return view('admin.users.show', compact('user'));
        }
        return redirect()->route('admin.users.index')->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger'
        ]);
    }

    public function edit($id)
    {
        if(!\auth()->user()->ability('admin', 'update_users')){
            return redirect('admin/index');
        }

        $user = User::whereId($id)->first();
        if($user){
            return view('admin.users.edit', compact('user'));
        }
        return redirect()->route('admin.users.index')->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger'
        ]);
    }

    public function update(UserRequest $request, $id)
    {
        if(!\auth()->user()->ability('admin', 'update_posts')){
            return redirect('admin/index');
        }

        $user = User::whereId($id)->first();

        if($user){
            if($request->file('user_image')){
                $user->update(
                    array_merge(
                        $request->validated(),
                        ['user_image' => $this->UserImageUploade($request->file('user_image'), $user->user_image, $user->username)]));
            }else{
                $user->update($request->validated());
            }   

            return redirect()->route('admin.users.index')->with([
                'message' => 'User updated successfully',
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.users.index')->with([
            'message' => 'Something was wrong',
            'alert-type' => 'daner'
        ]);
    }

    public function destroy($id)
    {
        if(!\auth()->user()->ability('admin', 'delete_users')){
            return redirect('admin/index');
        }

        $user = User::whereId($id)->first();

        if($user){
            $this->destroyUserMedia($user);

            $user->delete();

            return redirect()->route('admin.users.index')->with([
                'message' => 'User deleted successfully',
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.users.index')->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger'
        ]);
    }

    public function removeImage(Request $request)
    {
        if(!\auth()->user()->ability('admin', 'delete_users')){
            return redirect('admin/index');
        }

        return $this->destroyUserImage($request->user_id);
    }
}
