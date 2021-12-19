<?php

namespace App\Http\Controllers;

use App\Folder;

use Illuminate\Http\Request;
use App\Http\Requests\EditFolder;
use App\Http\Requests\CreateFolder;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{
    public function showCreateForm(){
        return view('folders/create');
    }
    
    public function create(CreateFolder $request){
        $folder = new Folder();
        $folder->title = $request->title;
        Auth::user()->folders()->save($folder);
        
        return redirect()->route('tasks.index',['id'=> $folder->id]);
    }

    public function showEditForm(int $id){
        $folder = Folder::find($id);
        return view('folders/edit', ['folder' => $folder]);
    }

    public function edit(EditFolder $request){
        $folder = Folder::find($request->id);
        $folder->title = $request->title;
        $folder->save();
        $id = $folder->id;
        return redirect()->route('tasks.index', ['id'=> $id]);
    }

    public function delete(int $id){
        Folder::where('id', $id)->delete();
        $folder_id = Folder::max('id');
        if(empty($folder_id)){
            return redirect()->route('folders.create');
        }else{
            return redirect()->route('tasks.index', ['id'=> $folder_id]);
        }
    }
    

}
