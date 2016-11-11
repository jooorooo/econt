<?php
namespace Simexis\Econt;

use App;

use rest\server\user\Load;
use Simexis\Econt\Components\Loading;
use Simexis\Econt\Components\Sender;
use Simexis\Econt\Components\Receiver;
use Simexis\Econt\Components\Shipment;
use Simexis\Econt\Components\Payment;
use Simexis\Econt\Components\Services;
use Simexis\Econt\Exceptions\EcontException;

/**
 * Class Waybill
 * Interface exported by this package to allow creating/issuing new Econt waybills for printing.
 * @package Simexis\Econt
 * @version 1.0
 * @access public
 */
class Waybill
{
    protected static function _call(Loading $loading, $calc)
    {
        $data = [
            'system' => [
                'validate' => 0,
                'response_type' => 'XML',
                'only_calculate' => (int)!!$calc,
            ],

            'loadings' => [
                $loading,
            ],
        ];

        $econt = App::make('Econt');
        $waybill = $econt->request(RequestType::SHIPPING, $data, Endpoint::parcel());

        if(!isset($waybill['result']) || !isset($waybill['result']['e'])) {
            throw new EcontException('Invalid response from Econt parcel service.');
        }

        if(isset($waybill['result']['e']['error']) && $waybill['result']['e']['error']) {
            throw new EcontException(strip_tags(preg_replace('#<br[\s\t\r\n]*/?>#', "\n", $waybill['result']['e']['error'])));
        }

        return $waybill;
    }

    public static function issue(Loading $loading)
    {
        return self::_call($loading, false);
    }

    public static function calculate(Loading $loading)
    {
        return self::_call($loading, true);
    }
}