<?php
/**
* 
*/
class Calcula_Porcentagem_Ml
{
	
	public function getPorcentagem( $total, $ml )
	{
		$result = '';
		if( $total > 0 )
			$result = $ml / $total * 100;
		else
			$result = 0;
		return $result;
	}
}