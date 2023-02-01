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
        $data = new \stdClass;
        $data->herocontent = getCdaDataList([],1,1)->data;
        // return $this->getCdaDataList("",1,0);
        $excludeid = '';
        if(count($data->herocontent) > 0){
            $excludeid = $data->herocontent[0]->id;
        }
        $data->binarycrafts = getCdaDataList(["7dHUF3e7w2hlepZrYFqElu"],2,1,$excludeid)->data;
        $data->business = getCdaDataList(["3MM9Y8CV9dlTmCEfxvjYKt"],3,1,$excludeid)->data;
        $data->dataandtech = getCdaDataList(["20cSGbk3xUXJAeL924bhE3"],3,1,$excludeid)->data;
        $data->creative = getCdaDataList(["wU47nGJOS11QOsx34Ec8M"],3,1,$excludeid)->data;
        $data->privacy = getCdaDataList(["6x6Hu9HD10xS1RVgRr1g93"],3,1,$excludeid)->data;
        $data->research = getCdaDataList(["3l6y4L0LBQ3WO0gDZbTcdN"],3,1,$excludeid)->data;
        $data->trending = getCdaDataList(["7dHUF3e7w2hlepZrYFqElu"],6,1,$excludeid)->data;
        return view('blog',['data'=>$data]);
    }

    function category($slug,Request $request)
    {
        $currentPage = 1;
        $month = 0;
        $year = 0;
        if($request->page){
            $currentPage = $request->page;
        }
        if($request->month){
            $month = $request->month;
        }
        if($request->year){
            $year = $request->year;
        }
        $query = 'query categoryCollectionQuery {
            categoryCollection (
                where:
                    {
                        slug:"'.$slug.'"},
                limit:1
            ) {
                items {
                    sys {
                        id
                    }
                title,
                slug,
                banner {
                  url
                },
                ogdescription,
                ogimage {
                  url
                },
                keyword
              }
            }
        }';
        if(config('app.mockupdata')){
            $category = new \stdClass;
            $category->sys = new \stdClass;
            $category->sys->id = 'sample-id';
            $category->title = 'Binary Craft';
            $category->slug = $slug;
            $category->ogdescription = '';
            $category->keyword = '';
            $category->banner = new \stdClass;
            $category->banner->url = asset('images/default/cover-image.jpg');
            $category->ogimage = new \stdClass;
            $category->ogimage->url = asset('images/default/cover-image.jpg');
            $category->description = 'Description';
        }else{
            $response = Http::withBody(json_encode([
                'query' => $query
            ]),'')
                ->withToken(config('app.cdaaccesstoken'))
                ->post(getCtGraphqlUrl());
            $resObj = $response->object();
            $category = $resObj->data->categoryCollection->items[0];
            if(!isset($category->description)){
                $category->description = '';
            }
        }
        $data = getCdaDataList([$category->sys->id],12,$currentPage,'','','',$month,$year);
        return view('category',['category'=>$category,'data'=>$data,'page'=>buildPage($data->pages,$currentPage),'currentPage'=>$currentPage,'month'=>$month,'year'=>$year]);
    }

    function detail($slug)
    {
        $rawdata = getCdaData($slug);
        if($rawdata->total == 0){
            abort(404);
        }
        $data = $rawdata->data[0];
        $category = new \stdClass;
        $category->slug = $data->categoryslug;
        $category->title = $data->category;
        $category->url = $data->categoryurl;
        $relateds =  getCdaDataList([$data->categoryid],3,1,$data->id);
        return view('blogpost',['data'=>$data,'category'=>$category,'relateds'=>$relateds->data]);
    }

    function tags($slug,Request $request)
    {
        $currentPage = 1;
        $month = 0;
        $year = 0;
        $categoryArray = [];
        $categoryIdArray = [];
        if($request->category){
            $categoryArray = explode(',',$request->category);
            $category = $request->category;
            foreach(explode(',',$request->category) as $cateName){
                switch($cateName){
                    case 'binarycrafts':
                        array_push($categoryIdArray,"7dHUF3e7w2hlepZrYFqElu");
                        break;
                    case 'business':
                        array_push($categoryIdArray,"3MM9Y8CV9dlTmCEfxvjYKt");
                        break;
                    case 'data-and-tech':
                        array_push($categoryIdArray,"20cSGbk3xUXJAeL924bhE3");
                        break;
                    case 'creative':
                        array_push($categoryIdArray,"wU47nGJOS11QOsx34Ec8M");
                        break;
                    case 'privacy':
                        array_push($categoryIdArray,"6x6Hu9HD10xS1RVgRr1g93");
                        break;
                    case 'research':
                        array_push($categoryIdArray,"3l6y4L0LBQ3WO0gDZbTcdN");
                        break;
                    case 'trending':
                        array_push($categoryIdArray,"7dHUF3e7w2hlepZrYFqElu");
                        break;
                }
            }
        }
        if($request->page){
            $currentPage = $request->page;
        }
        if($request->month){
            $month = $request->month;
        }
        if($request->year){
            $year = $request->year;
        }
        $tags = new \stdClass;
        foreach(getGenerateCustomFile('tag.json')->items as $tag){
            if($tag->sys->id == $slug){
                $tags->id = $slug;
                $tags->name = $tag->name;
                break;
            }
        }
        $data = getCdaDataList($categoryIdArray,12,$currentPage,'',$slug,'',$month,$year);
        return view('tags',['tags'=>$tags,'data'=>$data,'page'=>buildPage($data->pages,$currentPage),'currentPage'=>$currentPage,'month'=>$month,'year'=>$year,'categoryfilter'=>$categoryArray]);
    }

    function search($search,Request $request)
    {
        $currentPage = 1;
        $month = 0;
        $year = 0;
        if($request->page){
            $currentPage = $request->page;
        }
        if($request->month){
            $month = $request->month;
        }
        if($request->year){
            $year = $request->year;
        }
        $categoryArray = [];
        $categoryIdArray = [];
        if($request->category){
            $categoryArray = explode(',',$request->category);
            $category = $request->category;
            foreach(explode(',',$request->category) as $cateName){
                switch($cateName){
                    case 'binarycrafts':
                        array_push($categoryIdArray,"7dHUF3e7w2hlepZrYFqElu");
                        break;
                    case 'business':
                        array_push($categoryIdArray,"3MM9Y8CV9dlTmCEfxvjYKt");
                        break;
                    case 'data-and-tech':
                        array_push($categoryIdArray,"20cSGbk3xUXJAeL924bhE3");
                        break;
                    case 'creative':
                        array_push($categoryIdArray,"wU47nGJOS11QOsx34Ec8M");
                        break;
                    case 'privacy':
                        array_push($categoryIdArray,"6x6Hu9HD10xS1RVgRr1g93");
                        break;
                    case 'research':
                        array_push($categoryIdArray,"3l6y4L0LBQ3WO0gDZbTcdN");
                        break;
                    case 'trending':
                        array_push($categoryIdArray,"7dHUF3e7w2hlepZrYFqElu");
                        break;
                }
            }
        }
        $data = getCdaDataList($categoryIdArray,12,1,'','',$search,$month,$year);
        $relateds = new \stdClass;
        $tags = [];
        if($data->total == 0){
            $relateds =  getCdaDataList([],3,1,'','');
            $tags = randomTags(6);
        }
        return view('search',['search'=>$search,'data'=>$data,'page'=>buildPage($data->pages,$currentPage),'currentPage'=>$currentPage,'relateds'=>$relateds,'tags'=>$tags,'month'=>$month,'year'=>$year,'categoryfilter'=>$categoryArray]);
    }

    function noresult()
    {
        return view('search',['data'=>[]]);
    }

    function generateCsvFile($filename,$data) {
        if (!file_exists(public_path('/assets/data/'))) {
            mkdir(public_path('/assets/data/'), 0777, true);
        }
        $fp = fopen(public_path('/assets/data/') . $filename,"wb");
        fwrite($fp,$data);
        fclose($fp);
    }

    function generateFBData() {
        $dataLists = getgenerateCustomFile('fb.json');
        $dataArray = "id|authorId|authorName|authorUrl|comments|commentsSentimentPositive|commentsSentimentNeutral|commentsSentimentNegative|contentType|createdTime|deleted|hidden|interactions|interactionsPerkFans|mediaType|origin|pageId|pageName|pageUrl|postAttributionStatus|postAttributionType|postLabels|profileId|published|reactions|reactionsAnger|reactionsHaha|reactionsLike|reactionsLove|reactionsSorry|reactionsWow|sentiment|shares|spam|url|video|content\n";
        foreach($dataLists->data->posts as $item){
            $textcsv = $item->id;
            $textcsv = $textcsv.'|'.$item->authorId;
            $textcsv = $textcsv.'|'.$item->author->name;
            $textcsv = $textcsv.'|'.$item->author->url;
            $textcsv = $textcsv.'|'.$item->comments;
            $textcsv = $textcsv.'|'.$item->comments_sentiment->positive;
            $textcsv = $textcsv.'|'.$item->comments_sentiment->neutral;
            $textcsv = $textcsv.'|'.$item->comments_sentiment->negative;
            $textcsv = $textcsv.'|'.$item->content_type;
            $textcsv = $textcsv.'|'.$item->created_time;
            $textcsv = $textcsv.'|'.$item->deleted;
            $textcsv = $textcsv.'|'.$item->hidden;
            $textcsv = $textcsv.'|'.$item->interactions;
            $textcsv = $textcsv.'|'.$item->interactions_per_1k_fans;
            $textcsv = $textcsv.'|'.$item->media_type;
            $textcsv = $textcsv.'|'.$item->origin;
            $textcsv = $textcsv.'|'.$item->page->id;
            $textcsv = $textcsv.'|'.$item->page->name;
            $textcsv = $textcsv.'|'.$item->page->url;
            $textcsv = $textcsv.'|'.$item->post_attribution->status;
            $textcsv = $textcsv.'|'.$item->post_attribution->type;
            $textcsv = $textcsv.'|'.json_encode($item->post_labels);
            $textcsv = $textcsv.'|'.$item->profileId;
            $textcsv = $textcsv.'|'.$item->published;
            $textcsv = $textcsv.'|'.$item->reactions;
            $textcsv = $textcsv.'|'.$item->reactions_by_type->anger;
            $textcsv = $textcsv.'|'.$item->reactions_by_type->haha;
            $textcsv = $textcsv.'|'.$item->reactions_by_type->like;
            $textcsv = $textcsv.'|'.$item->reactions_by_type->love;
            $textcsv = $textcsv.'|'.$item->reactions_by_type->sorry;
            $textcsv = $textcsv.'|'.$item->reactions_by_type->wow;
            $textcsv = $textcsv.'|'.$item->sentiment;
            $textcsv = $textcsv.'|'.$item->shares;
            $textcsv = $textcsv.'|'.$item->spam;
            $textcsv = $textcsv.'|'.$item->url;
            $textcsv = $textcsv.'|'.json_encode($item->video);
            $textcsv = $textcsv.'|'.str_replace("\n","",$item->content)."\n";
            $dataArray = $dataArray.$textcsv;
            // $dataArray = $dataArray.",".$item->content."\n";
        }
        $this->generateCsvFile('fbdata.csv',$dataArray);
    }

    function generateInstagramData() {
        $dataLists = getgenerateCustomFile('instagram.json');
        $dataArray = "id|authorId|authorName|authorUrl|comments|commentsSentimentPositive|commentsSentimentNeutral|commentsSentimentNegative|contentType|createdTime|interactions|interactionsPerkFans|likes|mediaType|pageId|pageName|pageUrl|postAttribution|postLabels|profileId|sentiment|url|attachments|content\n";
        foreach($dataLists->data->posts as $item){
            $textcsv = $item->id;
            $textcsv = $textcsv.'|'.$item->authorId;
            $textcsv = $textcsv.'|'.$item->author->name;
            $textcsv = $textcsv.'|'.$item->author->url;
            $textcsv = $textcsv.'|'.$item->comments;
            $textcsv = $textcsv.'|'.$item->comments_sentiment->positive;
            $textcsv = $textcsv.'|'.$item->comments_sentiment->neutral;
            $textcsv = $textcsv.'|'.$item->comments_sentiment->negative;
            $textcsv = $textcsv.'|'.$item->content_type;
            $textcsv = $textcsv.'|'.$item->created_time;
            $textcsv = $textcsv.'|'.$item->interactions;
            $textcsv = $textcsv.'|'.$item->interactions_per_1k_fans;
            $textcsv = $textcsv.'|'.$item->likes;
            $textcsv = $textcsv.'|'.$item->media_type;
            $textcsv = $textcsv.'|'.$item->page->id;
            $textcsv = $textcsv.'|'.$item->page->name;
            $textcsv = $textcsv.'|'.$item->page->url;
            $textcsv = $textcsv.'|'.$item->post_attribution;
            $textcsv = $textcsv.'|'.json_encode($item->post_labels);
            $textcsv = $textcsv.'|'.$item->profileId;
            $textcsv = $textcsv.'|'.$item->sentiment;
            $textcsv = $textcsv.'|'.$item->url;
            $textcsv = $textcsv.'|'.json_encode($item->attachments);
            $textcsv = $textcsv.'|'.str_replace("\n","",$item->content)."\n";
            $dataArray = $dataArray.$textcsv;
        }
        $this->generateCsvFile('instagramdata.csv',$dataArray);
    }

    function generateYoutubeData() {
        $dataLists = getgenerateCustomFile('youtube.json');
        $dataArray = "id|authorId|authorName|authorUrl|channelId|channelName|channelUrl|comments|createdTime|dislikes|duration|insightsEngagement|interactions|interactionsPerkFans|likes|mediaType|profileId|url|videoViewTime|video_views|post_labels|description\n";
        foreach($dataLists->data->posts as $item){
            $textcsv = $item->id;
            $textcsv = $textcsv.'|'.$item->authorId;
            $textcsv = $textcsv.'|'.$item->author->name;
            $textcsv = $textcsv.'|'.$item->author->url;
            $textcsv = $textcsv.'|'.$item->channel->id;
            $textcsv = $textcsv.'|'.$item->channel->name;
            $textcsv = $textcsv.'|'.$item->channel->url;
            $textcsv = $textcsv.'|'.$item->comments;
            $textcsv = $textcsv.'|'.$item->created_time;
            $textcsv = $textcsv.'|'.$item->dislikes;
            $textcsv = $textcsv.'|'.$item->duration;
            $textcsv = $textcsv.'|'.$item->insights_engagement;
            $textcsv = $textcsv.'|'.$item->interactions;
            $textcsv = $textcsv.'|'.$item->interactions_per_1k_fans;
            $textcsv = $textcsv.'|'.$item->likes;
            $textcsv = $textcsv.'|'.$item->media_type;
            $textcsv = $textcsv.'|'.$item->profileId;
            $textcsv = $textcsv.'|'.$item->url;
            $textcsv = $textcsv.'|'.$item->video_view_time;
            $textcsv = $textcsv.'|'.$item->video_views;
            $textcsv = $textcsv.'|'.json_encode($item->post_labels);
            $textcsv = $textcsv.'|'.str_replace("\n","",$item->description)."\n";
            $dataArray = $dataArray.$textcsv;
        }
        $this->generateCsvFile('youtubedata.csv',$dataArray);
        return true;
    }

    function generateTwitterData() {
        $dataLists = getgenerateCustomFile('twitter.json');
        $dataArray = "id|origin|postLabels|profile|profileId\n";
        foreach($dataLists->data->posts as $item){
            $textcsv = $item->id;
            $textcsv = $textcsv.'|'.$item->origin;
            $textcsv = $textcsv.'|'.json_encode($item->post_labels);
            $textcsv = $textcsv.'|'.$item->profile->id;
            $textcsv = $textcsv.'|'.$item->profileId."\n";
            $dataArray = $dataArray.$textcsv;
        }
        $this->generateCsvFile('twitterdata.csv',$dataArray);
        return true;
    }

    function importblog() {
        // return $this->generateTwitterData();
    }
}
?>


