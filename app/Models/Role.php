<?php

namespace App\Models;

enum Role: int
{
    case User = 0;
    case Worker = 50;
    case Admin = 100;
}
