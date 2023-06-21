<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property string $name 
 * @property string $code 
 * @property string $company 
 * @property string $telephone 
 * @property string $address 
 * @property string $email 
 * @property int $status 
 * @property int $user_id 
 * @property int $warehouse_id 
 * @property string $create_time 
 */
class LrOwner extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lr_owner';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'status' => 'integer', 'user_id' => 'integer', 'warehouse_id' => 'integer'];
}