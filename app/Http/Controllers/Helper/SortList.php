<?php 
namespace App\Http\Controllers\Helper;

/**
 * Handle admin resource
 * 
 * @author budi
 */
	
class sortList
{
	protected $sorts;

	public function __construct()
	{
		$this->sorts 					= 	[
												'nama'	=> 	[
																	'subtitle'	=>	[
																						'Urutkan berdasarkan nama A-Z',
																						'Urutkan berdasarkan nama Z-A'
																					],
																	'code'		=>	[
																						'name-asc',
																						'name-desc'
																					],																					
																],
												'harga'		=>	[
																	'subtitle'	=>	[
																						'Urutkan berdasarkanharga paling rendah',
																						'Urutkan berdasarkan harga paling tinggi',
																					],
																	'code'		=> 	[
																						'price-asc',
																						'price-desc',
																					]
																],
												'stok'		=> 	[
																	'subtitle'	=>	[
																						'Urutkan berdasarkan stok paling sedikit',
																						'Urutkan berdasarkan stok paling banyak', 
																					],
																	'code'		=> 	[
																						'stock-asc',
																						'stock-desc',
																					]
																]					
											];
	}

	public function getSortingList($name)
	{
		return $this->sorts[$name];
	}

	public function enumerateFromList()
	{

	} 
}