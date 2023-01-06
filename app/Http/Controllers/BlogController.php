<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Response;

class BlogController extends Controller
{
    function index()
    {
        return view('blog');
    }

    function category($slug)
    {
        return view('category',['slug'=>$slug]);
    }

    function detail($slug)
    {
        return view('blogpost',['data'=>'','category'=>'binary-craft','categoryname'=>'Binary Craft']);
    }

    function tags($slug)
    {
        return view('tags');
    }

    function search($search)
    {
        return view('search',['data'=>["a","b"]]);
    }

    function noresult()
    {
        return view('search',['data'=>[]]);
    }

    function importblog() {
        $xml=simplexml_load_file("/Applications/MAMP/htdocs/mtvradmin/public/files/readmontivory.xml") or die("Error: Cannot create object");
        $dataArray = [];
        $tagsArray = [];
        $categoryArray = [];
        foreach($xml as $key=>$value)
        {
            $data = new \stdClass;
            $data->title = $value->title."";
            $data->slug = $value->post_name."";
            $data->excerpt = $value->excerpt."";
            $data->content = $value->content."";
            $data->category = [];
            $data->tags = [];
            foreach ($value->category as $category) {
                if($category['domain'] == 'category'){
                    array_push($data->category,$category['nicename']."");
                    array_push($categoryArray,$category['nicename']."");
                }else{
                    $tag = new \stdClass;
                    $tag->id = $category['nicename']."";
                    $tag->name = $category."";
                    array_push($data->tags,$tag);
                    $found = false;
                    foreach($tagsArray as $tags){
                        if($tag->id == $tags->id){
                            $found = true;
                            break;
                        }
                    }
                    if(!$found){
                        array_push($tagsArray,$tag);
                    }
                }
            }
            foreach ($value->postmeta as $meta) {
                if($meta->meta_key."" == "mfn-meta-seo-title"){
                    $data->seotitle = $meta->meta_value."";
                }
                if($meta->meta_key."" == "mfn-meta-seo-description"){
                    $data->seodescription = $meta->meta_value."";
                }
            }
            array_push($dataArray,$data);
        }
        // generateCustomFile('wpdata.json',$dataArray);
        return $categoryArray;
        return $tagsArray;
        return $dataArray;
        // return $xmldata->channel->item[0]->title;
        // for($x = 0; $x < count($arrOutput['item']); $x++) {
        //     $data = new \stdClass;
            // $data->title = $xml->channel->item[$x]->title;
            // $data->excerpt = $xml->channel->item[$x]->excerpt;
            // $data->content = $xml->channel->item[$x]->content;
            // $data->category = [];
            // foreach ($xml->channel->item[$x]->category as $category) {
            //     $catedata = new \stdClass;
            //     $catedata->nicename = $category->nicename;
            //     $catedata->domain = $category->domain;
            //     array_push($data->category,$catedata);
            // }
        //     array_push($dataArray,$data);
        // }
        // foreach ($arrOutput['item'] as $item) {
        //     print_r($item);

        // }
        // return $dataArray;
        // return $xml->channel->item[0]->title;
        // return $xml->channel->item[0]->excerpt;
        // return $xml->channel->item[0]->content;
        // return $xml->channel->item[0]->category['nicename'];
        // return $xml->channel->item[0]->category['domain'];
        // print_r($xml->channel->item[0]);
    }
}
?>


