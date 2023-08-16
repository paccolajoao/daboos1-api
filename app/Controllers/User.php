<?php

namespace App\Controllers;

use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Validation;

class User extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $userModel = model('UserModel');
        $filter    = (array)$this->request->getGet() ?? [];
        // TODO Fazer o filter funcionar na query
        $quantity  = $filter['quantity'] ?? 25;
        $page      = $filter['page'] ?? 1;
        $active    = $filter['active'] ?? false;
        $status    = $filter['status'] ?? '';

        $query     = $userModel->get($quantity, 0)->getResultArray();
        return json_encode($query);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        if ( (empty($id)) || (!is_numeric($id)) ) return $this->failNotFound('Invalid ID');

        $userModel = model('UserModel');
        $user      = $userModel->getWhere(['idUser' => $id])->getResult();

        return json_encode($user);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        return false;
    }

    /**
     * Create a new user, from an API request
     *
     * @return ResponseInterface
     */
    public function create(): ResponseInterface
    {
        $userModel = model('UserModel');
        $data      = (array)$this->request->getJsonVar() ?? [];
        $validated = $this->validateData($data, Validation\UserValidation::$create_user);

        if ($validated) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
            try {
                $userModel->insert($data);
            } catch (DatabaseException $e) {
                return $this->failValidationErrors($e->getMessage());
            } catch (\ReflectionException $e) {
                return $this->failValidationErrors($e->getMessage());
            }
            return $this->respondCreated();
        } else {
            return $this->failValidationErrors($this->validator->getErrors());
        }
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        return false;
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        if ( (empty($id)) || (!is_numeric($id)) ) return $this->failNotFound('Invalid ID');

        try {
            $userModel = model('UserModel');
            $data      = (array)$this->request->getVar() ?? [];
            if (!empty($data['password'])) $data["password"] = password_hash($data['password'], PASSWORD_BCRYPT);

            $updated = $userModel->where('idUser', $id)->set($data)->update();

            if ($updated === true) return $this->respond(["message"=>'User updated successfully'], 200);
            else return $this->failValidationErrors('Error on update user');
        } catch (DatabaseException $e) {
            return $this->failValidationErrors($e->getMessage());
        } catch (\ReflectionException $e) {
            return $this->failValidationErrors($e->getMessage());
        }
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        if ( (empty($id)) || (!is_numeric($id)) ) return $this->failNotFound('Invalid ID');

        $userModel = model('UserModel');

        try {
            $user_exist = $userModel->getWhere(['idUser' => $id])->getResult();
            if (empty($user_exist)) return $this->failNotFound('User not found');

            $deleted = $userModel->where('idUser', $id)->delete();

            if ($deleted === true) return $this->respondDeleted();
            else return $this->failValidationErrors('Error on delete user');
        } catch (DatabaseException $e) {
            return $this->failValidationErrors($e->getMessage());
        }
    }
}