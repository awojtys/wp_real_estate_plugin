<?php

/**
 * Description of Helpers
 *
 * @author awojtys
 */

class Forms {
    protected function _prepareOptionsForForm()
    {
        global $post;
        $getvalues = new ConnectWithDB();
        $values = $getvalues->getMetaForOffer();
        
        $form_data = array(
            '0' => array(
                'name' => 'description',
                'type' => 'textarea',
                'value' => $values['description'],
                'label' => 'Description:',
                'others' => 'rows="5" cols="30" style="resize:none; font-size:12px;"',
            ),
            '1' => array(
                'name' => 'type',
                'type' => 'text',
                'value' => $values['type'],
                'label' => 'Type:',
                'others' => '',
            ),
            '2' => array(
                'name' => 'measurement',
                'type' => 'text',
                'value' => $values['measurement'],
                'label' => 'Measurement:',
                'others' => 'onkeypress="validate(event)"',
            ),
            '3' => array(
                'name' => 'address',
                'type' => 'text',
                'value' => $values['address'],
                'label' => 'Address:',
                'others' => '',
            ),
            '4' => array(
                'name' => 'price',
                'type' => 'text',
                'value' => $values['price'],
                'label' => 'Price:',
                'others' => 'onkeypress="validate(event)"',
            ),
            '5' => array(
                'name' => 'post_type',
                'type' => 'hidden',
                'value' => $post->post_type,
                'label' => '',
                'others' => '',
            ),
            '6' => array(
                'name' => 'post_id',
                'type' => 'hidden',
                'value' => $post->ID,
                'label' => '',
                'others' => '',
            ),
        );
        return $form_data;
    }
    
    public function createForm()
    {
        $form = array();
        $form_options = $this->_prepareOptionsForForm();
        foreach($form_options as $key => $option)
        {
            $form[$key] = '
            <tr>
            <td><label for="' . $option['name'] .'">' . $option['label'] .'</label></td>';
            
            if($option['type'] == 'textarea')
            {
                $form[$key] .=   '<td><textarea name="offer[' . $option['name'] . ']" id="' . $option['name'] . 'offer" ' . $option['others'] . '>' . $option['value'] . '</textarea></td></tr>';
            }
            else
            {
                $form[$key] .=   '<td><input type="' . $option['type'] . '" name="offer[' . $option['name'] . ']"  id="' . $option['name'] . 'offer" ' . $option['others'] . ' value="' . $option['value'] . '"></td></tr>';
            } 
        }
        foreach($form as $display)
        {
            echo $display;
        }
        
    
        return $form_options[1]['value'];
    }
    
    public function prepareOfferData($request)
    {
       
        $data = array();
        foreach($request as $key => $offer)
        {
            if($key != 'picture' && $key != 'save' && $key != 'action')
            {
                $data[$key] = trim(strip_tags($offer));
            }
        }
         
        return $data;
        
    }
    
    public function sendOfferToDB($data, $post)
    {   
        
        $response = array("status" => false);
        
        if($post['post_type'] == 'offers')
        {
            foreach ($data as $key => $meta)
            {
                update_post_meta($post['post_id'], $key, $meta);
            }         
        }
        else
        {
            $new_post = array(
                'post_title'   => 'New offer from site',
                'post_content' => '',
                'post_type'    => 'offers',
                'post_status'  => 'draft',           
            );
            if($post['created_post_id'] == '')
            {
                $id = wp_insert_post($new_post);
            }
            else
            {
                $id = $post['created_post_id'];
            }
            $response['post_id'] = $id;
            
            foreach ($data as $key => $meta)
            {
                
                update_post_meta($id, $key, $meta);
            }
            $response['status'] = true;
            ob_clean();
            header("Content-Type: application/json");        
            echo json_encode($response);
        }
    }
    
    public function deleteFiles($files)
    {
        $files = explode(',', $files);
        
        foreach($files as $file)
        {
            if($file != '')
            {
                $t = unlink($_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/real_estate/'.$file);
            }
        }
    }
}

?>
