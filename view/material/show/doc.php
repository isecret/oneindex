<?php 
        if ($item["size"] < 10000000) {
            $url = 'https://view.officeapps.live.com/op/view.aspx?src='.urlencode($item['downloadUrl']);
            View::direct($url);
        } else {
            View::direct($item['downloadUrl']);
        }
        exit();
