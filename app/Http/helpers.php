<?php
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

function authuser() {
    $user = session('user');
    if($user)
    {
        return $user;
    }
    if(config('app.mockauth')) {
        $user = new \stdClass;
        $user->id = 'id-mockup';
        $user->email = 'email@mockup.com';
        $user->password = 'passwordmockup';
        $user->role = config('app.mockauthrole');
        $user->firstname = 'firstnamemockup';
        $user->lastname = 'lastnamemockup';
        $pseudonyms = new \stdClass;
        $pseudonyms->id = 'pseudonyms-id-mock';
        $pseudonyms->version = 1;
        $pseudonyms->name = 'pseudonyms-name-mock';
        $pseudonyms->title = config('app.pseudonymtitle');
        $pseudonyms->user = 'id-mockup';
        $pseudonyms->description = 'mockup description';
        $pseudonyms->default = true;
        $pseudonyms->imageid = config('app.defaultimage');
        $pseudonyms->imageversion = '1';
        $pseudonyms->image = config('app.defaultimageurl');
        $user->pseudonyms = [$pseudonyms];
        return $user;
    }
}

function getProfile($id) {
    $response = Http::withToken(config('app.cmaaccesstoken'))
    ->get(getCtUrl().'/entries/'.$id);
    $user = $response->object();
    $result = new \stdClass;
    $result->id = $user->sys->id;
    $result->email = $user->fields->email->{'en-US'};
    $result->password = $user->fields->password->{'en-US'};
    $result->role = $user->fields->role->{'en-US'};
    $result->firstname = $user->fields->firstname->{'en-US'};
    $result->lastname = $user->fields->lastname->{'en-US'};
    $result->pseudonyms = getPseudonym($id,true,false);
    $result->permission = [];
    $categories = getCategory();
    $userPermission = [];
    if(isset($user->fields->permission->{'en-US'})){
        foreach($user->fields->permission->{'en-US'} as $permission){
            foreach($categories as $category){
                $usePermission = false;
                foreach($category->category as $item){
                    if($item == $permission->sys->id){
                        $usePermission = true;
                        break;
                    }
                }
                if($usePermission){
                    array_push($result->permission,$category);
                }
            }
        }
    }
    session(['user' => $result]);
    return $result;
}

function getCtCdaUrl(){
    return 'https://'.config('app.cdaurl').'/spaces/'.config('app.spaceid').'/environments/'.config('app.ctenv');
}

function getCtUrl(){
    return 'https://'.config('app.cmaurl').'/spaces/'.config('app.spaceid').'/environments/'.config('app.ctenv');
}

function getCtGraphqlUrl(){
    return 'https://'.config('app.graphqlurl').'/content/v1/spaces/'.config('app.spaceid').'/environments/'.config('app.ctenv');
}

if (! function_exists('generateuuid')) {
    function generateuuid(){
        return $uuid = str_replace("-","",Str::uuid()->toString());
    }
}

function generateCustomFile($filename,$data) {
    if (!file_exists(public_path('/assets/data/'))) {
        mkdir(public_path('/assets/data/'), 0777, true);
    }
    $fp = fopen(public_path('/assets/data/') . $filename,"wb");
    fwrite($fp,json_encode($data));
    fclose($fp);
}

function getGenerateCustomFile($filename) {
    if(file_exists(public_path('/assets/data/') . $filename)){
        $ptObject = json_decode(file_get_contents(public_path('/assets/data/') . $filename));
        return $ptObject;
    }
    return NULL;
}

function generateCategory() {
    $arrayquery = array("content_type"=>"category");
    $arrayquery['order'] = 'fields.categoryorder';
    $response = Http::withToken(config('app.cmaaccesstoken'))
    ->get(getCtUrl().'/entries',$arrayquery);
    generateCustomFile('category.json',$response->object());
}

function generateSkill() {
    $arrayquery = array("content_type"=>"skillInterests");
    $arrayquery['limit'] = 1;
    $response = Http::withToken(config('app.cmaaccesstoken'))
    ->get(getCtUrl().'/entries',$arrayquery);
    generateCustomFile('skill.json',$response->object());
}

