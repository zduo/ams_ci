<?php

class Imagecheck {

    public function check_img($img_path)
    {
        if (empty($img_path)
            || !file_exists(FCPATH.$img_path))
        {
            $img_url = '';
        }
        else
        {
            $img_url = base_url($img_path);
        }
        return $img_url;
    }

    public function turn_component($component)
    {
        if (empty($component))
        {
            return '';
        }
        $com_arr = explode("\n", $component);
        $com = array();
        if (!empty($com_arr))
        {
            foreach ($com_arr as $item)
            {
                $item = trim($item);
                if (empty($item)) continue;
                $item_arr = explode(' ', $item, 2);
                if (empty($item_arr) || (isset($item_arr[0]) && empty($item_arr[0]))) continue;
                if (!isset($item_arr[1]))
                    $item_arr[1] = '';
                $com[] = array(
                    'name'  => trim($item_arr[0]),
                    'count' => trim($item_arr[1]),
                );
            }
        }
        return $com;
    }
}
