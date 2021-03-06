<?php
namespace Simexis\Econt\Models;

use Config;

use Illuminate\Database\Eloquent\Model;
use Simexis\Econt\Exceptions\EcontException;
use Simexis\Econt\ImportInterface;

class Office extends Model implements ImportInterface
{

    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = null;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'econt_offices';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['*'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Attributes dynamically-appended to the model
     * @var array
     */
    protected $appends = [];

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->setConnection(Config::get('econt.connection'));
    }

    public function settlement()
    {
        return $this->belongsTo('Simexis\Econt\Models\Settlement', 'city_id');
    }

    public function neighbourhood()
    {
        $this->belongsTo('Simexis\Econt\Models\Neighbourhood');
    }

    public function street()
    {
        $this->belongsTo('Simexis\Econt\Models\Street');
    }

    public function validateImport(array $data)
    {
        if (empty($data)) {
            return false;
        }

        $keys = [
            'id',
            'name',
            'name_en',
            'office_code',
            'address',
            'address_en',
            'id_city',
            'city_name',
            'city_name_en',
            'latitude',
            'longitude',
            'address_details',
            'phone',
            'work_begin',
            'work_end',
            'work_begin_saturday',
            'work_end_saturday',
            'time_priority',
            'updated_time',
        ];

        foreach ($keys as $key) {
            if (!isset($data[$key])) {
                return false;
            }
        }

        $details_keys = [
            'id_quarter',
            'quarter_name',
            'id_street',
            'street_name',
            'num',
            'bl',
            'vh',
            'et',
            'ap',
            'other'
        ];

        foreach ($details_keys as $key) {
            if (!isset($data['address_details'][$key])) {
                return false;
            }
        }

        if (0 >= (int)$data['id'] || 0 >= (int)$data['id_city']) {
            return false;
        }

        return true;
    }

    public function import(array $data)
    {
        if (!$this->validateImport($data)) {
            return;
        }

        $this->id = (int)$data['id'];
        $this->name = $data['name'] ?: '';
        $this->name_en = $data['name_en'] ?: '';
        $this->code = (int)$data['office_code'] ?: null;
        $this->address = $data['address'] ?: '';
        $this->address_en = $data['address_en'] ?: '';
        $this->city_id = (int)$data['id_city'];
        $this->city = $data['city_name'] ?: '';
        $this->city_en = $data['city_name_en'] ?: '';
        $this->neighbourhood_id = (int)$data['address_details']['id_quarter'] ?: null;
        $this->neighbourhood = $data['address_details']['quarter_name'] ?: null;
        $this->street_id = (int)$data['address_details']['id_street'] ?: null;
        $this->street = $data['address_details']['street_name'] ?: null;
        $this->street_num = $data['address_details']['num'] ?: null;
        $this->bl = $data['address_details']['bl'] ?: null;
        $this->vh = $data['address_details']['vh'] ?: null;
        $this->et = $data['address_details']['et'] ?: null;
        $this->ap = $data['address_details']['ap'] ?: null;
        $this->other = $data['address_details']['other'] ?: null;
        $this->phone = $data['phone'] ?: null;
        $this->work_begin = $data['work_begin'] && '00:00:00' != $data['work_begin'] ? $data['work_begin'] : null;
        $this->work_end = $data['work_end'] && '00:00:00' != $data['work_end'] ? $data['work_end'] : null;
        $this->work_begin_saturday = $data['work_begin_saturday'] && '00:00:00' != $data['work_begin_saturday'] ? $data['work_begin_saturday'] : null;
        $this->work_end_saturday = $data['work_end_saturday'] && '00:00:00' != $data['work_end_saturday'] ? $data['work_end_saturday'] : null;
        $this->priority = $data['time_priority'] && '00:00:00' != $data['time_priority'] ? $data['time_priority'] : null;
        $this->updated_time = $data['updated_time'] && '0000-00-00 00:00:00' != $data['updated_time'] ? $data['updated_time'] : null;

        if (!$this->save()) {
            throw new EcontException("Error importing office {$this->id}, named {$this->name} with type {$this->type}.");
        }
    }

}