function getSkill() {
    $data = getGenerateCustomFile('skill.json');
    if($data){
        $resObj = getGenerateCustomFile('skill.json');
    }else{
        generateSkill();
        $resObj = getGenerateCustomFile('skill.json');
    }
    $result = new \stdClass;
    $result->skills = [];
    $result->interests = [];
    if(count($resObj->items) > 0){
        $result->skills = $resObj->items[0]->fields->skills->{'en-US'};
        $result->interests = $resObj->items[0]->fields->interests->{'en-US'};
    }
    return $result;
}

function generateTags() {
    $arrayquery = array("name[nin]"=>"profileimage");
    $arrayquery['limit'] = 500;
    $response = Http::withToken(config('app.cmaaccesstoken'))
    ->get(getCtUrl().'/tags',$arrayquery);
    generateCustomFile('tag.json',$response->object());
}

function getTags() {
    $data = getGenerateCustomFile('tag.json');
    if($data){
        $resObj = getGenerateCustomFile('tag.json');
    }else{
        generateTags();
        $resObj = getGenerateCustomFile('tag.json');
    }
    $result = [];
    foreach($resObj->items as $tag){
        $tagObj = new \stdClass;
        $tagObj->id = $tag->sys->id;
        $tagObj->name = $tag->name;
        array_push($result,$tagObj);
    }
    return $result;
}

function generateRole() {
    $arrayquery = array("content_type"=>"role");
    $response = Http::withToken(config('app.cmaaccesstoken'))
    ->get(getCtUrl().'/entries',$arrayquery);
    $resultObj = $response->object();
    $result = [];
    foreach($resultObj->items as $item){
        $role = new \stdClass;
        $role->id = $item->sys->id;
        $role->name = $item->fields->name->{'en-US'};
        array_push($result,$role);
    }
    generateCustomFile('roles.json',$result);
}

function generatePseudonym(){
    $allArray = [];
    //get default user
    $defaultarrayquery = array("content_type"=>"user");
    $defaultarrayquery['fields.default'] = true;
    $defaultarrayquery['limit'] = 1000;
    $response = Http::withToken(config('app.cmaaccesstoken'))
    ->get(getCtUrl().'/entries',$defaultarrayquery);
    $uresponse = $response->object();
    $alluser = '';
    foreach($uresponse->items as $user){
        if(!empty($alluser)){
            $alluser = $alluser.',';
        }
        $alluser = $alluser.$user->sys->id;
    }
    $pseudonymarrayquery = array("content_type"=>"pseudonym");
    $pseudonymarrayquery['fields.user.sys.id[in]'] = $alluser;
    $pseudonymarrayquery['limit'] = 1000;
    $response = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/entries',$pseudonymarrayquery);
    $resObj = $response->object();
    foreach($resObj->items as $item){
        $pseddonym = new \stdClass;
        $pseddonym->id = $item->sys->id;
        $pseddonym->version = $item->sys->version;
        foreach($uresponse->items as $user){
            if($user->sys->id == $item->fields->user->{'en-US'}->sys->id){
                $pseddonym->email = $user->fields->email->{'en-US'};
                break;
            }
        }
        $pseddonym->name = $item->fields->name->{'en-US'};
        $pseddonym->title = isset($item->fields->title->{'en-US'})?$item->fields->title->{'en-US'}:'';
        $pseddonym->description = isset($item->fields->description->{'en-US'})?$item->fields->description->{'en-US'}:'';
        $pseddonym->default = isset($item->fields->default->{'en-US'})?$item->fields->default->{'en-US'}:true;
        $pseddonym->imageid = '';
        $pseddonym->imageversion = 0;
        $pseddonym->image = '';
        if(isset($item->fields->profileimage)){
            $assetresponse = Http::withToken(config('app.cmaaccesstoken'))
            ->get(getCtUrl().'/assets/'.$item->fields->profileimage->{'en-US'}->sys->id);
            $assetObj = $assetresponse->object();
            $pseddonym->imageid = $assetObj->sys->id;
            $pseddonym->imageversion = $assetObj->sys->version;
            $pseddonym->image = 'https:'.$assetObj->fields->file->{'en-US'}->url;
        }
        array_push($allArray,$pseddonym);
    }
    generateCustomFile('pseddonym.json',$allArray);
}

