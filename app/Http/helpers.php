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
?>
