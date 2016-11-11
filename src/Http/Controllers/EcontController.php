<?php
namespace Simexis\Econt\Http\Controllers;

use Input;

use App\Http\Controllers\Controller;
use Simexis\Econt\Components\Loading;
use Simexis\Econt\Components\Receiver;
use Simexis\Econt\Components\Sender;
use Simexis\Econt\Econt;
use Simexis\Econt\Models\Neighbourhood;
use Simexis\Econt\Models\Office;
use Simexis\Econt\Models\Settlement;
use Simexis\Econt\Models\Street;
use Simexis\Econt\Models\Zone;
use Simexis\Econt\Waybill;

class EcontController extends Controller
{
    public function zones()
    {
        return Zone::orderBy('name')->get();
    }

    public function neighbourhoods()
    {
        return Neighbourhood::orderBy('name')->get();
    }

    public function profile()
    {
        $username = Input::get('username');
        $password = Input::get('password');

        Econt::setCredentials($username, $password);
        return Econt::profile();
    }

    public function company()
    {
        $username = Input::get('username');
        $password = Input::get('password');

        Econt::setCredentials($username, $password);
        return Econt::company();
    }


}