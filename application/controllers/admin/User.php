<?php
class User extends MY_controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }
    // lấy danh sách admin_MD
    function index(){
        $input = array();
        $list = $this->user_model->get_list($input);
        $this->data['list']=$list;

        $total = $this->user_model->get_total($input);
        $this->data['total']=$total;
        // lấy ra nội dung của biến message
        $message= $this->session->flashdata('message');
        $this->data['message']= $message;

        $this->data['temp'] = 'admin/user/index';
        $this->load->view('admin/main',$this->data);

    }
    function add(){
        $this->load->library('form_validation');
        $this->load->helper('form');

        // nếu có dữ liệu lên thì kt
        if($this->input->post()){

            $this->form_validation->set_rules('name','Name','required');
            $this->form_validation->set_rules('email','Email','required');
            $this->form_validation->set_rules('phone','Phone','required');
            $this->form_validation->set_rules('address','Address','required');

            if($this->form_validation->run()){
                $name = $this->input->post('name');
                $email = $this->input->post('email');
                $phone = $this->input->post('phone');
                $address = $this->input->post('address');

                $data = array('name'=>$name,
                    'email'=>$email,'phone'=>$phone,'address'=>$address);

                if ($this->user_model->create($data)) {
                    // tạo ra nội dung thông báo.
                    $this->session->set_flashdata('message','Thêm thành công');
                } else {
                    $this->session->set_flashdata('message','Thêm thất bại');
                }
                redirect(admin_url('user'));
            }


        }
        $this->data['temp'] = 'admin/user/add';
        $this->load->view('admin/main',$this->data);

    }
    function edit(){
        $this->load->library('form_validation');
        $this->load->helper('form');

        $id = $this->uri->rsegment('3');
        $info = $this->user_model->get_info($id);

        if(!$info){
            $this->form_validation->set_message(__FUNCTION__,'Tài Khoản Không tồn tại');
            redirect(admin_url('user'));
        }
        $this->data['info']=$info;

        // nếu có dữ liệu lên thì kt
        if($this->input->post()){

            $this->form_validation->set_rules('name','Name','required');
            $this->form_validation->set_rules('email','Email','required');
            $this->form_validation->set_rules('phone','Phone','required');
            $this->form_validation->set_rules('address','Address','required');

            if($this->form_validation->run()){
                $name = $this->input->post('name');
                $email = $this->input->post('email');
                $phone = $this->input->post('phone');
                $address = $this->input->post('address');

                $data = array('name'=>$name,
                    'email'=>$email,'phone'=>$phone,'address'=>$address);

                if ($this->user_model->update($id,$data)) {
                    // tạo ra nội dung thông báo.
                    $this->session->set_flashdata('message','Thêm thành công');
                } else {
                    $this->session->set_flashdata('message','Thêm thất bại');
                }
                redirect(admin_url('user'));
            }


        }
        $this->data['temp'] = 'admin/user/edit';
        $this->load->view('admin/main',$this->data);

    }
    function del(){
        $id = $this->uri->rsegment('3');
        $id=intval($id); // ép kiểu dữ liệu
        //lấy thông tin qtv
        $info = $this->user_model->get_info($id);
        if(!$info){
            $this->session->set_flashdata('message','Tài khoản thành viên không tồn tại');
            redirect(admin_url('user'));
        }
        $this->user_model->delete($id,$info);

        $this->session->set_flashdata('message','Xóa thành viên thành công');
        redirect(admin_url('user'));

    }
}