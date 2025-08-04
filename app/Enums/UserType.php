<?php

namespace App\Enums;

enum UserType: string
{
    case Seller = 'seller';
    case Agent = 'agent';
    case Agency = 'agency';
    case Admin = 'admin';
    case User = 'user';
    case Buyer = 'buyer';
    case SuperAdmin = 'superadmin';

    public function label(): string
    {
        return match($this) 
        {
            self::Seller => 'Seller',
            self::Agent => 'Property Agent',
            self::Agency => 'Real Estate Agency',
            self::Admin => 'Admin',
            self::SuperAdmin => 'Super Admin',
            self::User => 'User',
            self::Buyer => 'Buyer'
        };
    }

    public function propertyLimit(): int
    {
        return match($this) 
        {
            self::Seller => 10,
            self::Agent => 10,
            self::Agency => 10,
            self::Admin => 10,
            self::SuperAdmin => 10,
            self::User => 10,
            self::Buyer => 10
        };
    }

    public function adsLimit(): int
    {
        return match($this)
        {
            self::Seller => 2,
            self::Agent => 2,
            self::Agency => 2,
            self::Admin => 2,
            self::SuperAdmin => 2,
            self::User => 2,
            self::Buyer => 2
        };
    }
}