if (! function_exists('getCategory')) {
    function getCategory($exceptid = '') {
        if(!file_exists(public_path('/assets/data/') . "category.json")){
            generateCategory();
        }
        $ptObject = getGenerateCustomFile('category.json');
        return categoryRecursive($ptObject->items,$exceptid);
    }
}

if (! function_exists('categoryRecursive')) {
    function categoryRecursive($categories,$exceptid){
        $result = [];
        foreach($categories as $category)
        {
            if (!property_exists($category->fields, 'parent'))
            {
                if($exceptid != $category->sys->id){
                    $categorypath = [];
                    $cateObj = new \stdClass;
                    $cateObj->id = $category->sys->id;
                    $cateObj->name = $category->fields->title->{'en-US'};
                    array_push($categorypath,$category->sys->id);
                    $cateObj->category = $categorypath;
                    array_push($result,$cateObj);
                    $result = categoryRecursiveParent($result,$categories,$category->fields->title->{'en-US'},$category->sys->id,$categorypath,$exceptid);
                }
            }
        }
        return $result;
    }
}

if (! function_exists('categoryRecursiveParent')) {
    function categoryRecursiveParent($result,$categories,$name,$id,$categorypath,$exceptid){
        foreach($categories as $category)
        {
            if (property_exists($category->fields, 'parent') && ($category->fields->parent->{'en-US'}[0]->sys->id == $id))
            {
                if($exceptid != $category->sys->id){
                    $catePath = $categorypath;
                    array_push($catePath,$category->sys->id);
                    $cateObj = new \stdClass;
                    $cateObj->id = $category->sys->id;
                    $cateObj->name = $category->fields->title->{'en-US'};
                    $cateObj->category = $catePath;
                    $catename = '';
                    if($name <> '')
                    {
                        $catename = $name.' > '.$category->fields->title->{'en-US'};
                    }else{
                        $catename = $category->fields->title->{'en-US'};
                    }
                    $cateObj->name = $catename;
                    array_push($result,$cateObj);
                    $result = categoryRecursiveParent($result,$categories,$category->fields->title->{'en-US'},$category->sys->id,$catePath,$exceptid);
                }
            }
        }
        return $result;
    }
}

if (! function_exists('getPseudonym')) {
    function getPseudonym($user = '',$fimage = false,$defaultpenname = true) {
        $result = [];
        if($defaultpenname){
            if(!file_exists(public_path('/assets/data/') . "pseddonym.json")){
                generatePseudonym();
            }
            $all = getGenerateCustomFile('pseddonym.json');
            foreach($all as $item){
                $pseddonym = new \stdClass;
                $pseddonym->id = $item->id;
                $pseddonym->version = $item->version;
                $pseddonym->name = $item->name;
                $pseddonym->title = $item->title;
                $pseddonym->email = $item->email;
                $pseddonym->description = $item->description;
                $pseddonym->default = $item->default;
                $pseddonym->imageid = $item->imageid;
                $pseddonym->imageversion = $item->imageversion;
                $pseddonym->image = $item->image;
                array_push($result,$pseddonym);
            }
        }else{
            if(empty($user))
            {
                foreach($all as $item){
                    $pseddonym = new \stdClass;
                    $pseddonym->id = $item->id;
                    $pseddonym->version = $item->version;
                    $pseddonym->email = $item->email;
                    $pseddonym->name = $item->name;
                    $pseddonym->title = $item->title;
                    $pseddonym->description = $item->description;
                    $pseddonym->default = $item->default;
                    $pseddonym->imageid = $item->imageid;
                    $pseddonym->imageversion = $item->imageversion;
                    $pseddonym->image = $item->image;
                    array_push($result,$pseddonym);
                }
            }else{
                $allArray = [];
                $response = Http::withToken(config('app.cmaaccesstoken'))
                ->get(getCtUrl().'/entries',[
                    'content_type'=>'pseudonym',
                    'fields.user.sys.id'=>$user,
                    'limit'=>1000
                ]);
                $resObj = $response->object();
                foreach($resObj->items as $item){
                    $pseddonym = new \stdClass;
                    $pseddonym->id = $item->sys->id;
                    $pseddonym->version = $item->sys->version;
                    $pseddonym->name = $item->fields->name->{'en-US'};
                    $pseddonym->title = isset($item->fields->title->{'en-US'})?$item->fields->title->{'en-US'}:'';
                    $pseddonym->description = isset($item->fields->description->{'en-US'})?$item->fields->description->{'en-US'}:'';
                    $pseddonym->default = isset($item->fields->default->{'en-US'})?$item->fields->default->{'en-US'}:true;
                    $pseddonym->imageid = '';
                    $pseddonym->imageversion = 0;
                    $pseddonym->image = '';
                    if(isset($item->fields->profileimage)){
                        $assetresponse = Http::withToken(config('app.cmaaccesstoken'))
                        ->get(getCtUrl().'/assets/'.$item->fields->profileimage->{'en-US'}->sys->id);
                        $assetObj = $assetresponse->object();
                        $pseddonym->imageid = $assetObj->sys->id;
                        $pseddonym->imageversion = $assetObj->sys->version;
                        $pseddonym->image = 'https:'.$assetObj->fields->file->{'en-US'}->url;
                    }
                    array_push($result,$pseddonym);
                }
            }
        }
        return $result;
    }
}

