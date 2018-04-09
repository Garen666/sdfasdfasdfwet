<?php
class PaymentService extends ServiceUtils_AbstractService {

    public function getAllPaymentsList() {
        $payments = new XPaymentList();
        $payments->setHidden(0);
        return $payments;
    }
}