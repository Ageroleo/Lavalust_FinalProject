<?php
class UserModel extends Model
{
    protected $table = 'users';

    public function findByEmail($email)
    {
        return $this->db->table($this->table)
            ->where('email', $email)
            ->get();
    }

    public function allUsers()
    {
        return $this->db->table($this->table)
            ->order_by('id', 'DESC')
            ->get_all();
    }

    public function findUser($id)
    {
        return $this->db->table($this->table)
            ->where('id', $id)
            ->get();
    }

    public function createUser($data)
    {
        return $this->db->table($this->table)->insert($data);
    }

    public function updateUser($id, $data)
    {
        return $this->db->table($this->table)->where('id', $id)->update($data);
    }

    public function deleteUser($id)
    {
        return $this->db->table($this->table)->where('id', $id)->delete();
    }
}
