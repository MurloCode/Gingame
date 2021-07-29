<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
	public function getFilters(): array
	{
		return [
			// If your filter generates SAFE HTML, you should add a third
			// parameter: ['is_safe' => ['html']]
			// Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
			new TwigFilter('oShuffle', function ($object) {
				$shuffle = [];
				foreach($object as $object) {
					array_push($shuffle, $object);
				}
				shuffle($shuffle);
				return $shuffle;
			})
		];
	}

	public function getFunctions(): array
	{
		return [
			new TwigFunction('function_name', [$this, 'doSomething']),
		];
	}

	public function doSomething($value)
	{
		// ...
	}
}
