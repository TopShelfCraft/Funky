<?php
namespace TopShelfCraft\Funky;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;

class TwigExtension extends AbstractExtension implements GlobalsInterface
{

	function getFilters(): array
	{
		return [
			'fn' => new TwigFilter('fn', function($stash, $fn, $callable = null) {
				if (is_callable($fn))
				{
					return $fn;
				}
				if (is_callable($callable))
				{
					$name = (string)$fn;
					$stash->$name = $callable;
				}
			}),
		];
	}

	function getGlobals(): array
	{
		return [
			'funky' => Funky::getInstance(),
			'fns' => Funky::getInstance(),
		];
	}

}
