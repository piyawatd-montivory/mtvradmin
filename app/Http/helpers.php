<?php
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

if (! function_exists('generateuuid')) {
    function generateuuid(){
        return $uuid = str_replace("-","",Str::uuid()->toString());
    }
}

if (! function_exists('livetoken')) {
    function livetoken() {
        if(session()->get('token'))
        {
            $nowtime = date_create_from_format('Y-m-d H:i',date('Y-m-d H:i'));
            $expirestime = date_create_from_format('Y-m-d H:i',session()->get('tokenexpires'));
            if($nowtime >= $expirestime){
                $result = writectauth();
            }
        }else{
            $result = writectauth();
        }
    }
}

if (! function_exists('writectauth')) {
    function writectauth() {
        $CtObject = new \stdClass;
        $response = Http::withBasicAuth(config('app.ctclient'),config('app.ctsecret'))->post(config('app.ctoauth').'/oauth/token?grant_type=client_credentials');
        if($response->status() == 200){
            $CtObject->token = $response->json('access_token');
            $CtObject->time = date('Y-m-d H:i', (time() + intval($response->json('expires_in'))));
            $CtObject->status = $response->status();
            $fp = fopen(public_path('/') . "cttoken.json","wb");
            fwrite($fp,json_encode($CtObject));
            fclose($fp);
            session()->put('token', $CtObject->token);
            session()->put('tokenexpires', $CtObject->time);
            return true;
        }else{
            session()->delete('token');
            session()->delete('tokenexpires');
            return false;
        }
    }
}

if (! function_exists('readctauth')) {
    function readctauth() {
        $CtObject = new \stdClass;
        if(!file_exists(public_path('/') . "cttoken.json")){
            return writectauth();
        }else{
            $CtObject = json_decode(file_get_contents(public_path('/') . "cttoken.json"));
            $expirestime = date_create_from_format('Y-m-d H:i',$CtObject->time);
            $nowtime = date_create_from_format('Y-m-d H:i',date('Y-m-d H:i'));
            if($nowtime < $expirestime){
                session()->put('token', $CtObject->token);
                session()->put('tokenexpires', $CtObject->time);
                return true;
            }else{
                return writectauth();
            }
        }
    }
}

if (! function_exists('getProductType')) {
    function getProductType() {
        if(!file_exists(public_path('/') . "producttype.json")){
            $response = Http::withToken(session()->get('token'))
            ->get(config('app.cturl').'/'.config('app.ctproject').'/product-types');
            $fp = fopen(public_path('/') . "producttype.json","wb");
            fwrite($fp,json_encode($response->object()));
            fclose($fp);
        }
        $ptObject = json_decode(file_get_contents(public_path('/') . "producttype.json"));
        return $ptObject->results;
    }
}

if (! function_exists('getProductTypeById')) {
    function getProductTypeById($id) {
        $result = new \stdClass;
        if(!file_exists(public_path('/') . "producttype.json")){
            $response = Http::withToken(session()->get('token'))
            ->get(config('app.cturl').'/'.config('app.ctproject').'/product-types');
            $fp = fopen(public_path('/') . "producttype.json","wb");
            fwrite($fp,json_encode($response->object()));
            fclose($fp);
        }
        $ptObject = json_decode(file_get_contents(public_path('/') . "producttype.json"));
        foreach($ptObject->results as $item){
            if($item->id == $id){
                $result = $item;
                break;
            }
        }
        return $result;
    }
}

if (! function_exists('getCategory')) {
    function getCategory() {
        $filepath = public_path('/data/') . "category.json";
        if(!file_exists($filepath)){
            $response = Http::withToken(session()->get('token'))
            ->get(config('app.cturl').'/'.config('app.ctproject').'/categories');
            $fp = fopen($filepath,"wb");
            fwrite($fp,json_encode($response->object()->results));
            fclose($fp);
            return $response->object();
        }
        return json_decode(file_get_contents($filepath));
    }
}

if (! function_exists('getCategoryById')) {
    function getCategoryById($id) {
        $categories = categoryRecursive(getCategory());
        foreach($categories as $category){
            if($category->id == $id){
                return $category;
            }
        }
    }
}

if (! function_exists('categoryRecursive')) {
    function categoryRecursive($categories){
        $result = [];
        foreach($categories as $category)
        {
            if (!property_exists($category, 'parent'))
            {
                $cateObj = new \stdClass;
                $cateObj->id = $category->id;
                $cateObj->key = $category->key;
                $cateObj->name = $category->name->th;
                array_push($result,$cateObj);
                $result = categoryRecursiveParent($result,$categories,$category->name->th,$category->id);
            }
        }
        return $result;
    }
}

if (! function_exists('categoryRecursiveParent')) {
    function categoryRecursiveParent($result,$categories,$name,$id){
        foreach($categories as $category)
        {
            if (property_exists($category, 'parent') && ($category->parent->id == $id))
            {
                $cateObj = new \stdClass;
                $cateObj->id = $category->id;
                $cateObj->key = $category->key;
                $catename = '';
                if($name <> '')
                {
                    $catename = $name.' > '.$category->name->th;
                }else{
                    $catename = $category->name->th;
                }
                $cateObj->name = $catename;
                array_push($result,$cateObj);
                $result = categoryRecursiveParent($result,$categories,$category->name->th,$category->id);
            }
        }
        return $result;
    }
}

