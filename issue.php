<?php
    //Params
	$key = 'dde234556fb55a946c09986ed9577';
	$token = 'ccf29f60a9dasdb9d3dasd54386713b0f7das7f7aa5fd3da3bc7a20da5a3fbafe6947f94d672';
	

	
    header("Content-Type: application/json");
    
    $json = file_get_contents('php://input');
    $obj = json_decode($json, true);

    if($obj['action']=='opened'){
        $url = 'https://api.trello.com/1/cards?key='.$key.'&token='.$token.'';
        $data = array('name' => $obj['issue']['title'].' id:'.$obj['issue']['id'], 'desc'=> $obj['issue']['body'],  'due' => null, 'idList' => '53f7c5c7383f6b76466ba12a', 'urlSource' => $obj['issue']['html_url']);
        $method = 'POST';    
            
        request($method, $data, $url);
    }
    elseif($obj['action']=='reopened'){
        $url = 'https://api.trello.com/1/boards/53f7c5c7383f6b76466ba129/cards?fields=name&key='.$key.'&token='.$token.'';
        $method = 'GET';
        $cards = json_decode(request($method, array(), $url), TRUE);  

        $cards_lenght = count($cards);

        
        $pattern = '/^.*(id:'.$obj['issue']['id'].'){1}/';
        
        $search_item_id = NULL;

        for($i=0; $i<$cards_lenght; $i++){
            
            $string = $cards[$i]['name'];
            if(preg_match($pattern, $string)){
                $search_item_id = $cards[$i]['id'];
            }
        }

        if($search_item_id != null) {
            


        $url = 'https://api.trello.com/1/cards/'.$search_item_id.'/idList?key='.$key.'&token='.$token.'';
        $data = array('value' => '53f7c5c7383f6b76466ba12a');
        $method = 'PUT'; 

        request($method, $data, $url);
    }
    elseif($obj['action']=='closed'){

        $url = 'https://api.trello.com/1/boards/53f7c5c7383f6b76466ba129/cards?fields=name&key='.$key.'&token='.$token.'';
        $method = 'GET';
        $cards = json_decode(request($method, array(), $url), TRUE);  

        $cards_lenght = count($cards);

        
        $pattern = '/^.*(id:'.$obj['issue']['id'].'){1}/';
        
        $search_item_id = NULL;

        for($i=0; $i<$cards_lenght; $i++){
            
            $string = $cards[$i]['name'];
            if(preg_match($pattern, $string)){
                $search_item_id = $cards[$i]['id'];
            }
        }

        if($search_item_id != null) {
            


        $url = 'https://api.trello.com/1/cards/'.$search_item_id.'/idList?key='.$key.'&token='.$token.'';
        $data = array('value' => '53f7c5c7383f6b76466ba12c');
        $method = 'PUT'; 

        request($method, $data, $url);


        }
            

    }

    
    function request($method, $data, $url){
         $options = array(
            'http' => array(
                'header'  => "Content-type: application/json\r\n",
                'method'  => $method,
                'content' => json_encode($data),
            ),
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context); 
        return $result;      
    }
    
?>