if (! function_exists('getRole')) {
    function getRole() {
        // if(!file_exists(public_path('/assets/data/') . "roles.json")){
        //     generateRole();
        // }
        // return getGenerateCustomFile('roles.json');
        $result = [];
        $role = new \stdClass;
        $role->id = 'admin';
        $role->name = 'admin';
        array_push($result,$role);
        $role = new \stdClass;
        $role->id = 'editor';
        $role->name = 'editor';
        array_push($result,$role);
        $role = new \stdClass;
        $role->id = 'author';
        $role->name = 'author';
        array_push($result,$role);
        return $result;
    }
}

function getImageById($id,$refsAsset) {
    $data = new \stdClass;
    $data->thumbnailid = '';
    $data->thumbnail = '';
    try {
        foreach($refsAsset as $ref){
            if($ref->sys->id == $id->{'en-US'}->sys->id){
                $data->thumbnailid = $id->{'en-US'}->sys->id;
                $data->thumbnail = 'https:'.$ref->fields->file->{'en-US'}->url;
                break;
            }
        }
    } catch (Exception $e) {}
    return $data;
}

function getImageByIdCda($id,$refsAsset) {
    $data = new \stdClass;
    $data->thumbnailid = '';
    $data->thumbnail = '';
    try {
        foreach($refsAsset as $ref){
            if($ref->sys->id == $id){
                $data->thumbnailid = $id;
                $data->thumbnail = 'https:'.$ref->fields->file->url;
                break;
            }
        }
    } catch (Exception $e) {}
    return $data;
}

function createAssetLink($id) {
    $result = new \stdClass;
    $result->{'en-US'} = new \stdClass;
    $result->{'en-US'}->sys = new \stdClass;
    $result->{'en-US'}->sys->type = "Link";
    $result->{'en-US'}->sys->linkType = "Asset";
    $result->{'en-US'}->sys->id = $id;
    return $result;
}

