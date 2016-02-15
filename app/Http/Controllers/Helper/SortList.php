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
																						'Urutkan nama A ke Z',
																						'Urutkan nama Z ke A'
																					],
																	'code'		=>	[
																						'name-asc',
																						'name-desc'
																					],																					
																],
												'harga'		=>	[
																	'subtitle'	=>	[
																						'Urutkan harga rendah ke tinggi',
																						'Urutkan harga tinggi ke rendah',
																					],
																	'code'		=> 	[
																						'price-asc',
																						'price-desc',
																					]
																],
												'stok'		=> 	[
																	'subtitle'	=>	[
																						'Urutkan stok sedikit ke banyak',
																						'Urutkan stok banyak ke sedikit', 
																					],
																	'code'		=> 	[
																						'stock-asc',
																						'stock-desc',
																					]
																],
												'label'		=> 	[
																	'subtitle'	=>	[
																						'Urutkan dari A ke Z',
																						'Urutkan dari Z ke A', 
																					],
																	'code'		=> 	[
																						'label-asc',
																						'label-desc',
																					]
																],																	
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