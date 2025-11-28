<?php
class UserModel extends Model
{
    protected $table = 'users';
    protected $columnCache = [];

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

    public function searchUsers($search = '', $limit = 10, $offset = 0)
    {
        // Get table name with prefix
        $this->db->table($this->table);
        $reflection = new ReflectionClass($this->db);
        $tableProperty = $reflection->getProperty('table');
        $tableProperty->setAccessible(true);
        $fullTableName = $tableProperty->getValue($this->db);
        
        // Build WHERE conditions and bind values
        $whereParts = [];
        $bindValues = [];
        
        // Exclude admin users
        $whereParts[] = 'role != ?';
        $bindValues[] = 'admin';
        
        // Add search conditions if provided
        if (!empty($search)) {
            $whereParts[] = '(fullname LIKE ? OR email LIKE ?)';
            $bindValues[] = '%' . $search . '%';
            $bindValues[] = '%' . $search . '%';
        }
        
        $whereClause = 'WHERE ' . implode(' AND ', $whereParts);
        $sql = "SELECT * FROM `{$fullTableName}` {$whereClause} ORDER BY id DESC LIMIT {$offset}, {$limit}";
        
        $stmt = $this->db->raw($sql, $bindValues);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countUsers($search = '')
    {
        // Get table name with prefix
        $this->db->table($this->table);
        $reflection = new ReflectionClass($this->db);
        $tableProperty = $reflection->getProperty('table');
        $tableProperty->setAccessible(true);
        $fullTableName = $tableProperty->getValue($this->db);
        
        // Build WHERE conditions and bind values
        $whereParts = [];
        $bindValues = [];
        
        // Exclude admin users
        $whereParts[] = 'role != ?';
        $bindValues[] = 'admin';
        
        // Add search conditions if provided
        if (!empty($search)) {
            $whereParts[] = '(fullname LIKE ? OR email LIKE ?)';
            $bindValues[] = '%' . $search . '%';
            $bindValues[] = '%' . $search . '%';
        }
        
        $whereClause = 'WHERE ' . implode(' AND ', $whereParts);
        $sql = "SELECT COUNT(*) as count FROM `{$fullTableName}` {$whereClause}";
        
        $stmt = $this->db->raw($sql, $bindValues);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)($result['count'] ?? 0);
    }

    public function findUser($id)
    {
        return $this->db->table($this->table)
            ->where('id', $id)
            ->get();
    }

    public function findByVerificationToken($token)
    {
        if (!$this->columnExists('verification_token')) {
            return null;
        }

        return $this->db->table($this->table)
            ->where('verification_token', $token)
            ->get();
    }

    public function createUser($data)
    {
        $data = $this->filterVerificationAttributes($data);
        return $this->db->table($this->table)->insert($data);
    }

    protected function filterVerificationAttributes(array $data)
    {
        $verificationFields = ['verification_token', 'token_expires', 'is_verified'];

        foreach ($verificationFields as $field) {
            if (array_key_exists($field, $data) && !$this->columnExists($field)) {
                unset($data[$field]);
            }
        }

        return $data;
    }

    public function updateUser($id, $data)
    {
        return $this->db->table($this->table)->where('id', $id)->update($data);
    }

    public function deleteUser($id)
    {
        return $this->db->table($this->table)->where('id', $id)->delete();
    }

    public function markEmailVerified($userId)
    {
        $payload = [];

        if ($this->columnExists('is_verified')) {
            $payload['is_verified'] = 1;
        }

        if ($this->columnExists('verification_token')) {
            $payload['verification_token'] = null;
        }

        if ($this->columnExists('token_expires')) {
            $payload['token_expires'] = null;
        }

        if (empty($payload)) {
            return true;
        }

        return (bool)$this->update($userId, $payload);
    }

    protected function columnExists($column)
    {
        if (isset($this->columnCache[$column])) {
            return $this->columnCache[$column];
        }

        $databaseConfig = database_config()['main'] ?? [];
        $driver = strtolower($databaseConfig['driver'] ?? '');
        $sql = '';
        $params = [];

        switch ($driver) {
            case 'pgsql':
            case 'postgres':
            case 'postgresql':
                $sql = "SELECT column_name FROM information_schema.columns WHERE table_schema = current_schema() AND table_name = ? AND column_name = ?";
                $params = [$this->table, $column];
                break;
            case 'mysql':
            case 'mysqli':
                $sql = "SELECT column_name FROM information_schema.columns WHERE table_schema = ? AND table_name = ? AND column_name = ?";
                $params = [$databaseConfig['database'] ?? '', $this->table, $column];
                break;
            default:
                $sql = "SELECT column_name FROM information_schema.columns WHERE table_name = ? AND column_name = ?";
                $params = [$this->table, $column];
                break;
        }

        try {
            $stmt = $this->db->raw($sql, $params);
            $exists = (bool)$stmt->fetchColumn();
        } catch (\Exception $e) {
            $exists = false;
        }

        return $this->columnCache[$column] = $exists;
    }
}