function getCdaDataList($categoryId,$limit,$page,$excludeid = '',$tag = '',$search = '',$month = 0,$year = 0){
    $page = ($page - 1) * $limit;
    $result = new \stdClass;
    $result->total = 0;
    $result->data = [];
    if(config('app.mockupdata')){
        $result->total = 50;
        for($x = 1;$x <= $limit;$x++){
            $itemObj = new \stdClass;
            $itemObj->id = 'sample-id';
            $itemObj->title = "Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article";
            $itemObj->slug = "article-sample";
            $itemObj->url = route('blogpost',['slug'=>'article-sample']);
            $itemObj->thumbnail = asset('images/default/Thumnail.png');
            $itemObj->mobileimage = asset('images/default/Thumbnail-Mobile.png');
            $itemObj->heroimage = asset('images/default/Hero-Banner.png');
            $itemObj->category = 'Binary Craft';
            $itemObj->categoryslug = 'binary-craft';
            $itemObj->categoryurl = route('category',['slug'=>'binary-craft']);
            $itemObj->createAt = "01 Jan 2023";
            $itemObj->ogimage = asset('images/default/Hero-Banner.png');
            $itemObj->ogtitle = 'ท่อนหนึ่งของ Lorem Ipsum ที่ใช้กันเป็นมาตรฐานมาตั้งแต่ศตวรรษที่ 16';
            $itemObj->ogdescription = 'Lorem Ipsum คือ เนื้อหาจำลองแบบเรียบๆ ที่ใช้กันในธุรกิจงานพิมพ์หรืองานเรียงพิมพ์ มันได้กลายมาเป็นเนื้อหาจำลองมาตรฐานของธุรกิจดังกล่าวมาตั้งแต่ศตวรรษที่ 16';
            array_push($result->data,$itemObj);
        }
    }else{
        $contentarrayquery = array("content_type"=>"content");
        $contentarrayquery['select'] = "sys.id,sys.createdAt,fields.title,fields.slug,fields.thumbnail,fields.heroimage,fields.mobileimage,fields.category";
        if($categoryId <> ''){
            $contentarrayquery['fields.category.sys.id'] = $categoryId;
        }
        if($excludeid <> ''){
            $contentarrayquery['sys.id[nin]'] = $excludeid;
        }
        if($tag <> ''){
            $contentarrayquery['metadata.tags.sys.id[all]'] = $tag;
        }
        if($search <> ''){
            $contentarrayquery['fields.title[match]'] = $search;
        }
        // $start = '';
        // if(($year <> 0) && ($month <> 0)){
        //     if(($year <> 0) && ($month == 0)){
        //         $start = $year.'-01-01T00:00:00Z';
        //         $end = ($year+1).'-01-01T00:00:00Z';
        //     }
        //     if(($year == 0) && ($month <> 0)){
        //         if($month > 9){
        //             $start = '2019-'.$month.'-01T00:00:00Z';
        //         }else{
        //             $start = '2019-0'.$month.'-01T00:00:00Z';
        //         }
        //     }
        //     if(($year <> 0) && ($month <> 0)){
        //         if($month > 9){
        //             $start = $year.'-'.$month.'-01T00:00:00Z';
        //             $end = ($year+1).'-'.$month.'-01T00:00:00Z';
        //         }else{
        //             $start = '2019-0'.$month.'-01T00:00:00Z';
        //         }
        //     }
        // }
        // 2013-01-01T00:00:00Z


        $contentarrayquery['limit'] = $limit;
        $contentarrayquery['skip'] = $page;
        $contentresponse = Http::withToken(config('app.cdaaccesstoken'))
        ->get(getCtCdaUrl().'/entries',$contentarrayquery);
        $contentresult = $contentresponse->object();
        // $contentAsset = $contentresult->includes->Asset;
        $result->total = $contentresult->total;
        foreach($contentresult->items as $item){
            $itemObj = new \stdClass;
            $itemObj->id = $item->sys->id;
            $itemObj->title = $item->fields->title;
            $itemObj->slug = $item->fields->slug;
            $itemObj->url = route('blogpost',['slug'=>$item->fields->slug]);
            //thumbnail
            $imgResult = getImageByIdCda($item->fields->thumbnail->sys->id,$contentresult->includes->Asset);
            $itemObj->thumbnail = $imgResult->thumbnail;
            //hero
            $imgResult = getImageByIdCda($item->fields->heroimage->sys->id,$contentresult->includes->Asset);
            $itemObj->heroimage = $imgResult->thumbnail;
            //mobile
            if(isset($item->fields->mobileimage)){
                $imgMobileResult = getImageByIdCda($item->fields->mobileimage->sys->id,$contentresult->includes->Asset);
                $itemObj->mobileimage = $imgMobileResult->thumbnail;
            }else{
                $itemObj->mobileimage = $itemObj->thumbnail;
            }
            foreach($contentresult->includes->Entry as $entry) {
                if($entry->sys->id == $item->fields->category[0]->sys->id){
                    $itemObj->category = $entry->fields->title;
                    $itemObj->categoryslug = $entry->fields->slug;
                    $itemObj->categoryurl = route('category',['slug'=>$entry->fields->slug]);
                    break;
                }
            }
            $createAt = explode(".",$item->sys->createdAt);
            $dt = date_create_from_format('Y-m-d\TH:i:s', $createAt[0]);
            date_add($dt,date_interval_create_from_date_string("7 hours"));
            $itemObj->createAt = date_format($dt,"d M Y");
            array_push($result->data,$itemObj);
        }
    }
    if($result->total < $limit) {
        $result->pages = 1;
    }else{
        $result->pages = ceil($result->total/$limit);
    }
    return $result;
}