if (! function_exists('categoryByKey')) {
    function categoryByKey($key,$categories){
        $result = [];
        foreach($categories as $category)
        {
            if ($category->key == $key)
            {
                $result = categoryRecursiveParent($result,$categories,'',$category->id);
            }
        }
        return $result;
    }
}

if (! function_exists('getProductBySeller')) {
    function getProductBySeller() {
        $url = urlencode('name="seller" and value="'.Auth::user()->company.'"');
        $response = Http::withToken(session()->get('token'))
        ->get(config('app.cturl').'/'.config('app.ctproject').'/products?limit=500&where=masterData(current(masterVariant(attributes('.$url.'))))');
        $product = new \stdClass;
        $products = [];
        foreach($response->object()->results as $result){
            $master = $result->masterData->current;
            $item = new \stdClass;
            $item->id = $result->id;
            $item->productkey = $result->key;
            $item->name = $master->name->th;
            $item->published = $result->masterData->published;
            $ptType = getProductTypeById($result->productType->id);
            $item->producttype = $ptType->name;
            $item->producttypekey = $ptType->key;
            array_push($products,$item);
        }
        return $products;
    }
}

if (! function_exists('getProductByKey')) {
    function getProductByKey($key) {
        $productObj = new \stdClass;
        // $productObj->seller = Auth::user()->company;
        $response = Http::withToken(session()->get('token'))
        ->get(config('app.cturl').'/'.config('app.ctproject').'/products/key='.$key);
        $product = $response->object();
        $masterData = $product->masterData->current;
        $productObj->id = $product->id;
        $productObj->version = intval($product->version);
        $productObj->published = $product->masterData->published;
        $productObj->productkey = $product->key;
        $productObj->name = $masterData->name->th;
        $productObj->description = isset($masterData->description->th) ? $masterData->description->th : '';
        $productObj->productType = getProductTypeById($product->productType->id);
        $categorys = [];
        foreach($masterData->categories as $category){
            array_push($categorys,getCategoryById($category->id));
        }
        $productObj->category = $categorys;
        $variants = [];
        //masterVariant
        $vMaster = $masterData->masterVariant;
        $variantObj = new \stdClass;
        $variantObj->master = true;
        $variantObj->id = $product->id;
        $variantObj->variantid = $vMaster->id;
        $variantObj->productkey = $product->key;
        $variantObj->name = $masterData->name->th;
        $variantObj->variantid = $vMaster->id;
        $variantObj->sku = $vMaster->sku;
        $variantObj->priceid = $vMaster->prices[0]->id;
        $variantObj->price = intval($vMaster->prices[0]->value->centAmount) / 100;
        $ckey = key($vMaster->availability->channels);
        $variantObj->amount = $vMaster->availability->channels->$ckey->availableQuantity;
        $variantObj->inventoryversion = $vMaster->availability->channels->$ckey->version;
        $variantObj->inventoryid = $vMaster->availability->channels->$ckey->id;
        $variantObj->image = $vMaster->images[0]->url;
        switch ($productObj->productType->key) {
            case 'graphicscard':
                foreach($vMaster->attributes as $attrObj){
                    switch ($attrObj->name) {
                        case 'size':
                            $variantObj->size = $attrObj->value;
                            break;
                        case 'model':
                            $productObj->model = $attrObj->value;
                            break;
                        case 'seller':
                            $productObj->seller = $attrObj->value;
                            break;
                        case 'brand':
                            $productObj->brand = $attrObj->value->id;
                            break;
                    }
                }
                break;
            case 'snack':
                foreach($vMaster->attributes as $attrObj){
                    switch ($attrObj->name) {
                        case 'weight':
                            $variantObj->weight = $attrObj->value;
                            break;
                        case 'taste':
                            $variantObj->taste = $attrObj->value;
                            break;
                        case 'seller':
                            $productObj->seller = $attrObj->value;
                            break;
                    }
                }
                break;
            case 'memory':
                foreach($vMaster->attributes as $attrObj){
                    switch ($attrObj->name) {
                        case 'size':
                            $variantObj->size = $attrObj->value;
                            break;
                        case 'type':
                            $productObj->type = $attrObj->value;
                            break;
                        case 'brand':
                            $productObj->brand = $attrObj->value->id;
                            break;
                        case 'seller':
                            $productObj->seller = $attrObj->value;
                            break;
                    }
                }
                break;
            case 'stroages':
                foreach($vMaster->attributes as $attrObj){
                    switch ($attrObj->name) {
                        case 'size':
                            $variantObj->size = $attrObj->value;
                            break;
                        case 'brand':
                            $productObj->brand = $attrObj->value->id;
                            break;
                        case 'seller':
                            $productObj->seller = $attrObj->value;
                            break;
                    }
                }
                break;
        }
        array_push($variants,$variantObj);
        //variant
        foreach($masterData->variants as $variant){
            $variantObj = new \stdClass;
            $variantObj->master = false;
            $variantObj->id = $product->id;
            $variantObj->variantid = $variant->id;
            $variantObj->productkey = $product->key;
            $variantObj->name = $masterData->name->th;
            $variantObj->variantid = $variant->id;
            $variantObj->sku = $variant->sku;
            $variantObj->priceid = $variant->prices[0]->id;
            $variantObj->price = intval($variant->prices[0]->value->centAmount) / 100;
            $ckey = key($variant->availability->channels);
            $variantObj->amount = $variant->availability->channels->$ckey->availableQuantity;
            $variantObj->inventoryversion = $variant->availability->channels->$ckey->version;
            $variantObj->inventoryid = $variant->availability->channels->$ckey->id;
            $variantObj->image = $variant->images[0]->url;
            switch ($productObj->productType->key) {
                case 'graphicscard':
                    foreach($variant->attributes as $attrObj){
                        switch ($attrObj->name) {
                            case 'size':
                                $variantObj->size = $attrObj->value;
                                break;
                        }
                    }
                    break;
                case 'snack':
                    foreach($variant->attributes as $attrObj){
                        switch ($attrObj->name) {
                            case 'weight':
                                $variantObj->weight = $attrObj->value;
                                break;
                            case 'taste':
                                $variantObj->taste = $attrObj->value;
                                break;
                        }
                    }
                    break;
                case 'memory':
                    foreach($variant->attributes as $attrObj){
                        switch ($attrObj->name) {
                            case 'size':
                                $variantObj->size = $attrObj->value;
                                break;
                        }
                    }
                    break;
                case 'stroages':
                    foreach($variant->attributes as $attrObj){
                        switch ($attrObj->name) {
                            case 'size':
                                $variantObj->size = $attrObj->value;
                                break;
                        }
                    }
                    break;
            }
            array_push($variants,$variantObj);
        }   
        $productObj->variants = $variants;
        return $productObj;
    }
}


