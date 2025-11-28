<?php

class ApplicationModel extends Model
{
    protected $table = "applications";

    /**
     * Save applicant form submission
     */
    public function saveApplication($data)
    {
        // Remove 'id' from data if it exists - primary key should auto-increment
        unset($data['id']);
        
        // Ensure status & submission timestamp exists
        if (!isset($data['status'])) {
            $data['status'] = 'pending';
        }

        if (!isset($data['date_submitted'])) {
            $data['date_submitted'] = date('Y-m-d H:i:s');
        }

        return $this->db->table($this->table)->insert($data);
    }

    /**
     * Fetch all submitted applications
     */
    public function getAll()
    {
        return $this->db->table($this->table)->get_all();
    }

    /**
     * Update applicant status (For admin approval or rejection)
     */
    public function updateStatus($id, $status)
    {
        return $this->db->table($this->table)
            ->where('id', $id)
            ->update(['status' => $status]);
    }

    /**
     * Fetch a single applicant record (optional use: view details)
     */
    public function getById($id)
    {
        return $this->db->table($this->table)
                 ->where('id', $id)
                 ->get();
    }

    public function getApplicationsByUser($userId)
    {
        // Get table name with prefix
        $this->db->table($this->table);
        $reflection = new ReflectionClass($this->db);
        $tableProperty = $reflection->getProperty('table');
        $tableProperty->setAccessible(true);
        $fullTableName = $tableProperty->getValue($this->db);
        
        // Get user email to match applications
        $userModel = new UserModel();
        $user = $userModel->findUser($userId);
        
        if (!$user || !isset($user['email'])) {
            return [];
        }
        
        $userEmail = trim(strtolower($user['email']));
        
        // Get ALL applications for the user by matching both user_id and email
        // Try multiple approaches to ensure we get all applications
        $allResults = [];
        $foundIds = [];
        
        try {
            // Approach 1: Try to match by user_id if column exists
            try {
                $sql = "SELECT * FROM `{$fullTableName}` WHERE id = ? ORDER BY date_submitted DESC, id DESC";
                $stmt = $this->db->raw($sql, [$userId]);
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($results as $result) {
                    if (!in_array($result['id'], $foundIds)) {
                        $allResults[] = $result;
                        $foundIds[] = $result['id'];
                    }
                }
            } catch (Exception $e) {
                // user_id column might not exist, continue
            }
            
            // Approach 2: Match by email (case-insensitive)
            try {
                $sql = "SELECT * FROM `{$fullTableName}` WHERE LOWER(TRIM(email)) = ? ORDER BY date_submitted DESC, id DESC";
                $stmt = $this->db->raw($sql, [$userEmail]);
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($results as $result) {
                    if (!in_array($result['id'], $foundIds)) {
                        $allResults[] = $result;
                        $foundIds[] = $result['id'];
                    }
                }
            } catch (Exception $e) {
                // If LOWER/TRIM doesn't work, try exact match
                try {
                    $sql = "SELECT * FROM `{$fullTableName}` WHERE email = ? ORDER BY date_submitted DESC, id DESC";
                    $stmt = $this->db->raw($sql, [$user['email']]);
                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($results as $result) {
                        if (!in_array($result['id'], $foundIds)) {
                            $allResults[] = $result;
                            $foundIds[] = $result['id'];
                        }
                    }
                } catch (Exception $e2) {
                    // Continue
                }
            }
            
            // Sort all results by date_submitted DESC, then id DESC
            usort($allResults, function($a, $b) {
                $dateA = isset($a['date_submitted']) ? strtotime($a['date_submitted']) : 0;
                $dateB = isset($b['date_submitted']) ? strtotime($b['date_submitted']) : 0;
                if ($dateA != $dateB) {
                    return $dateB - $dateA; // DESC
                }
                return ($b['id'] ?? 0) - ($a['id'] ?? 0); // DESC
            });
            
            return $allResults;
        } catch (Exception $e) {
            error_log("Error fetching applications for user {$userId}: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get application by ID and verify it belongs to the user
     */
    public function getApplicationByUserAndId($userId, $applicationId)
    {
        // Get table name with prefix
        $this->db->table($this->table);
        $reflection = new ReflectionClass($this->db);
        $tableProperty = $reflection->getProperty('table');
        $tableProperty->setAccessible(true);
        $fullTableName = $tableProperty->getValue($this->db);
        
        // Get user email to match applications
        $userModel = new UserModel();
        $user = $userModel->findUser($userId);
        
        if (!$user || !isset($user['email'])) {
            return null;
        }
        
        try {
            // Check if user_id column exists
            $testSql = "SHOW COLUMNS FROM `{$fullTableName}` LIKE 'id'";
            $testStmt = $this->db->raw($testSql);
            $hasUserIdColumn = $testStmt->rowCount() > 0;
            
            if ($hasUserIdColumn) {
                // Try matching by both user_id and email (OR condition)
                $sql = "SELECT * FROM `{$fullTableName}` WHERE id = ? AND (id = ? OR email = ?)";
                $stmt = $this->db->raw($sql, [$applicationId, $userId, $user['email']]);
            } else {
                // Only use email if user_id column doesn't exist
                $sql = "SELECT * FROM `{$fullTableName}` WHERE id = ? AND email = ?";
                $stmt = $this->db->raw($sql, [$applicationId, $user['email']]);
            }
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // Fallback to email matching only
            try {
                $sql = "SELECT * FROM `{$fullTableName}` WHERE id = ? AND email = ?";
                $stmt = $this->db->raw($sql, [$applicationId, $user['email']]);
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (Exception $e2) {
                return null;
            }
        }
    }

    /**
     * Get all applications (alias for getAll for consistency)
     */
    public function getAllApplications()
    {
        return $this->db->table($this->table)
            ->order_by('date_submitted', 'DESC')
            ->get_all();
    }

    /**
     * Get applications for review (pending status)
     */
    public function getApplicationsForReview()
    {
        return $this->db->table($this->table)
            ->where('status', 'pending')
            ->order_by('date_submitted', 'DESC')
            ->get_all();
    }

    /**
     * Get application statistics
     */
    public function getStatistics()
    {
        // Get table name with prefix
        $this->db->table($this->table);
        $reflection = new ReflectionClass($this->db);
        $tableProperty = $reflection->getProperty('table');
        $tableProperty->setAccessible(true);
        $fullTableName = $tableProperty->getValue($this->db);
        
        // Get total count
        $sql = "SELECT COUNT(*) as count FROM `{$fullTableName}`";
        $stmt = $this->db->raw($sql, []);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $total = (int)($result['count'] ?? 0);
        
        // Get pending count
        $sql = "SELECT COUNT(*) as count FROM `{$fullTableName}` WHERE status = ?";
        $stmt = $this->db->raw($sql, ['pending']);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $pending = (int)($result['count'] ?? 0);
        
        // Get approved count
        $sql = "SELECT COUNT(*) as count FROM `{$fullTableName}` WHERE status = ?";
        $stmt = $this->db->raw($sql, ['Approved']);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $approved = (int)($result['count'] ?? 0);
        
        // Get rejected count
        $sql = "SELECT COUNT(*) as count FROM `{$fullTableName}` WHERE status = ?";
        $stmt = $this->db->raw($sql, ['Rejected']);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $rejected = (int)($result['count'] ?? 0);

        return [
            'total' => $total,
            'pending' => $pending,
            'approved' => $approved,
            'rejected' => $rejected
        ];
    }
}
