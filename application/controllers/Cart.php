<?php
/**
 * Created by PhpStorm.
 * User: MyPC
 * Date: 15/07/2018
 * Time: 9:52 CH
 */
class Cart extends  MY_controller{
    function __construct()
    {
        parent::__construct();
        $this->load->library('cart');

    }
    function add(){
        //lay ra san pham muon them vao gio hang
        $this->load->model('product_model');
        $id = $this->uri->rsegment(3);
        $product = $this->product_model->get_info($id);
        if(!$product)
        {
            redirect();
        }
        //tong so san pham
        $qty = 1;
        $price = $product->price;
        if($product->discount > 0)
        {
            $price = $product->price - $product->discount;
        }

        //thong tin them vao gio hang
        $data = array();
        $data['id'] = $product->id;
        $data['qty'] = $qty;
        $data['name'] = url_title($product->name);
        $data['image_link']  = $product->image_link;
        $data['price'] = $price;
        $this->cart->insert($data);

        //chuyen sang trang danh sach san pham trong gio hang
        redirect(base_url('cart'));

    }

    //hien thị danh sách giỏ hàng
    function index(){
        $carts = $this->cart->contents();
        pre($carts);
    }
}