<?php

declare(strict_types=1);

namespace App\Services;

class InvoiceService
{
    public function __construct(
        protected SaleTaxService $saleTaxService,
        protected GatewayService $gatewayService,
        protected EmailService $emailService
    )
    {
    }

    public function process(array $customer, float $amout): bool
    {
        $tax = $this->saleTaxService->calculate($amout, $customer);

        if(! $this->gatewayService->charge($customer, $amout, $tax)) {
            return false;
        }

        $this->emailService->sendEmail($customer, 'receipt');

        return true;
    }


}