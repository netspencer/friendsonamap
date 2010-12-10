<?php

function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
						//$sortable_array[] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
				//$sortable_array[] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            //$new_array[$k] = $array[$k];
			$new_array[] = $array[$k];
        }
    }

    return $new_array;
}

?>