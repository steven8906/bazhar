<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use App\Models\{Business};
use App\Helpers\General;

class BusinessController extends Controller
{

    public function index(){
        $business = Business::all();
        return Inertia::render('Business/index', ['business' => $business]);
    }

    public function save(Request $request){
        $fields = Validator::make($request->all(), [
            'name'              => 'required',
            'name_contact'      => 'required',
            'last_name_contact' => 'required',
            'nit'               => 'required',
            'phone'             => 'required',
            'address'           => 'required',
            'file'            => 'required|image',
        ]);

        if ($fields->fails()){
            return response()->json(['success'=> false, $fields->errors()]);
        }
        $name_img  = md5(time()) . '.' . $request->file->extension();
        $name_logo = $request->file->getClientOriginalName();
        $url_logo  = url('uploads/' . $name_img);
        $request->file->move(public_path('uploads'), $name_img);
        //$fields['name_logo'] = $name_logo;
        //$fields['url_logo']  = $url_logo;
        $model              = $fields->validated();
        $model['name_logo'] = $name_logo;
        $model['url_logo']  = $url_logo;
        Business::create($model);
        return response()->json(['success'=>true, 'data'=>Business::all()]);
    }

    public function edit(Request $request){
        $business = new Business();
        $model    = $request->only([
            'id',
            'name',
            'name_contact',
            'last_name_contact',
            'nit',
            'phone',
            'address',
        ]);
        $validate = Validator::make($model, [
            'name'              => 'required',
            'name_contact'      => 'required',
            'last_name_contact' => 'required',
            'nit'               => 'required',
            'phone'             => 'required',
            'address'           => 'required',
        ]);
        $item = $business->where('id', $model['id'])->first();
        $res  = $item->update($model);
        //return response()->setStatusCode(404);
        return response()->json(['success'=>$res, 'data' => $business->all()]);
    }
}
