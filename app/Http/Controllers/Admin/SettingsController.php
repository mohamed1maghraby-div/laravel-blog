<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Spatie\Valuestore\Valuestore;

class SettingsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!\auth()->user()->ability('admin', 'manage_settings,show_settings')){
            return redirect('admin/index');
        }

        $section = (isset(\request()->section) && \request()->section != '') ? \request()->section : 'general';
        $settings_setions = Setting::select('section')->distinct()->pluck('section');
        $settings = Setting::whereSection($section)->get();

        return view('admin.settings.index', compact('section', 'settings_setions', 'settings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        for($i=0; $i<count($request->id); $i++){
            $input['value'] = isset($request->value[$i]) ? $request->value[$i] : null;
            Setting::whereId($request->id[$i])->first()->update($input);
        }
        $this->generateCache();
        return redirect()->route('admin.settings.index')->with([
            'message' => 'Settings updated successfully',
            'alert-type' => 'success'
        ]);
    }

    private function generateCache()
    {
        $settings = Valuestore::make(config_path('settings.json'));
        Setting::all()->each(function ($item) use ($settings){
            $settings->put($item->key, $item->value);
        });
    }
}
