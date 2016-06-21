<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {
	function __construct() {
       parent::__construct();
       $this->load->model('md_paket', 'paket');
       $this->load->model('md_itinerary', 'itinerary');
       $this->load->model('md_gallery', 'gallery');
       $this->load->model('md_item', 'item');
   }
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->helper('url');
		$data = array();
		$data["CartItems"] = $this->cart->total_items();
		$this->load->view('cart_v',$data);
	}
	
	public function buy($id)
	{
		$product = $this->paket->get_paket_by_id($id);
		$data = array(
				'id'      => $product->id,
				'qty'     => 1,
				'price'   => $product->price,
				'name'    => $product->nama_paket,
				'options' => array('currency' => $product->currency,'coupon' => '')
		);

		$this->cart->insert($data);
		$data = array();
		$data["CartItems"] = $this->cart->total_items();
		$this->load->view('cart_v',$data);
	}
	
	public function Delete($rowid){
		$this->cart->update(array('rowid'=> $rowid,'qty' => 0));
		$data = array();
		$data["CartItems"] = $this->cart->total_items();
		$this->load->view('cart_v',$data);
	}
	
	public function UpdateCart(){
		$i = 1;
		foreach($this->cart->contents() as $items){
			$this->cart->update(array('rowid'=> $items["rowid"],'qty' => $_POST['qty'.$i]));
			$i++;	
		}
		$data = array();
		$data["CartItems"] = $this->cart->total_items();
		$this->load->view('cart_v',$data);
		//echo $_POST["coupon_code"];
	}
	
}
