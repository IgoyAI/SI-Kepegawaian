<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['google_id','email','name','role','created_at'];

    protected $validationRules = [
        'google_id' => 'permit_empty|is_unique[users.google_id]',
        'email'     => 'required|valid_email|is_unique[users.email]',
    ];
}
