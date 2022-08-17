<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Traits\Admin\FiltersTrait;

class ContactUsController extends Controller
{
    use FiltersTrait;

    public function index()
    {
        if(!\auth()->user()->ability('admin', 'manage_contact_us,show_contact_us')){
            return redirect('admin/index');
        }

        $this->setFilters(request()->keyword, request()->status, request()->sort_by, request()->order_by, request()->limit_by);
        $messages = Contact::query();

        if($this->getKeyword() != null){
            $messages = $messages->search($this->getKeyword());
        }

        if($this->getStatus() != null){
            $messages = $messages->whereStatus($this->getStatus());
        }
        $messages = $messages->orderBy($this->getSortBy(), $this->getOrderBy())->paginate($this->getLimitBy());
        return view('admin.contact_us.index', compact('messages'));
    }

    public function show($id)
    {
        if(!\auth()->user()->ability('admin', 'display_contact_us')){
            return redirect('admin/index');
        }

        $message = Contact::whereId($id)->first();
        if($message && $message->status == 0){
            $message->status = 1;
            $message->save();
        }
        return view('admin.contact_us.show', compact('message'));
    }

    public function destroy($id)
    {
        if(!\auth()->user()->ability('admin', 'delete_contact_us')){
            return redirect('admin/index');
        }
        $message = Contact::whereId($id)->first();
        if($message){
            $message->delete();

            return redirect()->back()->with([
                'message' => 'Message deleted successfully',
                'alert-type' => 'success'
            ]);
        }
        return redirect()->back()->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger'
        ]);
    }
}
