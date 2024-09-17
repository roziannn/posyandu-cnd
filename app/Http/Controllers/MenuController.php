<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

// class MenuController extends Controller
// {
//   public function show()
//   {
//     $menuPath = storage_path('menu/verticalMenu.json');
//     $menu = [];

//     if (auth()->check()) {
//       $currentRole = auth()->user()->role;

//       if (File::exists($menuPath)) {
//         $menuData = json_decode(File::get($menuPath));

//         if (json_last_error() === JSON_ERROR_NONE) {
//           if (isset($menuData->menu)) {
//             foreach ($menuData->menu as $menuItem) {
//               if (isset($menuItem->roles) && in_array($currentRole, $menuItem->roles)) {
//                 $menu[] = $menuItem;
//               }
//             }
//           }
//         } else {
//           throw new \Exception('Error decoding JSON: ' . json_last_error_msg());
//         }
//       }
//     }

//     return view('layouts.sections.menu.verticalMenu', ['menu' => $menu]);
//   }
// }