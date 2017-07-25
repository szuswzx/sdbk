<?php

class Upload extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    public function index()
    {
        $this->load->view('upload/upload_form', array('error' => ' ' ));
    }

    public function do_upload()
    {
        $config['upload_path'] = './public/';
		$config['file_name'] = time();
        $config['allowed_types'] = 'jpg|png';
        $config['max_size'] = 1024;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('userfile'))
        {
            $error = array('error' => $this->upload->display_errors());

            $this->load->view('upload/upload_form', $error);
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
			$token = "u6_QKgMC9bqjrNgrETMVzU8yc5CMOpfkFCImZ9jczZIQbNk3Pinn6eDPJ3sZAJ1qPBx11n--W8Gu0nA6IacClO_-jCepjYTGFwl414DeNYkew9g6m-U55B1Vo_V2uH4LFFXbAGAYYQ";
			$url = "https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token=".$token;
			$filename = $data['upload_data']['full_path'];//$_SERVER['DOCUMENT_ROOT'].
			$data=array("media" => new CURLFile(realpath($filename)));
			$res=$this->https_request( $url ,'post', 'json', $data);
			//dump($res); exit();
			echo $res['url'];
            //$this->load->view('upload/upload_success', $data);
			exit();
        }
    }
	public function https_request($url,$type="get",$res="json",$data = ''){
        //1.初始化curl
        $curl = curl_init();
        //2.设置curl的参数
		curl_setopt ($curl, CURLOPT_SAFE_UPLOAD, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,2);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        if ($type == "post"){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        //3.采集
        $output = curl_exec($curl);
        //4.关闭
        curl_close($curl);
        if ($res == 'json') {
            return json_decode($output,true);
        }
    }
}
?>