<?php

namespace App\Ezsell\Controllers;

use Illuminate\Http\Request;
use App\Ezsell\Models\Item;
use App\Ezsell\Exceptions\ItemNotFound;
use App\Ezsell\Models\Cat;
use App\Ezsell\Models\Image;

class ItemController extends Controller {
	/**
	 *
	 * @var array $_authenticationMiddlewareOptions
	 */
	protected $_authenticationMiddlewareOptions = [ 
			'except' => [ 
					'index',
					'cat',
					'item' 
			] 
	];
	/**
	 *
	 * @var array $_authorizationMiddlewareOptions
	 */
	protected $_authorizationMiddlewareOptions = [ 
			'except' => [ ] 
	];
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		return $this->response ( view ( 'home' ) );
	}
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function cat(Request $request) {
		return $this->process ( 'cat', func_get_args () );
	}
	protected function pgetCat(Request $request, $id) {
		$cat = Cat::find ( $id );
		if ($cat) {
			return $this->response ( view ( 'item.items', [ 
					'cat' => $cat,
					'items' => $cat->items ()->get () 
			] ) );
		} else {
			throw new ItemNotFound ();
		}
	}
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function newitem(Request $request) {
		return $this->process ( 'newitem', func_get_args () );
	}
	protected function pgetNewitem(Request $request) {
		return $this->response ( view ( 'item.newitem' ) );
	}
	protected function ppostNewitem(Request $request) {
		$data = $request->only ( [ 
				'parent_id',
				'location_id',
				'title',
				'description',
				'is_selling',
				'is_new',
				'originalprice',
				'saleprice',
				'nowprice',
				'meetup_at',
				'meetup_details',
				'mailing_details',
				'groups' 
		] );
		$data ['user_id'] = static::getUser ()->id;
		$data ['location_id'] = static::getLocation ()->id;
		if ($item = Item::create ( $data )) {
			$selectedFiles = $request->get ( 'files-selected' );
			if ($selectedFiles) {
				$titles = $request->get ( 'files-title' );
				$descriptions = $request->get ( 'files-description' );
				foreach ( $request->file ( 'files' ) as $file ) {
					if ($file->isValid ()) {
						$name = $file->getClientOriginalName ();
						$url = $this->restful_upload ( $file );
						$image = new Image ( [ 
								'title' => $titles [$name],
								'description' => $descriptions [$name],
								'url' => $url 
						] );
						$image->item ()->associate ( $item );
						$image->save ();
					}
				}
			}
			return $this->redirect ( "/item/{$item->id}" );
		} else {
			return $this->response ( view ( 'item.newitem', [ 
					'appMessage' => 'Không hiểu sao ko tạo được :(, sorry nha' 
			] ) );
		}
	}
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function item(Request $request) {
		return $this->process ( 'item', func_get_args () );
	}
	protected function pgetItem(Request $request, $id) {
		$item = Item::find ( $id );
		if ($item) {
			return $this->response ( view ( 'item.detail', [ 
					'item' => $item 
			] ) );
		} else {
			throw new ItemNotFound ();
		}
	}
}
