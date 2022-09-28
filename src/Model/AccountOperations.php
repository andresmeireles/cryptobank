<?php

namespace Cryptocli\Model;

enum AccountOperations: int
{
    case DEPOSIT = 1;
    case WITHDRAW = 2;
    case TRANSFERENCE = 3;
}
