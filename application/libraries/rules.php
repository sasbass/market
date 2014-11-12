<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rules {
    public function updateUserData(){
        $config = array(
			array(
				'field'   => 'data[first_name]',
				'label'   => 'Име',
				'rules'   => 'required|xss_clean'
			),
			array(
				'field'   => 'data[last_name]',
				'label'   => 'Фамилия',
				'rules'   => 'required|xss_clean'
			),
			array(
				'field'   => 'data[username]',
				'label'   => 'Потребителско име',
				'rules'   => 'required|xss_clean'
			),
			array(
				'field'   => 'data[password]',
				'label'   => 'Парола',
				'rules'   => 'md5'
			)
		);
		return $config;
    }
    
    public function addProduct()
	{
		$config = array(
			array(
				'field'   => 'campanies_id',
				'label'   => 'Фирма снабдител',
				'rules'   => 'required|xss_clean'
			),
			array(
				'field'   => 'name',
				'label'   => 'Име на продукт',
				'rules'   => 'required|xss_clean'
			),
			array(
				'field'   => 'barcode',
				'label'   => 'Баркод на продукта',
				'rules'   => 'required'
			),
			array(
				'field'   => 'quality_in',
				'label'   => 'Количество',
				'rules'   => 'required|integer'
			),
			array(
				'field'   => 'delivery_price',
				'label'   => 'Доставна цена',
				'rules'   => 'requiredn'
			),
			array(
				'field'   => 'market_price',
				'label'   => 'Цена в магазина',
				'rules'   => 'required'
			)
		);
		return $config;
	}
    
    public function editProduct()
	{
		$config = array(
			array(
				'field'   => 'campanies_id',
				'label'   => 'Фирма снабдител',
				'rules'   => 'required|xss_clean'
			),
			array(
				'field'   => 'name',
				'label'   => 'Име на продукт',
				'rules'   => 'required|xss_clean'
			),
			array(
				'field'   => 'barcode',
				'label'   => 'Баркод на продукта',
				'rules'   => 'required'
			),
			array(
				'field'   => 'delivery_price',
				'label'   => 'Доставна цена',
				'rules'   => 'requiredn'
			),
			array(
				'field'   => 'market_price',
				'label'   => 'Цена в магазина',
				'rules'   => 'required'
			)
		);
		return $config;
	}
    
    public function addEditCampany(){
        $config = array(
				array(
                    'field'   => 'client[company_name]',
                    'label'   => 'Получател (име на фирмата)',
                    'rules'   => 'required'
				),
				array(
                    'field'   => 'client[company_mol]',
                    'label'   => 'МОЛ',
                    'rules'   => 'required'
				),
				array(
                    'field'   => 'client[company_address_register]',
                    'label'   => 'Адрес (на регистрация)',
                    'rules'   => 'required'
				),
				array(
                    'field'   => 'client[company_ident]',
                    'label'   => 'Булстат',
                    'rules'   => 'requiredn'
				),
				array(
                    'field'   => 'client[company_ident_num]',
                    'label'   => 'Идент. номер по ДДС',
                    'rules'   => 'required'
				),
				array(
                    'field'   => 'client[company_city]',
                    'label'   => 'Град',
                    'rules'   => 'required'
				)
		);
		return $config;
    }


    public function addEditCamanies(){
		$config = array(
				array(
						'field'   => 'name',
						'label'   => 'Име на фирмата',
						'rules'   => 'required'
				),
				array(
						'field'   => 'mol',
						'label'   => 'МОЛ',
						'rules'   => 'required'
				),
				array(
						'field'   => 'address',
						'label'   => 'Адрес',
						'rules'   => 'required'
				),
				array(
						'field'   => 'register_address',
						'label'   => 'Адрес на регистрация',
						'rules'   => 'required'
				),
				array(
						'field'   => 'ident',
						'label'   => 'Булстат',
						'rules'   => 'requiredn'
				),
				array(
						'field'   => 'ident_num',
						'label'   => 'Идент. номер по ДДС',
						'rules'   => 'required'
				),
				array(
						'field'   => 'phone',
						'label'   => 'Телефон за връзка',
						'rules'   => 'required'
				),
				array(
						'field'   => 'email',
						'label'   => 'Email',
						'rules'   => 'required'
				),
				array(
						'field'   => 'city_id',
						'label'   => 'Град',
						'rules'   => 'required'
				)
		);
		return $config;
	}
}