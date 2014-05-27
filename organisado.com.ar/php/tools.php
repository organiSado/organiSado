<?php

function array_insert($item, $pos, $in)
{
	$out = array();

	if (is_array($in))
	{	
		foreach ($in as $i=>$in_item)
		{
			if ($i == $pos) $out[] = $item;
			$out[] = $in_item;									
		}

	}
	
	return $out;
}

?>