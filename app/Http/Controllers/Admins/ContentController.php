<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Content;
use Auth;


class ContentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admins.content.index');
    }

    public function new()
    {
        $content = new Content();
        $content->sortorder = Content::max('sortorder') + 1;
        return view('admins.content.form', [ 'content' => $content]);
    }

    public function edit($id)
    {
        return view('admins.content.form', [ 'content' => Content::find($id)]);
    }

    public function gallery($id)
    {
        return view('admins.content.gallery', [ 'content' => Content::find($id)]);
    }

    public function updategallery($id,Request $request){
        $content = Content::find($id);
        $galleryArray = array();
        if($request->image)
        {
            foreach ($request->image as $key=>$value)
            {
                $imageObject = new \stdClass;
                $imageObject->image = $request->image[$key];
                array_push($galleryArray,$imageObject);
            }
        }
        $content->gallery = json_encode($galleryArray);
        $content->save();
        return redirect()->route('contentindex')->with('success', 'Update gallery success!');
    }

    public function create(Request $request)
    {
        $content = new Content();
        $galleryArray = array();
        $content->gallery = json_encode($galleryArray);
        $this->updateDatabase($content, $request,'new');
        return redirect()->route('contentindex')->with('success', 'Content saved!');
    }

    public function update($id, Request $request)
    {
        $content = Content::find($id);
        $this->updateDatabase($content, $request,'edit');
        return redirect()->route('contentindex')->with('success', 'Content updated!');
    }

    public function updateDatabase(Content $content, Request $request,$mode)
    {
        if(!empty($request->image)){
            $content->image = $request->image;
        }
        if(!empty($request->ogimage)){
            $content->ogimage = $request->ogimage;
        }
        if(!empty($request->twitterimage)){
            $content->twitterimage = $request->twitterimage;
        }
        $content->title = $request->title;
        $content->alias = $request->alias;
        $content->author = $request->author;
        $content->position = $request->position;
        $content->shortdescription = ($request->shortdescription)?:'sample';
        $content->description = ($request->description)?:'sample';
        $content->contenttype = ($request->contenttype)?:'testimonial';
        $content->sortorder = $request->sortorder;
        $content->save();
    }

    public function delete($id, Request $request)
    {
        $content = Content::find($id)->delete();
        return ['result'=>true];
    }

    public function list(Request $request)
    {
        // https://shareurcodes.com/blog/laravel%20datatables%20server%20side%20processing
        $columns = array(
            0 => 'title',
            1 => 'sortorder',
        );

        $totalData = Content::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        $search = $request->input('search.value');

        $contents = Content::where('title', 'LIKE', "%{$search}%")
            ->where('contenttype',$request->input('type'))
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $totalFiltered = Content::where('title', 'LIKE', "%{$search}%")
            ->where('contenttype',$request->input('type'))
            ->count();

        $data = array();
        if (!empty($contents)) {
            foreach ($contents as $content) {
                $nestedData['id'] = $content->id;
                $nestedData['title'] = $content->title;
                $nestedData['sortorder'] = $content->sortorder;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        return $json_data;
    }
}
