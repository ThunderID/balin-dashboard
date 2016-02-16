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
												'nama'				=> 	[
																			'subtitle'	=>	[
																								'Urutkan nama A ke Z',
																								'Urutkan nama Z ke A'
																							],
																			'code'		=>	[
																								'name-asc',
																								'name-desc'
																							],																					
																		],
												'harga'				=>	[
																			'subtitle'	=>	[
																								'Urutkan harga rendah ke tinggi',
																								'Urutkan harga tinggi ke rendah',
																							],
																			'code'		=> 	[
																								'price-asc',
																								'price-desc',
																							]
																		],
												'stok'				=> 	[
																			'subtitle'	=>	[
																								'Urutkan stok sedikit ke banyak',
																								'Urutkan stok banyak ke sedikit', 
																							],
																			'code'		=> 	[
																								'stock-asc',
																								'stock-desc',
																							]
																		],
												'label'				=> 	[
																			'subtitle'	=>	[
																								'Urutkan dari A ke Z',
																								'Urutkan dari Z ke A', 
																							],
																			'code'		=> 	[
																								'label-asc',
																								'label-desc',
																							]
																		],	
												'tanggal'			=> 	[
																			'subtitle'	=>	[
																								'Urutkan dari tanggal lama ke baru',
																								'Urutkan dari tanggal baru ke lama',
																							],
																			'code'		=> 	[
																								'newest-asc',
																								'newest-desc',
																							]
																		],
												'nota'				=> 	[
																			'subtitle'	=>	[
																								'Urutkan nomor nota kecil ke besar',
																								'Urutkan nomor nota besar ke kecil',
																							],
																			'code'		=> 	[
																								'refnumber-asc',
																								'refnumber-desc',
																							]
																		],
												'jumlah'			=> 	[
																			'subtitle'	=>	[
																								'Urutkan jumlah kecil ke besar',
																								'Urutkan jumlah besar ke kecil',
																							],
																			'code'		=> 	[
																								'amount-asc',
																								'amount-desc',
																							]
																		],
												'referralcode'		=> 	[
																			'subtitle'	=>	[
																								'Urutkan kode referral A ke Z',
																								'Urutkan kode referral Z ke A',
																							],
																			'code'		=> 	[
																								'referralcode-asc',
																								'referralcode-desc',
																							]
																		],
												'totalreference'	=> 	[
																			'subtitle'	=>	[
																								'Urutkan Total referrance sedikit ke banyak',
																								'Urutkan Total referrance banyak ke sedikit',
																							],
																			'code'		=> 	[
																								'totalreference-asc',
																								'totalreference-desc',
																							]
																		],
												'totalpoint'		=> 	[
																			'subtitle'	=>	[
																								'Urutkan Total poin sedikit ke banyak',
																								'Urutkan Total poin banyak ke sedikit',
																							],
																			'code'		=> 	[
																								'totalpoint-asc',
																								'totalpoint-desc',
																							]
																		],
												'tagihan'			=> 	[
																			'subtitle'	=>	[
																								'Urutkan Total tagihan sedikit ke banyak',
																								'Urutkan Total tagihan banyak ke sedikit',
																							],
																			'code'		=> 	[
																								'bills-asc',
																								'bills-desc',
																							]
																		],
												'kadaluarsa'		=> 	[
																			'subtitle'	=>	[
																								'Urutkan dari tanggal expire lama ke baru',
																								'Urutkan dari tanggal expire baru ke lama',
																							],
																			'code'		=> 	[
																								'expired-asc',
																								'expired-desc',
																							]
																		],
												'kode'				=> 	[
																			'subtitle'	=>	[
																								'Urutkan dari kode A ke Z',
																								'Urutkan dari kode Z ke A',
																							],
																			'code'		=> 	[
																								'code-asc',
																								'code-desc',
																							]
																		],
												'quota'				=> 	[
																			'subtitle'	=>	[
																								'Urutkan dari kuota sedikit ke banyak',
																								'Urutkan dari kuota banyak ke sedikit',
																							],
																			'code'		=> 	[
																								'quota-asc',
																								'quota-desc',
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