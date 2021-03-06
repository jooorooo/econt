<?php
namespace Simexis\Econt;

use Simexis\Econt\Exceptions\EcontException;

/**
 * Class Endpoint
 * Class with constants, providing end-point addresses to Econt services.
 * @package Simexis\Econt
 * @version 1.0
 * @access public
 */
class Endpoint
{
    const PARCEL = 'http://www.econt.com/e-econt/xml_parcel_import2.php';
    const SERVICE = 'https://www.econt.com/e-econt/xml_service_tool.php';

    const PARCEL_DEMO = 'http://demo.econt.com/e-econt/xml_parcel_import2.php';
    const SERVICE_DEMO = 'http://demo.econt.com/e-econt/xml_service_tool.php';

    public static function parcel()
    {
        return 'production' === env('ECONT_ENV', env('APP_ENV', 'production')) ? self::PARCEL : self::PARCEL_DEMO;
    }

    public static function service()
    {
        return 'production' === env('ECONT_ENV', env('APP_ENV', 'production')) ? self::SERVICE : self::SERVICE_DEMO;
    }

}