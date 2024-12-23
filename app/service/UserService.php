<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{

    public function __construct(private User $user)
    {

    }

    /**
     * @param array $options
     * @return array|LengthAwarePaginator
     */
    public function index()
    {
        return $this->user->selectUsers();
    }

    /**
     * @param string $id
     * @return object
     */
    public function show(string $id)
    {
         return $this->user->find($id);
    }

    /**
     * @param array $payload
     */
    public function store(array $data)
    {
        DB::beginTransaction();

        try {
            $data['password'] = Hash::make($data['password']);
            $user = $this->user->create($data); // Cria o usuário

            $phones = $data['phones'] ?? []; // Garante que phones seja um array
            if (!empty($phones)) {
                $this->storePhones($phones, $user); // Associa os telefones ao usuário
            }

            DB::commit();

            return response()->json([
                'data' => $user,
                'message' => 'User created successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function storePhones($phones, $user)
    {
        foreach ($phones as $phone) {
            $user->phones()->create([
                'phone_number' => $phone,
            ]);
        }
    }


    /**
     * @param array $data
     * @param string $id
     */
    public function update(array $data, string $id)
    {
        DB::beginTransaction();

        try {
            $user = $this->user->find($id);
            $userdata = array_intersect_key($data, array_flip(['name', 'email']));
            $user->update($userdata);
            $this->updatePhones($user,$data);
            DB::commit();

            return response()->json([
                'data' => $user,
                'message' => 'User Updated successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function updatePhones($user,$data)
    {

        if (isset($data['phones'])) {

            $userPhones = $user->phones->keyBy('id');


            foreach ($data['phones'] as $phoneData) {

                if (isset($phoneData['id'])) {
                    if (isset($userPhones[$phoneData['id']])) {

                        $userPhones[$phoneData['id']]->update(['phone_number' => $phoneData['phone_number']]);
                    }
                } else {
                    $user->phones()->create(['phone_number' => $phoneData['phone_number']]);
                }
            }
        }
    }


    /**
     * @return bool|string|array
     */
    public function destroy($id)
    {



        try {

            $user = $this->user->find($id);
            $user->delete();

            return response()->json([
                'message' => 'User Deleted successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


}
