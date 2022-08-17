<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\UserPermission;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupervisorRequest;
use App\Traits\Admin\FiltersTrait;
use App\Traits\ImagesManagerTrait;

class SupervisorsController extends Controller
{
    use FiltersTrait, ImagesManagerTrait;

    public function index()
    {
        if(!\auth()->user()->ability('admin', 'manage_supervisors,show_supervisors')){
            return redirect('admin/index');
        }

        $this->setFilters(request()->keyword, request()->status, request()->sort_by, request()->order_by, request()->limit_by);
        $users = User::whereHas('roles', function($query){
            $query->where('name', 'editor');
        });

        if($this->getKeyword() != null){
            $users = $users->search($this->getKeyword());
        }

        if($this->getStatus() != null){
            $users = $users->whereStatus($this->getStatus());
        }

        $users = $users->orderBy($this->getSortBy(), $this->getOrderBy())->paginate($this->getLimitBy());

        return view('admin.supervisors.index', compact('users'));
    }

    public function create()
    {
        if(!\auth()->user()->ability('admin', 'create_supervisors')){
            return redirect('admin/index');
        }
        $permissions = Permission::pluck('display_name', 'id');
        return view('admin.supervisors.create', compact('permissions'));
    }

    public function store(SupervisorRequest $request)
    {
        if(!\auth()->user()->ability('admin', 'create_supervisors')){
            return redirect('admin/index');
        }

        if($user_image = $request->file('user_image')){
            $data['user_image'] = $this->createUserImageUploade($user_image, $request->username);
        }else{
            $data['user_image'] = null;
        }

        $user = User::create(array_merge(
            $request->safe()->except('permissions'), 
            [
                'user_image' => $data['user_image']
            ]
        ));
        $user->attachRole(Role::whereName('editor')->first()->id);

        if(isset($request->permissions) && count($request->permissions) > 0){
            $user->permissions()->sync($request->permissions);
        }

        return redirect()->route('admin.supervisors.index')->with([
            'message' => 'Supervisor created successfully',
            'alert-type' => 'success'
        ]);
    }

    public function show($id)
    {
        if(!\auth()->user()->ability('admin', 'display_supervisors')){
            return redirect('admin/index');
        }

        $user = User::whereId($id)->first();
        if($user){
            return view('admin.supervisors.show', compact('user'));
        }
        return redirect()->route('admin.supervisors.index')->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger'
        ]);
    }

    public function edit($id)
    {
        if(!\auth()->user()->ability('admin', 'update_supervisors')){
            return redirect('admin/index');
        }

        $user = User::whereId($id)->first();
        if($user){
            $permission = Permission::pluck('display_name', 'id');
            $userPermissions = UserPermission::whereUserId($id)->pluck('permission_id');
            return view('admin.supervisors.edit', compact('user', 'permission', 'userPermissions'));
        }
        return redirect()->route('admin.supervisors.index')->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger'
        ]);
    }

    public function update(SupervisorRequest $request, $id)
    {
        if(!\auth()->user()->ability('admin', 'update_supervisors')){
            return redirect('admin/index');
        }

        $user = User::whereId($id)->first();
        if($user){
            if($request->file('user_image')){
                $user->update(
                    array_merge(
                        $request->validated(),
                        ['user_image' => $this->UserImageUploade($request->file('user_image'), $user->user_image, $user->username)]
                    ));
            }else{
                $user->update($request->validated());
            }
            
            if(isset($request->permissions) && count($request->permissions) > 0){
                $user->permissions()->sync($request->permissions);
            }

            return redirect()->route('admin.supervisors.index')->with([
                'message' => 'User updated successfully',
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.supervisors.index')->with([
            'message' => 'Something was wrong',
            'alert-type' => 'daner'
        ]);
    }

    public function destroy($id)
    {
        if(!\auth()->user()->ability('admin', 'delete_supervisors')){
            return redirect('admin/index');
        }

        $user = User::whereId($id)->first();

        if($user){
            $this->destroyUserMedia($user);
            $user->delete();

            return redirect()->route('admin.supervisors.index')->with([
                'message' => 'User deleted successfully',
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.supervisors.index')->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger'
        ]);
    }

    public function removeImage(Request $request)
    {
        if(!\auth()->user()->ability('admin', 'delete_supervisors')){
            return redirect('admin/index');
        }
        
        return $this->destroyUserImage($request->user_id);
    }
}
