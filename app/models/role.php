<?php

namespace App\Models;

enum Role
{
    case customer;
    case business;
    case admin;
}
