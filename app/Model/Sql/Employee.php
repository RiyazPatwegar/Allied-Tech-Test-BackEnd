<?php
namespace App\Model\Sql;

use Illuminate\Database\Eloquent\Model;

/**
 * Model for Orgnization Detail Table
 *
 * @license         <add Licence here>
 * @link            https://github.com/riyazpatwegar
 * @author          Riyaz Patwegar
 * @since           Sep 29, 2020
 * @copyright       2020 <https://github.com/riyazpatwegar>
 * @version         1.0
 */
class Employee extends Model
{
    
    /** @var string Table Name */
    protected $table = 'employee';

    /** @var bool Enable/Disable Timestamp */
    public $timestamps = false;
}