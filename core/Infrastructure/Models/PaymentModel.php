<?php

namespace Core\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PaymentModel extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'id', 'name_client', 'cpf', 'description', 'amount', 'status', 'payment_method', 'paid_at'
    ];

    protected $casts = [
        'id' => 'string',
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }
}
