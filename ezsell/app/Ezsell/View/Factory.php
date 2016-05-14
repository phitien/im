<?php

namespace App\Ezsell\View;

use Illuminate\View\Factory as BaseFactory;
use App\Ezsell\View\Html\Menu\Menu;
use App\Ezsell\View\Html\Menu\MenuItem;
use App\Ezsell\Models\Cat;
use App\Ezsell\Traits\AllTrait;

class Factory extends BaseFactory {
	/**
	 * TRAITS
	 */
	use AllTrait;
	/**
	 *
	 * @var bool
	 */
	public $requireOriginalRendering = false;
	/**
	 * Get the evaluated view contents for the given view.
	 *
	 * @param string $view        	
	 * @param array $data        	
	 * @param array $mergeData        	
	 * @return \Illuminate\Contracts\View\View
	 */
	public function make($view, $data = [], $mergeData = []) {
		// addon to add some default options to view
		$data = $this->preProcessData ( $data );
		return parent::make ( $view, $data, $mergeData );
	}
	/**
	 *
	 * @param array $data        	
	 * @return array
	 */
	protected function preProcessData($data = []) {
		if (! $this->requireOriginalRendering) {
			$isGuest = ( bool ) static::getUser ()->isGuest ();
			$data ['isGuest'] = $isGuest;
			$data ['user'] = static::getUser ();
			$data ['theme'] = 'south-street';
			$data ['cats'] = Cat::getHierarchy ();
			$data ['location'] = static::getLocation ();
			$data ['currencySign'] = $data ['location']->currency;
			
			if (! isset ( $data ['appMessage'] ))
				$data ['appMessage'] = '';
			$menu = (new Menu ())->setClassName ( 'nav' );
			if ($isGuest) {
				$menu->addChild ( (new MenuItem ())->setText ( 'Login' )->setAttribute ( 'onClick', 'showLoginForm(this)' ) );
				$menu->addChild ( (new MenuItem ())->setText ( 'Register' )->setAttribute ( 'onClick', 'showRegistrationForm(this)' ) );
				$menu->addChild ( (new MenuItem ())->setText ( 'Location' )->setAttribute ( 'onClick', 'showLocationForm(this)' ) );
				// $menu->addChild ( (new MenuItem ())->setText ( 'Code' )->setHref ( '/code' ) );
			} else {
				$menu->addChild ( (new MenuItem ())->setText ( 'New' )->setHref ( '/newitem' ) );
				$moreMenuItem = (new MenuItem ())->setText ( 'More' )->setAttribute ( 'onClick', 'expandMenu(this, "menu-toggle")' );
				$menu->addChild ( $moreMenuItem );
				$moreMenu = (new Menu ())->setClassName ( 'menu-toggle more-nav' );
				$moreMenu->addChild ( (new MenuItem ())->setText ( 'Password' )->setHref ( '/password' ) );
				$moreMenu->addChild ( (new MenuItem ())->setText ( 'Profile' )->setHref ( '/profile' ) );
				$moreMenu->addChild ( (new MenuItem ())->setText ( 'Email' )->setHref ( '/email' ) );
				$moreMenu->addChild ( (new MenuItem ())->setText ( 'Account' )->setHref ( '/account' ) );
				$moreMenu->addChild ( (new MenuItem ())->setText ( 'Deactivate' )->setHref ( '/deactivate' ) );
				$moreMenu->addChild ( (new MenuItem ())->setText ( 'Location' )->setAttribute ( 'onClick', 'showLocationForm(this)' ) );
				$moreMenu->addChild ( (new MenuItem ())->setText ( 'Logout' )->setHref ( '/logout' ) );
				$moreMenuItem->addChild ( $moreMenu );
			}
			$data ['menu'] = $menu;
		}
		return $data;
	}
	/**
	 *
	 * @param unknown $view        	
	 * @param array $data        	
	 * @param array $mergeData        	
	 */
	public function create($view, $data = [], $mergeData = []) {
		$this->requireOriginalRendering = true;
		$view = $this->make ( $view, $data, $mergeData );
		return $view;
	}
}
