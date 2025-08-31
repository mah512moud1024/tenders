<?php

namespace App;

enum RolesEnum: string
{
    case Admin = 'admin';
    case User = 'user';
    case Contractor = 'contractor';
    case Supplier = 'supplier';
    case Consultant = 'consultant';


}