function getCdaData($slug){
    $tags = getGenerateCustomFile('tag.json');
    $result = new \stdClass;
    $result->total = 0;
    $result->data = [];
    if(config('app.mockupdata')){
        $result->total = 1;
        for($x = 1;$x <= 1;$x++){
            $itemObj = new \stdClass;
            $itemObj->id = 'sample-id';
            $itemObj->title = "Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article";
            $itemObj->slug = "article-sample";
            $itemObj->url = route('blogpost',['slug'=>'article-sample']);
            $itemObj->thumbnail = asset('images/default/Thumnail.png');
            $itemObj->mobileimage = asset('images/default/Thumbnail-Mobile.png');
            $itemObj->heroimage = asset('images/default/Hero-Banner.png');
            $itemObj->categoryid = 'sample-cate-id';
            $itemObj->category = 'Binary Craft';
            $itemObj->categoryslug = 'binary-craft';
            $itemObj->categoryurl = route('category',['slug'=>'binary-craft']);
            $itemObj->ogimage = asset('images/default/Hero-Banner.png');
            $itemObj->ogtitle = 'ท่อนหนึ่งของ Lorem Ipsum ที่ใช้กันเป็นมาตรฐานมาตั้งแต่ศตวรรษที่ 16';
            $itemObj->ogdescription = 'Lorem Ipsum คือ เนื้อหาจำลองแบบเรียบๆ ที่ใช้กันในธุรกิจงานพิมพ์หรืองานเรียงพิมพ์ มันได้กลายมาเป็นเนื้อหาจำลองมาตรฐานของธุรกิจดังกล่าวมาตั้งแต่ศตวรรษที่ 16';
            $itemObj->createAt = "01 Jan 2023";
            $contentArray = [];
            $contentJson = new \stdClass;
            $contentJson->display = true;
            $contentJson->component = 'content';
            $contentJson->content = '
                <h3>H3</h3>
                <h4>H4</h4>
                <h5>H5</h5>
                <h6>H6</h6>
                <p>
                    This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component.
                </p>
                <blockquote class="blockquote">
                    <p>
                        Quote text components
                        Quote text components
                        Quote text components
                    </p>
                </blockquote>
                <ul>
                    <li>Bullet</li>
                    <li>Bullet</li>
                    <li>Bullet</li>
                    <li>Bullet</li>
                    <li>Bullet</li>
                    <li>Bullet</li>
                </ul>
                <ol>
                    <li>Number</li>
                    <li>Number</li>
                    <li>Number</li>
                    <li>Number</li>
                    <li>Number</li>
                    <li>Number</li>
                </ol>
            ';
            array_push($contentArray,$contentJson);
            $contentJson = new \stdClass;
            $contentJson->display = true;
            $contentJson->component = 'single-image';
            $contentJson->image = asset('images/default/ArticleTeaser.jpg');
            $contentJson->imagetitle = 'Caption Image';
            array_push($contentArray,$contentJson);
            $contentJson = new \stdClass;
            $contentJson->display = true;
            $contentJson->component = 'image-left';
            $contentJson->image = asset('images/default/ArticleTeaser.jpg');
            $contentJson->imagetitle = 'Caption Image';
            $contentJson->content = 'This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component.';
            array_push($contentArray,$contentJson);
            $contentJson = new \stdClass;
            $contentJson->display = true;
            $contentJson->component = 'image-right';
            $contentJson->image = asset('images/default/ArticleTeaser.jpg');
            $contentJson->imagetitle = 'Caption Image';
            $contentJson->content = 'This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component.';
            array_push($contentArray,$contentJson);
            $contentJson = new \stdClass;
            $contentJson->display = true;
            $contentJson->component = 'double-image';
            $contentJson->imageleft = asset('images/default/ArticleTeaser.jpg');
            $contentJson->imagelefttitle = 'Caption Image';
            $contentJson->imageright = asset('images/default/ArticleTeaser.jpg');
            $contentJson->imagerighttitle = 'Caption Image';
            array_push($contentArray,$contentJson);
            $itemObj->content = $contentArray;
            //Reference
            $itemObj->reference = [];
            $refObj = new \stdClass;
            $refObj->title = 'HYPERLINK';
            $refObj->link = '#';
            array_push($itemObj->reference,$refObj);
            $refObj = new \stdClass;
            $refObj->title = 'HYPERLINK';
            $refObj->link = '#';
            array_push($itemObj->reference,$refObj);
            $refObj = new \stdClass;
            $refObj->title = 'HYPERLINK';
            $refObj->link = '#';
            array_push($itemObj->reference,$refObj);
            //Tag
            $itemObj->tags = [];
            for($i = 0;$i <= 2;$i++){
                $tagItem = $tags->items[$i]->name;
                $tagObj = new \stdClass;
                $tagObj->name = $tags->items[$i]->name;
                $tagObj->id = $tags->items[$i]->sys->id;
                $tagObj->url = route('tags',['slug'=>$tags->items[$i]->sys->id]);
                array_push($itemObj->tags,$tagObj);
            }
            //pseudonym
            $itemObj->pseudonym = new \stdClass;
            $itemObj->pseudonym->name = 'Kittichai Kaweekijmanee';
            $itemObj->pseudonym->title = 'Writer';
            $itemObj->pseudonym->description = '';
            $itemObj->pseudonym->profileimage = asset('/images/default/Writer-default-image.png');
            array_push($result->data,$itemObj);
        }
    }else{
        $contentarrayquery = array("content_type"=>"content");
        $contentarrayquery['limit'] = 1;
        $contentarrayquery['fields.slug'] = $slug;
        $contentresponse = Http::withToken(config('app.cdaaccesstoken'))
        ->get(getCtCdaUrl().'/entries',$contentarrayquery);
        $contentresult = $contentresponse->object();
        $result->total = $contentresult->total;
        foreach($contentresult->items as $item){
            $itemObj = new \stdClass;
            $itemObj->id = $item->sys->id;
            $itemObj->title = $item->fields->title;
            $itemObj->slug = $item->fields->slug;
            $itemObj->content = $item->fields->content;
            $itemObj->url = route('blogpost',['slug'=>$item->fields->slug]);
            //thumbnail
            $imgResult = getImageByIdCda($item->fields->thumbnail->sys->id,$contentresult->includes->Asset);
            $itemObj->thumbnail = $imgResult->thumbnail;
            //hero
            $imgResult = getImageByIdCda($item->fields->heroimage->sys->id,$contentresult->includes->Asset);
            $itemObj->heroimage = $imgResult->thumbnail;
            //mobile
            if(isset($item->fields->mobileimage)){
                $imgMobileResult = getImageByIdCda($item->fields->mobileimage->sys->id,$contentresult->includes->Asset);
                $itemObj->mobileimage = $imgMobileResult->thumbnail;
            }else{
                $itemObj->mobileimage = $itemObj->thumbnail;
            }
            foreach($contentresult->includes->Entry as $entry) {
                if($entry->sys->id == $item->fields->category[0]->sys->id){
                    $itemObj->categoryid = $entry->sys->id;
                    $itemObj->category = $entry->fields->title;
                    $itemObj->categoryslug = $entry->fields->slug;
                    $itemObj->categoryurl = route('category',['slug'=>$entry->fields->slug]);
                    break;
                }
            }
            //pseudonym
            $itemObj->pseudonym = new \stdClass;
            foreach($contentresult->includes->Entry as $entry) {
                if($entry->sys->id == $item->fields->pseudonym[0]->sys->id){
                    $itemObj->pseudonym->name = $entry->fields->name;
                    $itemObj->pseudonym->title = $entry->fields->title;
                    $itemObj->pseudonym->description = $entry->fields->description;
                    $imgResult = getImageByIdCda($entry->fields->profileimage->sys->id,$contentresult->includes->Asset);
                    $itemObj->pseudonym->profileimage = $imgResult->thumbnail;
                    break;
                }
            }
            //reference
            if(isset($item->reference)){
                $itemObj->reference = $item->reference;
            }else{
                $itemObj->reference = [];
            }
            //Tag
            $itemObj->tags = [];
            foreach($item->metadata->tags as $systag){
                foreach($tags->items as $ctag){
                    if($ctag->sys->id == $systag->sys->id){
                        $tagObj = new \stdClass;
                        $tagObj->name = $ctag->name;
                        $tagObj->id = $ctag->sys->id;
                        $tagObj->url = route('tags',['slug'=>$ctag->sys->id]);
                        array_push($itemObj->tags,$tagObj);
                        break;
                    }
                }
            }
            //social
            $itemObj->ogimage = $itemObj->heroimage;
            if(isset($item->fields->ogimage)){
                $imgOgResult = getImageByIdCda($item->fields->ogimage->sys->id,$contentresult->includes->Asset);
                $itemObj->ogimage = $imgResult->thumbnail;
            }
            $itemObj->ogtitle = isset($item->ogtitle)?$item->ogtitle:'';
            $itemObj->ogdescription = isset($item->ogdescription)?$item->ogdescription:'';
            $createAt = explode(".",$item->sys->createdAt);
            $dt = date_create_from_format('Y-m-d\TH:i:s', $createAt[0]);
            date_add($dt,date_interval_create_from_date_string("7 hours"));
            $itemObj->createAt = date_format($dt,"d M Y");
            array_push($result->data,$itemObj);
        }
    }
    return $result;
}

