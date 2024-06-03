<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TagController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:tag-list', ['only' => 'index']);
        $this->middleware('permission:tag-create', ['only' => ['create','store']]);
        $this->middleware('permission:tag-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:tag-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $data['page_title'] = 'Category';
        $data['tags'] = Tag::orderby('position', 'asc')->get();

        return view('master-data.tag.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Create Category';
        $data['tag'] = Tag::orderBy('position', 'ASC')->get();

        return view('master-data.tag.create',$data);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'tag_name' => 'required',
            'status' => 'required',
            'position' => 'required',
        ]);

        try {
            $tag = new Tag();
            $tag->tag_name = $validateData['tag_name'];
            $tag->status = $validateData['status'];
            $tag->position = $validateData['position'];

            $tag->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Tag '.$tag->tag_nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('master-data.tags.index')->with(['success' => 'Tag added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('master-data.tags.index')->with(['failed' => 'Tag added failed! '.$th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Category';
        $data['tag'] = Tag::find($id);

        return view('master-data.tag.edit',$data);
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'tag_name' => 'required',
            'status' => 'required',
            'position' => 'required',
        ]);

        try {
            $tag = Tag::findOrFail($id);
            $tag->tag_name = $validateData['tag_name'];
            $tag->position = $validateData['position'];
            $tag->status = $validateData['status'];

            $tag->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Edit';
            $newHistoryLog->menu = 'Edit Tag '.$tag->tag_name;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('master-data.tags.index')->with(['success' => 'Tag edited successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('master-data.tags.index')->with(['failed' => 'Tag edited Failed! '. $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $tag = Tag::findOrFail($id);
            $tag->delete();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Delete';
            $newHistoryLog->menu = 'Delete Tag '.$tag->tag_nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();
        });

        Session::flash('success', 'Tag deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
