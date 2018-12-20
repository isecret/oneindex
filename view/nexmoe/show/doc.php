<?php 
    $url = 'https://view.officeapps.live.com/op/view.aspx?src='.urlencode($item['downloadUrl']);
    View::direct($url);
    exit();
