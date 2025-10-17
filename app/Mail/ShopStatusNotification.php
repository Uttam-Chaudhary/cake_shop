<?php

namespace App\Mail;


use App\Models\Shop;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShopStatusNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $shop;
    public $company;


    public function __construct(Shop $shop, $company)
    {
        $this->shop = $shop;
        $this->company = $company;
    }

    public function build()
    {
        return $this->subject('Shop Status Update')
            ->view('mail.shop-inactive-notification')
            ->with([
                'shop' => $this->shop,
                'company' => $this->company,
            ]);
    }
}

