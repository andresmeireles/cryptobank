<?php

namespace CryptoBank\Dto;

enum BalanceOperation: string
{
    case ADD = 'add';
    case MINUS = 'minus';
}
