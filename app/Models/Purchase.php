<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $guarded = ['id'];

    public function products()
    {
        return $this->belongsToMany(Product::class )->withPivot('qtd', 'price');
    }

    public function getStatus($status)
    {
        $statusArray = [
            1 => 'Aguardando Pagamento',
            2 => 'Pago',
            3 => 'Cancelado',
        ];

        return $statusArray[$status];
    }

    public function getPaymentMethod($paymentMethod)
    {
        $paymentMethodArray = [
            1 => 'Avista',
            2 => 'Boleto',
            3 => 'Cartão',
        ];

        return $paymentMethodArray[$paymentMethod];
    }

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }


    public function getPurchasesDay()
    {
        return $this->whereDay('date',date('d'))
            ->count();
    }

    public function getPurchasesMonth()
    {
        return $this->whereMonth('date',date('m'))
            ->count();
    }
}
