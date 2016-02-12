<?php 
namespace App\API\Connectors;

class APISendMail extends APIData 
{
	function __construct() 
	{
		parent::__construct();

		$this->api->timeout 				= 10;
	}

	public function invoice($invoice, $store)
	{
		$this->apiUrl 						= '/mail/invoice';

		$this->apiData 						= array_merge($this->apiData, ["invoice" => $invoice, "store" => $store]);

		return $this->post();
	}	

	public function paidorder($order, $store)
	{
		$this->apiUrl 						= '/mail/paid';

		$this->apiData 						= array_merge($this->apiData, ["order" => $order, "store" => $store]);

		return $this->post();
	}

	public function shippingorder($order, $store)
	{
		$this->apiUrl 						= '/mail/shipped';

		$this->apiData 						= array_merge($this->apiData, ["order" => $order, "store" => $store]);

		return $this->post();
	}

	public function deliveredorder($order, $store)
	{
		$this->apiUrl 						= '/mail/delivered';

		$this->apiData 						= array_merge($this->apiData, ["order" => $order, "store" => $store]);

		return $this->post();
	}
	
	public function cancelorder($order, $store)
	{
		$this->apiUrl 						= '/mail/canceled';

		$this->apiData 						= array_merge($this->apiData, ["order" => $order, "store" => $store]);

		return $this->post();
	}	
}