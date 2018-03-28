<?php
namespace App\Interfaces;

interface Error 
{
    const DATA_FETCH_ERROR = '1001';
    const DATA_FORMAT_ERROR = '1002';

    // Cart
    const CART_NUM_WRONG = '2001';
    const CART_ID_WRONG = '2002';
}