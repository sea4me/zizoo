<?php

class Gallery extends CI_Model {

    var $path;
    var $gallery_path_url;
    var $logopath;

    //Constructor
    function Gallery() {
        parent::__construct();
        $this->load->helper('url');

        $this->path = realpath(APPPATH . '../images');
        $this->gallery_path_url = base_url() . 'images/';
        $this->logopath = realpath(APPPATH . '../');
    }

    function do_upload($id) {
        if (!is_dir($this->path . '/' . $id)) {
            mkdir($this->path . '/' . $id, 0777, true);
        }
        $config = array(
            'allowed_types' => 'jpg|jpeg|gif|png',
            'upload_path' => $this->path . '/' . $id
        );
        $this->load->library('upload', $config);
        $this->upload->do_upload();
    }

    function do_upload_logo() {
        
    }

    public function get_images($id) {
        $images = array();
        if (is_dir($this->path . '/' . $id)) {
            $files = scandir($this->path . '/' . $id);
            $files = array_diff($files, array('.', '..'));
            foreach ($files as $file) {
                $images [] = array('url' => $this->gallery_path_url . $id . '/' . $file, 'path' => $this->path . '/' . $id . '/' . $file);
            }
        }
        return $images;
    }

    public function helper_image($id) {
        $images = $this->get_images($id);
        if (count($images) == 0)
            $url = 'http://d3mjr4yb15zzlp.cloudfront.net/pictures/404802/small.jpg';
        else
            $url = $images[0]['url'];
        return $url;
    }

    function Udo_upload($id) {
        if (!is_dir($this->path . '/users/' . $id)) {
            mkdir($this->path . '/users/' . $id, 0777, true);
        }
        $config = array(
            'allowed_types' => 'jpg|jpeg|gif|png',
            'upload_path' => $this->path . '/users/' . $id . '/'
        );
        $this->load->library('upload', $config);
        $this->upload->do_upload();
    }

    public function Uget_images($id) {
        $images = array();
        if (is_dir($this->path . '/users/' . $id)) {
            $files = scandir($this->path . '/users/' . $id);
            $files = array_diff($files, array('.', '..'));
            foreach ($files as $file) {
                $images [] = array('url' => $this->gallery_path_url . $id . '/users/' . $file);
            }
        }
        return $images;
    }

    public function profilepic($id, $pos = 0) {
        $query = $this->db->get_where('users', array('id' => $id));
        $q = $query->result();
        $username = $q[0]->username;
        if (strlen($username) > 13)
            $url = 'https://graph.facebook.com/' . $username . '/picture';
        else {
            $images = array();
            if (is_dir($this->path . '/users/' . $id)) {
                $files = scandir($this->path . '/users/' . $id);
                $files = array_diff($files, array('.', '..'));
                foreach ($files as $file) {
                    $db = explode('.', $file);
                    if ($db[1] == 'jpg') {
                        $images [] = array('url' => $this->gallery_path_url . 'users/' . $id . '/' . $file);
                    }
                }

                if (count($images) > 1) {
                    if ($pos == 1) {
                        $url = $this->gallery_path_url . 'users/' . $id . '/userpic_thumb.jpg';
                    } else if ($pos == 2) {
                        $url = $this->gallery_path_url . 'users/' . $id . '/userpic_profile.jpg';
                    } else {
                        $url = $this->gallery_path_url . 'users/' . $id . '/userpic.jpg';
                    }
                } else {
                    if ($pos == 1) {
                        $url = base_url() . 'images/no_avatar_thumb.jpg';
                    } else if ($pos == 2) {
                        $url = base_url() . 'images/captain.png';
                    } else {
                        $url = base_url() . 'images/no_avatar.jpg';
                    }
                }
            } else {
                if ($pos == 1) {
                    $url = base_url() . 'images/no_avatar_thumb.jpg';
                } else if ($pos == 2) {
                    $url = base_url() . 'images/captain.png';
                } else {
                    $url = base_url() . 'images/no_avatar.jpg';
                }
            }
        }
        return $url;
    }

    function gethouserules($id) {
        $query = $this->db->get_where('amnities', array('id' => $id));
        $q = $query->result();
        return $q[0]->manual;
    }

}

?>