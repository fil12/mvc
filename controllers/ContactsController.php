<?php

    class ContactsController extends Controller{
        public function index(){
            if($_POST){
                if($this->model->save($_POST)){
                    Session::setFlash('Thank you! Your message was sent successfully!');
                }
            }

        }

        public function __construct(array $data = array())
        {
            parent::__construct( $data );
            $this->model = new Message();
        }

        public function admin_index(){
            $this->data = $this->model->getList();
        }



    }