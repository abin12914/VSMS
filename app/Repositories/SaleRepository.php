<?php

namespace App\Repositories;

use App\Models\Sale;
use Exception;
use App\Exceptions\AppCustomException;

class SaleRepository
{
    public $repositoryCode, $errorCode = 0;

    public function __construct()
    {
        $this->repositoryCode = config('settings.repository_code.SaleRepository');
    }

    /**
     * Return sales.
     */
    public function getSales($params=[], $relationalParams=[], $noOfRecords=null)
    {
        $sales = [];

        try {
            $sales = Sale::with(['transaction.debitAccount', 'products'])->active();

            foreach ($params as $param) {
                if(!empty($param) && !empty($param['paramValue'])) {
                    $sales = $sales->where($param['paramName'], $param['paramOperator'], $param['paramValue']);
                }
            }

            foreach ($relationalParams as $param) {
                if(!empty($param) && !empty($param['paramValue'])) {
                    $sales = $sales->whereHas($param['relation'], function($qry) use($param) {
                        $qry->where($param['paramName'], $param['paramValue']);
                    });
                }
            }

            if(!empty($noOfRecords) && $noOfRecords > 0) {
                $sales = $sales->paginate($noOfRecords);
            } else {
                $sales= $sales->get();
            }
        } catch (Exception $e) {
            if($e->getMessage() == "CustomError") {
                $this->errorCode = $e->getCode();
            } else {
                $this->errorCode = $this->repositoryCode + 1;
            }
            throw new AppCustomException("CustomError", $this->errorCode);
        }

        return $sales;
    }

    /**
     * Action for saving sales.
     */
    public function saveSale($inputArray, $sale=null)
    {
        $saveFlag   = false;

        try {
            //sale saving
            if(empty($sale)) {
                $sale = new Sale;
            }
            $sale->transaction_id   = $inputArray['transaction_id'];
            $sale->date             = $inputArray['date'];
            $sale->voucher_id       = $inputArray['voucher_id'];
            $sale->customer_name    = $inputArray['customer_name'];
            $sale->customer_phone   = $inputArray['customer_phone'];
            $sale->description      = $inputArray['description'];
            $sale->discount         = $inputArray['discount'];
            $sale->total_amount     = $inputArray['total_amount'];
            $sale->status           = 1;
            //sale save
            $sale->save();

            $sale->products()->sync($inputArray['productsArray']);

            $saveFlag = true;
        } catch (Exception $e) {
            if($e->getMessage() == "CustomError") {
                $this->errorCode = $e->getCode();
            } else {
                $this->errorCode = $this->repositoryCode + 2;
            }
            throw new AppCustomException("CustomError", $this->errorCode);
        }

        if($saveFlag) {
            return [
                'flag'  => true,
                'id'    => $sale->id,
            ];
        }
        return [
            'flag'      => false,
            'errorCode' => $this->repositoryCode + 3,
        ];
    }

    /**
     * return sale.
     */
    public function getSale($id)
    {
        $sale = [];

        try {
            $sale = Sale::with(['transaction.debitAccount', 'products'])->active()->findOrFail($id);
        } catch (Exception $e) {
            if($e->getMessage() == "CustomError") {
                $this->errorCode = $e->getCode();
            } else {
                $this->errorCode = $this->repositoryCode + 4;
            }
            
            throw new AppCustomException("CustomError", $this->errorCode);
        }

        return $sale;
    }

    public function deleteSale($id, $forceFlag=false)
    {
        $deleteFlag = false;

        try {
            //get sale
            $sale = $this->getSale($id);

            //force delete or soft delete
            //related models will be deleted by deleting event handlers
            if($forceFlag) {
                $sale->forceDelete();
            } else {
                $sale->delete();
            }
            
            $deleteFlag = true;
        } catch (Exception $e) {
            if($e->getMessage() == "CustomError") {
                $this->errorCode = $e->getCode();
            } else {
                $this->errorCode = $this->repositoryCode + 5;
            }
            
            throw new AppCustomException("CustomError", $this->errorCode);
        }

        if($deleteFlag) {
            return [
                'flag'  => true,
                'force' => $forceFlag,
            ];
        }

        return [
            'flag'          => false,
            'errorCode'    => $this->repositoryCode + 6,
        ];
    }
}