function randomTags($size){
    $tags = getGenerateCustomFile('tag.json');
    $result = [];
    for($i = 1;$i <= $size;$i++){
        $randtag = rand(0,$tags->total);
        $tagObj = new \stdClass;
        $tagObj->name = $tags->items[$randtag]->name;
        $tagObj->id = $tags->items[$randtag]->sys->id;
        $tagObj->url = route('tags',['slug'=>$tags->items[$randtag]->sys->id]);
        array_push($result,$tagObj);
    }
    return $result;
}

function buildPage($pages = 1,$currentPage = 1){
    $page = new \stdClass;
    $page->first = false;
    $page->last = false;
    $page->min = 0;
    $page->max = 0;
    if($pages <= 3){
        $page->min = 1;
        $page->max = $pages;
    }else{
        if($currentPage == 1){
            $page->min = 1;
            $page->max = 3;
        }else{
            if($currentPage <> $pages){
                $page->min = $currentPage - 1;
                $page->max = $currentPage + 1;
            }else{
                $page->min = $pages - 2;
                $page->max = $pages;
            }
        }
    }
    if($pages == 1){
        $page->first = false;
        $page->last = false;
    }else{
        if($currentPage == 1){
            $page->last = true;
        }else{
            if($currentPage == $pages){
                $page->first = true;
                $page->last = false;
            }else{
                $page->first = true;
                $page->last = true;
            }
        }
    }
    return $page;
}

