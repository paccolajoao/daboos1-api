<?php

namespace App\Validation;

class UserValidation
{
    public static array $create_user = [
        'username' => [
            'rules' => 'required|max_length[50]|min_length[6]|is_unique[user.username]',
            'errors' => [
                'required' => 'You must choose a Username.',
                'max_length' => 'Max length is 30 characters.',
                'min_length' => 'Min length is 6 characters.',
                'is_unique' => 'This username is already registered.'
            ],
        ],
        'password' => [
            'rules' => 'required|max_length[30]|min_length[10]',
            'errors' => [
                'valid_email' => 'You must choose a Password.',
                'max_length' => 'Max length is 254 characters.',
                'min_length' => 'Min length is 10 characters.'
            ],
        ],
        'status' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'You must choose a Status.',
            ],
        ],
        'name' => [
            'rules' => 'required|max_length[100]|min_length[10]',
            'errors' => [
                'valid_email' => 'You must choose a Name.',
                'max_length' => 'Max length is 254 characters.',
                'min_length' => 'Min length is 10 characters.'
            ],
        ],
        'email' => [
            'rules' => 'required|max_length[50]|valid_email|is_unique[user.email]',
            'errors' => [
                'required' => 'Please check the Email field. It does not appear to be valid.',
                'max_length' => 'Max length is 254 characters.',
                'valid_email' => 'Please check the Email field. It does not appear to be valid.',
                'is_unique' => 'This email is already registered.'
            ],
        ]
    ];
}
