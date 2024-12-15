<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{

    private function __construct(private User $user)
    {
    }

    /**
     * @param array $options
     * @return array|LengthAwarePaginator
     */
    public function index()
    {

      return  $this->user->selectUsers();

    }

    /**
     * @param string $id
     * @return object
     */
    public function show(string $id)
    {
        return $this->findById($id);
    }

    /**
     * @param array $payload
     */
    public function store(array $data)
    {
        return $this->user->create($data);
    }

    /**
     * @param array $data
     * @param string $id
     */
    public function update(array $data, string $id)
    {
        $record = $this->findById($id);
        $record->update($data);
        return $record->refresh();
    }

    /**
     * @param string $id
     * @return object
     */
    public function findById(string $id): object
    {
        return $this->user->findOrFail($id);
    }
    /**
     * @return bool|string|array
     */
    public function destroy($id)
    {
        $record = $this->findById($id);
        return $record->delete();
    }


}
