<?php 
namespace App\API\Connectors;

class APISendMail extends APIData 
{
	function __construct() 
	{
		parent::__construct();

		$this->api->timeout 				= 10;
		$this->api->basic_url				= 'localhost:9000';
	}

	public function invoice($invoice, $store)
	{
		$this->apiUrl 						= '/shop/invoice';

		$this->apiData 						= array_merge($this->apiData, ["invoice" => $invoice, "store" => $store]);

		return $this->post();
	}	

	public function paidorder($order, $store)
	{
		$this->apiUrl 						= '/shop/paid';

		$this->apiData 						= array_merge($this->apiData, ["order" => $order, "store" => $store]);

		return $this->post();
	}

	public function shippingorder($order, $store)
	{
		$this->apiUrl 						= '/shop/shipped';

		$this->apiData 						= array_merge($this->apiData, ["order" => $order, "store" => $store]);

		return $this->post();
	}

	public function deliveredorder($order, $store)
	{
		$this->apiUrl 						= '/shop/delivered';

		$this->apiData 						= array_merge($this->apiData, ["order" => $order, "store" => $store]);

		return $this->post();
	}
	
	public function cancelorder($order, $store)
	{
		$this->apiUrl 						= '/shop/canceled';

		$this->apiData 						= array_merge($this->apiData, ["order" => $order, "store" => $store]);

		return $this->post();
	}	
}