if (! function_exists('getProductBySku')) {
    function getProductBySku($sku) {
        $productObj = new \stdClass;
        $productObj->seller = Auth::user()->company;
        $urlmaster = urlencode('masterVariant(sku="'.$sku.'")');
        $urlvariant = urlencode('variants(sku="'.$sku.'")');
        $response = Http::withToken(session()->get('token'))
        ->get(config('app.cturl').'/'.config('app.ctproject').'/products?where=masterData(current('.$urlmaster.'))');
        if(intval($response->json('total')) > 0){
            $product = $response->object()->results[0];
            $master = $product->masterData->current;
            $vMaster = $master->masterVariant;
            $productObj->id = $product->id;
            $productObj->version = $product->version;
            $productObj->published = $product->masterData->published;
            $productObj->productkey = $product->key;
            $productObj->name = $master->name->th;
            $productObj->description = $master->description->th;
            $productObj->variantid = $vMaster->id;
            $productObj->sku = $vMaster->sku;
            $productObj->price = intval($vMaster->prices[0]->value->centAmount) / 100;
            $ckey = key($vMaster->availability->channels);
            $productObj->amount = $vMaster->availability->channels->$ckey->availableQuantity;
            $productObj->inventoryid = $vMaster->availability->channels->$ckey->id;
            $productObj->inventoryversion = $vMaster->availability->channels->$ckey->version;
            $productObj->image = $vMaster->images[0]->url;
            $productObj->variantcount = 1 + count($master->variants);
            foreach($vMaster->attributes as $attrObj){
                switch ($attrObj->name) {
                    case 'weight':
                        $productObj->weight = $attrObj->value;
                        break;
                    case 'taste':
                        $productObj->taste = $attrObj->value;
                        break;
                }
            }
            return $productObj;
        }
        $response = Http::withToken(session()->get('token'))
        ->get(config('app.cturl').'/'.config('app.ctproject').'/products?where=masterData(current('.$urlvariant.'))');
        $product = $response->object()->results[0];
        $master = $product->masterData->current;
        //variant
        foreach($master->variants as $variant){
            if($variant->sku == $sku){
                $productObj->id = $product->id;
                $productObj->version = $product->version;
                $productObj->published = $product->masterData->published;
                $productObj->productkey = $product->key;
                $productObj->name = $master->name->th;
                $productObj->description = $master->description->th;
                $productObj->variantid = $variant->id;
                $productObj->sku = $variant->sku;
                $productObj->price = intval($variant->prices[0]->value->centAmount) / 100;
                $ckey = key($variant->availability->channels);
                $productObj->amount = $variant->availability->channels->$ckey->availableQuantity;
                $productObj->inventoryid = $variant->availability->channels->$ckey->id;
                $productObj->inventoryversion = $variant->availability->channels->$ckey->version;
                $productObj->image = $variant->images[0]->url;
                $productObj->variantcount = 1 + count($master->variants);
                foreach($variant->attributes as $attrObj){
                    switch ($attrObj->name) {
                        case 'weight':
                            $productObj->weight = $attrObj->value;
                            break;
                        case 'taste':
                            $productObj->taste = $attrObj->value;
                            break;
                    }
                }
                return $productObj;
            }
        }   
    }
}