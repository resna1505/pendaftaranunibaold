<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( is_array( $_POST ) )
{
    foreach ( $_POST as $k => $v )
    {
        if ( is_array( $v ) )
        {
            $$k = stripcar_array( $v );
        }
        else
        {
            $$k = stripcar( $v );
        }
    }
}
?>
