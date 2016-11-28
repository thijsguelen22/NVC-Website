<?php
/* Bestand met handige PHP functies */


/* Functies voor validatie van Form Fields */

/** Controleert een email adres op geldigheid
  * @return  boolean
  */
  function is_email($Invoer)
  {
	 return (bool)(preg_match("/^([a-z0-9+_-]+)(.[a-z0-9+_-]+)*@([a-z0-9-]+.)+[a-z]{2,6}$/ix",$Invoer));
   }


  /** Controleert of een string aan de minimum lengte voldoet
  * @return  boolean
  */
  function is_minlength($Invoer, $MinLengte)
  {
	return (strlen($Invoer) >= (int)$MinLengte);
  }

  /** Controleert of invoer een NL postcode is
  * @return  boolean
  */
  function is_NL_PostalCode($Invoer)
  {
	return (bool)(preg_match('#^[1-9][0-9]{3}\h*[A-Z]{2}$#i', $Invoer));
  }

  /** Controleert of invoer een NL telefoonnr is
  * @return  boolean
  */
  function is_NL_Telnr($Invoer)
  {
	return (bool)(preg_match('#^0[1-9][0-9]{0,2}-?[1-9][0-9]{5,7}$#', $Invoer) 
               && (strlen(str_replace(array('-', ' '), '', $Invoer)) == 10));
  }


/** Controleert of invoer alleen uit letters bestaat
  * @return  boolean
  */
  function is_Char_Only($Invoer)
  {
	return (bool)(preg_match("/^[a-zA-Z ]*$/", $Invoer)) ;
  }
  
  function is_num_Only($Invoer)
  {
	return (bool)(preg_match("/^[0-9]*$/", $Invoer)) ;
  }

?>