function renderContent($components) {
    foreach ($components as $component) {
        if($component->display){
            $data = '';
            switch($component->component){
                case 'content':
                    $data = $component->content;
                    break;
                case 'blockquote':
                    $data = "<blockquote class='blockquote'>".$component->title."<br>".$component->content."<br>".$component->credit."</blockquote>";
                    break;
                case 'image-left':
                    $data = "<div class='row image-block'>
                        <div class='col-12 col-md-6'>
                            <img src='".$component->image."' class='img-fluid'>
                            <span class='caption-image'>".$component->imagetitle."</span>
                        </div>
                        <div class='col-12 col-md-6'>".$component->content."</div>
                    </div>";
                    break;
                case 'image-right':
                    $data = "<div class='row image-block'>
                        <div class='col-12 col-md-6'>".$component->content."</div>
                        <div class='col-12 col-md-6'>
                            <img src='".$component->image."' class='img-fluid'>
                            <span class='caption-image'>".$component->imagetitle."</span>
                        </div>
                    </div>";
                    break;
                case 'double-image':
                    $data = "<div class='row image-block'>
                        <div class='col-12 col-md-6'>
                            <img src='".$component->imageleft."' class='img-fluid'>
                            <span class='caption-image'>".$component->imagelefttitle."</span>
                        </div>
                        <div class='col-12 col-md-6'>
                            <img src='".$component->imageright."' class='img-fluid'>
                            <span class='caption-image'>".$component->imagerighttitle."</span>
                        </div>
                    </div>";
                    break;
                case 'single-image':
                    $data = "<div class='row image-block'>
                        <div class='col-12'>
                            <img src='".$component->image."' class='img-fluid w-100'>
                            <span class='caption-image'>".$component->imagetitle."</span>
                        </div>
                    </div>";
                    break;
            }
            echo $data;
        }
    }
}
?>
