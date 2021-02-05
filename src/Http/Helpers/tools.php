<?php

use App\Models\ProductPrice;
use App\Models\ShowColumnTable;

use App\Models\CurrencyConversionRate;
use App\Models\Game;
use Illuminate\Support\Facades\Cache;


function array_except($array, $keys){
    foreach($keys as $key){
        unset($array[$key]);
    }
    return $array;
}
function globalIcons($iconKey){
    $icons = require resource_path('views/theme/icon.php');
    return $icons[$iconKey] ?? '<i class="fas fa-' .$iconKey .'"></i>';
}

//function echo_comment($comments , $m = 0)
//{
//    $comments = $comments->where('parent_id' ,null);
//    foreach ($comments as  $comment){
//        echo ' <div class="rounded border-black-50 my-2 p-2">
//                                            <div class="d-flex flex-column flex-lg-row justify-content-space-between">
//                                                <div class="d-flex justify-content-space-between">
//                                                    <img src="{{asset($comment->user->image ?? url(\'images/users/userdefult.png\'))}}" class="rounded-circle" alt="" width="50" height="50">
//                                                    <div class="mr-2">
//                                                        <span class="font-size-14">{{$comment->user->name}}<i class="fas fa-thumbs-down text-danger bg-black-85 p-1"></i></span>
//                                                        <p class="font-size-16">{{$comment->text}}</p>
//                                                    </div>
//                                                </div>
//                                                <div class="d-flex align-items-baseline">
//                                                    <span class="font-size-14 bg-black-85 border-radius-20 p-1 ml-1">توسط مدیر پاسخ داده شده</span>
//                                                    <span class="font-size-14">1398/06/11</span>
//                                                </div>
//                                            </div>';
//    }
//}
function echo_menu($collectionMenu ,$page_name , $m =0)
{
    $menu = null;
    foreach ($collectionMenu as $menu) {
        $title = \Illuminate\Support\Facades\Lang::get($menu->title);
        $booleanActive = false;
        $accordionParent = '#parentSidebar'.$menu->parent_id;
        $active = '';
        $route_name = '#';
        $collapse = '';
        if ($menu->route_name){
            $route_name = route($menu->route_name) ;
        }
        $parentId = 'parentSidebar'.$menu->id  ;
        $toggleIcon = '';
        if ($menu->children->count()){
            $toggleIcon = '<div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></div>';
            $route_name = '#parentSidebar'.$menu->id ;
            $collapse = 'collapse';
        }
        if ($page_name == $menu->title){
            $active = 'active';
            $booleanActive = 'true';
        }
        if ($menu->permission_id){
            if (auth()->user()->can($menu->permission->name)) {
                echo "<li class='menu " . $active . "'>
                    <a class='dropdown-toggle m-0 mr-" . $m . "' href='" . $route_name . "' data-toggle='" . $collapse . "' data-active='" . $booleanActive . "' >
                    <div>
                    <i class='fas fa-" . $menu->icon . " ml-2 font-size-18 vertical-mid' ></i>
                    <span>$title</span> ";
                        //see if this menu has children
                        echo '</div>' . $toggleIcon . '
                    </a>
                    </li>';
            }
        }else {
            echo "<li class='menu " . $active . "'>
                    <a class='dropdown-toggle m-0 mr-" . $m . "' href='" . $route_name . "' data-toggle='" . $collapse . "' data-active='" . $booleanActive . "' >
                    <div>
                    <i class='fas fa-" . $menu->icon . " ml-2 font-size-18 vertical-mid' ></i>
                    <span>$title</span> ";
            //see if this menu has children
            echo '</div>' . $toggleIcon . '
                    </a>
                    </li>';
        }
        if ($menu->children->count()) {
            $menu->children = $menu->children->sortBy('order');
            echo "<ul class='collapse submenu list-unstyled' id='".$parentId."'  data-parent='".$accordionParent."'  >";
            //echo the child menu
            echo_menu($menu->children , $page_name ,$m+2);
            echo "</ul>";
        }
    }
}

function specific_value_remove($array,$value) {
    return array_diff($array, (is_array($value) ? $value : array($value)));
}
function getDataTableColums($table){
    $fields = ShowColumnTable::where('table',$table)->pluck('columns')->first();
    if ($fields != null){
        $fields = unserialize($fields);
    }
    if (! $fields){
        $fields = getDataTableColumnsDefault($table);
    }
    $fields = collect($fields)->values()->all();
    return $fields;
}
function getDataTableColumnsDefault($table){
    $fields =  getTableColumns($table);
    $fields = $fields->flip() ;
    $fields = collect([1 => 'column'])->merge($fields);
    $fields->push('action');
    $fields = $fields->values()->all();
    return $fields ;
}
function getTableColumns($table =null)
{
    if ($table != null){
        return collect(\Illuminate\Support\Facades\DB::getSchemaBuilder()->getColumnListing($table))->flip()->except(['id', 'remember_token']);
    }else{
        return "";
    }
}
//* convert number
//* change number charecter english to number persian
//*/

function convertNum($value, $type = 'EN')
{
    $type = strtolower($type);
    $num_fa = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    $num_en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    $num_ar = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨' ,'٩'];

    if ($type == 'en')
        $return = str_replace($num_fa, $num_en, $value);
    else if( $type == 'fr') {
        $value = str_replace($num_fa, $num_ar, $value);
        $return = str_replace($num_en, $num_ar, $value);
    } else
        $return = str_replace((int)$num_en, (int)$num_fa, (int)$value);

    return $return;
}

function getGamePriceInCurrency(ProductPrice $price, $currency){
    $currency = strtoupper($currency);
    $final = $price->final;
    $fromC = $price->currency;
    $usd = floatval(floatval($final/100) * CurrencyConversionRate::where(['from' => $fromC, 'to' => 'USD'])->first()->rate);
    return round(floatval($usd * CurrencyConversionRate::where(['from' => 'USD', 'to' => $currency])->first()->rate), ($currency == 'IRR' ? 0 : 2));
}

function convertWord($word){
    $words = require resource_path('lang/convert/convertWords.php');
    return $words[$word] ?? $word;
}

function validatePhone($phone){
    return preg_match('/^(?:\+9|9|009|0|[+])?9[0-9]{9}/' , $phone);
}

function normalizePhone($phone){
    return '0' . substr($phone, -10);
}
function srcDefultImageUser(){
    return asset('images/users/userdefult.png');
}


function cacheGet($key){
    $queries =[
        'all_games' => '$value = \App\Models\Game::all();',
        'all_game_categories' => '$value = \App\Models\GameCategory::all();',
        'all_game_genres' => '$value = \App\Models\GameGenre::all();',
        'all_products' => '$value = \App\Models\Products::all();',
        'all_dlcs' => '$value = \App\Models\Dlc::all();',
        'all_tickets' => '$value =  \App\Models\Ticket::all();',
        'all_products_latest' => '$value = \App\Models\Product::latest()->get();'
    ];
    if(Cache::has($key)){
        $value = Cache::get($key);
    }else{
        $value = collect();
        eval($queries[$key] ?? ';');
        Cache::put($key, $value);
    }
    return $value;
}


function cacheRefresh($key){
    Cache::pull($key);
    return cacheGet($key);
}
