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

    function blog($slug)
    {
        $data = [];
        $query = 'query positionCollectionQuery {
            positionCollection (
                where:
                    {
                        slug:"'.$alias.'"},
                limit:1
            ) {
                items {
                    sys {
                        id
                    }
                title,
                slug,
                thumbnail {
                  url
                },
                description,
                ogtitle,
                ogdescription,
                ogimage {
                  url
                },
                keyword
              }
            }
        }';
        $response = Http::withBody(json_encode([
            'query' => $query
        ]),'')
            ->withToken(config('app.cdaaccesstoken'))
            ->post(getCtGraphqlUrl());
        $resObj = $response->object();
        //footer
        $arrayquery = array("content_type"=>"pagecontent");
        $arrayquery['fields.session[in]'] = "footer";
        $arrayquery['limit'] = 1;
        $response = Http::withToken(config('app.cdaaccesstoken'))
        ->get(getCtCdaUrl().'/entries',$arrayquery);
        $result = $response->object();
        $page = new \stdClass;
        foreach($result->items as $item){
            switch($item->fields->session[0]){
                case 'footer':
                    $data = new \stdClass;
                    $data->special = $item->fields->special;
                    $data->content = $item->fields->content;
                    $page->footer = $data;
                    break;
            }
        }
        return view('careerdetail',['data'=>$page,'position'=>$resObj->data->positionCollection->items[0]]);
    }
}
?>


