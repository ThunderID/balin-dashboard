<?php 
namespace App\Http\Controllers\Toko;

use App\API\Connectors\APISale;
use App\API\Connectors\APISendMail;

use App\Http\Controllers\AdminController;

use Input, Redirect;

/**
 * Handle resend mail
 * 
 * @author cmooy
 */
class ResendMailController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * resend sale
	 * 
	 * @return redirect
	 */
	public function sale($id = 0, $status = '')
	{
		$APISale 					= new APISale;

		$result 					= $APISale->getShow($id);

		if($result['status'] != 'success')
		{
			$this->errors 			= $result['message'];
		}

		$type 						= 'Email';
		$mail 						= new APISendMail;
		
		switch ($status) 
		{
			case 'wait':
					$mail->invoice($result['data'], $this->balininfo());
					$type			= 'Invoice';
				break;
			case 'paid':
					$mail->paidorder($result['data'], $this->balininfo());
					$type			= 'Validasi Pembayaran';
				break;
			case 'shipping':
					$mail->shippingorder($result['data'], $this->balininfo());
					$type			= 'Nota Pengiriman';
				break;
			case 'delivered':
					$mail->deliveredorder($result['data'], $this->balininfo());
					$type			= 'Konfirmasi Pesanan Delivered';
				break;
			case 'canceled':
					$mail->cancelorder($result['data'], $this->balininfo());
					$type			= 'Konfirmasi Pembatalan Pesanan';
				break;
			case 'abandoned':
					$mail->abandoned($result['data'], $this->balininfo());
					$type			= 'Email Pengingat';
				break;
			default:
				$this->errors 		= 'Status tidak valid';
				break;
		}

		$this->page_attributes->success 		= $type." sudah di kirim ";

		$from 						= Input::get('from');

		if($from != null){
			return Redirect::to($from)
				->with('msg','Email pengingat berhasil dikirim.')
				->with('msg-type', 'success')
				;
		} 

		return $this->generateRedirectRoute('report.product.sale', ['id' => $id]);
	}
}
