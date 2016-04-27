<?php

namespace App\Ezsell\View\Html\Menu;

use App\Ezsell\View\Html\Dom\ul;
use App\Ezsell\View\Html\Dom\IElement;

class Menu extends ul {
	protected function insertChild(IElement $child, bool $buildChildrenHtml = true) {
		if ($child instanceof MenuItem) {
			return parent::insertChild ( $child, $buildChildrenHtml );
		}
		return $this;
	}
}
