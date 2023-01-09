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
        // return getgenerateCustomFile('wpdata.json');
        $dataLists = getgenerateCustomFile('wpdata.json');
        foreach($dataLists as $item){
            $json = new \stdClass;
            $json->fields = new \stdClass;
            //category
            $categoryRef = [];
            foreach($item->category as $category){
                $cateObj = new \stdClass;
                $cateObj->sys = new \stdClass;
                $cateObj->sys->type = "Link";
                $cateObj->sys->linkType = "Entry";
                switch($category){
                    case 'research':
                        $cateObj->sys->id = '3l6y4L0LBQ3WO0gDZbTcdN';
                        break;
                    case 'privacy':
                        $cateObj->sys->id = '6x6Hu9HD10xS1RVgRr1g93';
                        break;
                    case 'data-and-tech':
                        $cateObj->sys->id = '20cSGbk3xUXJAeL924bhE3';
                        break;
                    case 'creative':
                        $cateObj->sys->id = 'wU47nGJOS11QOsx34Ec8M';
                        break;
                    case 'business':
                        $cateObj->sys->id = '3MM9Y8CV9dlTmCEfxvjYKt';
                        break;
                    case 'binary-craft':
                        $cateObj->sys->id = '7dHUF3e7w2hlepZrYFqElu';
                        break;
                    case 'news':
                        $cateObj->sys->id = '3aYdoENwDP0ebNE5Tk0COA';
                        break;
                    case 'hidden':
                        $cateObj->sys->id = '52wT4E4qkJKz6WPAflRAsQ';
                        break;
                }
                array_push($categoryRef,$cateObj);
            }
            $json->fields->category = new \stdClass;
            $json->fields->category->{'en-US'} = $categoryRef;
            //tag
            $keywords = '';
            $json->metadata = new \stdClass;
            $json->metadata->tags = [];
            foreach($item->tags as $tag){
                $ctag = new \stdClass;
                $ctag->sys = new \stdClass;
                $ctag->sys->type = "Link";
                $ctag->sys->linkType = "Tag";
                $ctag->sys->id = $tag->id;
                array_push($json->metadata->tags,$ctag);
                if($keywords == ''){
                    $keywords = $tag->name;
                }else{
                    $keywords = $keywords.','.$tag->name;
                }
            }
            //pseudonym
            $json->fields->pseudonym = new \stdClass;
            $json->fields->pseudonym->{'en-US'} = [];
            $pseudonymObj = new \stdClass;
            $pseudonymObj->sys = new \stdClass;
            $pseudonymObj->sys->type = "Link";
            $pseudonymObj->sys->linkType = "Entry";
            $pseudonymObj->sys->id = '7vV7RldkauS1N38DFwyljf';
            array_push($json->fields->pseudonym->{'en-US'},$pseudonymObj);
            //thumbnail
            $json->fields->thumbnail = new \stdClass;
            $json->fields->thumbnail = createAssetLink('6ON2Fh4DxVmOh7VSkz3gYv');
            //mobile image
            $json->fields->mobileimage = new \stdClass;
            $json->fields->mobileimage = createAssetLink('5hQ4G7bHGJk2jWnMseH95H');
            $json->fields->title = new \stdClass;
            $json->fields->title->{'en-US'} = $item->title;
            $json->fields->slug = new \stdClass;
            $json->fields->slug->{'en-US'} = $item->slug;
            $json->fields->excerpt = new \stdClass;
            $json->fields->excerpt->{'en-US'} = $item->excerpt;
            $json->fields->heroimage = new \stdClass;
            $json->fields->heroimage->{'en-US'} = new \stdClass;
            $json->fields->heroimage = createAssetLink('3Xl0L4hqwT0GjBo815ouoQ');
            //og image
            $json->fields->ogimage = new \stdClass;
            $json->fields->ogimage = createAssetLink('3Xl0L4hqwT0GjBo815ouoQ');
            //og title
            $json->fields->ogtitle = new \stdClass;
            $json->fields->ogtitle->{'en-US'} = isset($item->seotitle)?$item->seotitle:'';
            //og description
            $json->fields->ogdescription = new \stdClass;
            $json->fields->ogdescription->{'en-US'} = isset($item->seodescription)?$item->seodescription:'';
            //keyword
            $json->fields->keyword = new \stdClass;
            $json->fields->keyword->{'en-US'} = $keywords;
            // content
            $contentArray = [];
            $contentJson = new \stdClass;
            $contentJson->content = $item->content;
            $contentJson->display = true;
            $contentJson->component = 'content';
            array_push($contentArray,$contentJson);
            $json->fields->content = new \stdClass;
            $json->fields->content->{'en-US'} = $contentArray;
            // reference
            $json->fields->reference = new \stdClass;
            $json->fields->reference->{'en-US'} = [];
            $json->fields->owner = new \stdClass;
            $json->fields->owner->{'en-US'} = 'editor@montivory.com';
            // echo $item->title."<br>";
            // $response = Http::withBody(json_encode($json), 'application/vnd.contentful.management.v1+json')
            // ->withHeaders([
            //     'X-Contentful-Content-Type' => 'content',
            //     'Content-Type' => 'application/vnd.contentful.management.v1+json'
            // ])
            // ->withToken(config('app.cmaaccesstoken'))
            // ->post(getCtUrl().'/entries');
            // $resObj = $response->object();
            // $response = Http::withHeaders([
            //     'X-Contentful-Version' => intval($resObj->sys->version)
            // ])
            // ->withToken(config('app.cmaaccesstoken'))
            // ->put(getCtUrl().'/entries/'.$resObj->sys->id.'/published');
        }


        // $xml=simplexml_load_file("/Applications/MAMP/htdocs/mtvradmin/public/files/readmontivory.xml") or die("Error: Cannot create object");
        // $dataArray = [];
        // $tagsArray = [];
        // $categoryArray = [];
        // foreach($xml as $key=>$value)
        // {
        //     $data = new \stdClass;
        //     $data->title = $value->title."";
        //     $data->slug = $value->post_name."";
        //     $data->excerpt = $value->excerpt."";
        //     $data->content = $value->content."";
        //     $data->category = [];
        //     $data->tags = [];
        //     foreach ($value->category as $category) {
        //         if($category['domain'] == 'category'){
        //             array_push($data->category,$category['nicename']."");
        //             array_push($categoryArray,$category['nicename']."");
        //         }else{
        //             $tag = new \stdClass;
        //             $tag->id = $category['nicename']."";
        //             $tag->name = $category."";
        //             array_push($data->tags,$tag);
        //             $found = false;
        //             foreach($tagsArray as $tags){
        //                 if($tag->id == $tags->id){
        //                     $found = true;
        //                     break;
        //                 }
        //             }
        //             if(!$found){
        //                 array_push($tagsArray,$tag);
        //             }
        //         }
        //     }
        //     foreach ($value->postmeta as $meta) {
        //         if($meta->meta_key."" == "mfn-meta-seo-title"){
        //             $data->seotitle = $meta->meta_value."";
        //         }
        //         if($meta->meta_key."" == "mfn-meta-seo-description"){
        //             $data->seodescription = $meta->meta_value."";
        //         }
        //     }
        //     array_push($dataArray,$data);
        // }
        // generateCustomFile('wpdata.json',$dataArray);
        // return $categoryArray;
        // return $tagsArray;
        // return $dataArray;
        // return getGenerateCustomFile('wptags.json');
    }
}
?>


