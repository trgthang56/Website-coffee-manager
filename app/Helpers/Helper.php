<?php 
namespace App\Helpers;

class Helper{
    public static function menu($menus, $parent_id = 0,$char = ''){
            $html = '';
            foreach($menus as $key => $menu){
                if($menu->parent_id == $parent_id){
                    $html .= '
                    <tr>
                    <td>'. $menu->id .'</td>
                    <td>'. $char.$menu->name .'</td>
                    <td>'. self::active($menu->active) .'</td>
                    <td>'. $menu->updated_at .'</td>
                    <td>
                        <a class=" btn btn-primary btn-sm" href="/menus/edit/'.$menu->id. '">
                        <i class="fas fa-edit"></i>
                        </a>

                        <a class=" btn btn-danger btn-sm" 
                        onclick="removeRow('. $menu->id.',\'/menus/destroy\')"
                        >
                        <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>

                    </tr>
                    ';
                    unset($menus[$key]);
                    $html .= self::menu($menus,$menu->id,$char .'<i class="fas fa-grip-lines-vertical"></i> ');
                    
                }
            }
            return $html;
    }
    public static function formatTimeDifference($seconds) {
        if ($seconds < 60) {
         return $seconds . " giây";
       } elseif ($seconds < 3600) {
         $minutes = floor($seconds / 60);
          return $minutes . " phút";
       } elseif ($seconds < 86400) {
          $hours = floor($seconds / 3600);
          return $hours . " giờ";
       } else {
         $days = floor($seconds / 86400);
         return $days . " ngày";
     }
   }
    public static function active($active = 0): string
    {
        return $active == 0 ? '<span class="btn btn-danger btn-xs">Không kích hoạt</span>'
            : '<span class="btn btn-success btn-xs">Có kích hoạt</span>';
    }
}