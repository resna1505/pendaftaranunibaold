<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

class Cookie implements IApplicationContextAware
{

    private $appContext;

    public function setAppContext( $appContext )
    {
        $this->appContext = $appContext;
    }

    public function &createSetCookieAction( $name, $value )
    {
        require_once( "miscellaneous/Cookie_SetCookieAction.php" );
        $cookie_data_source = new CookieDataSource( );
        $cookie_data_source->setAppContext( $this->appContext );
        $action = new Cookie_SetCookieAction( $cookie_data_source, $name, $value );
        $action->setCookieMaxSize( $this->appContext->getSystemSettings( "COOKIE_MAX_SIZE" ) );
        return $action;
    }

}

?>
