<?php
namespace Sleek\PostTypes;

class Attachment extends PostType {
	public function config () {
		return [
			'taxonomies' => ['media_category']
		];
	}
}
