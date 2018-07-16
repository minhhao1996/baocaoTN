<?php
/**
 * Created by PhpStorm.
 * User: MyPC
 * Date: 13/07/2018
 * Time: 7:46 CH
 */
class  Contact extends MY_controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('contact_model');
    }
    function  index(){
        $this->data['temp'] = 'site/contact/index';
        $this->load->view('site/layout',$this->data);
    }

}