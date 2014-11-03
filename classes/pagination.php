<?php
/**
 * Created by Chris on 11/2/2014 2:25 PM.
 */

class Pagination {

    function paginate($values, $per_page) {
        $total_values = count($values);
        $page = Input::get('page');

        if(isset($page)) {
            $current_page = $page;
        } else {
            $current_page = 1;
        }

        $counts = ceil($total_values / $per_page);
        $param1 = ($current_page - 1) * $per_page;
        $this->data = array_slice($values,$param1,$per_page);

        for($x=1; $x<= $counts; $x++) {
            $numbers[] = $x;
        }
        return $numbers;
    }

    function fetchResult(){
        $resultsValues = $this->data;
            return $resultsValues;
    }

}