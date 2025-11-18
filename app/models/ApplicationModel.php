<?php

class ApplicationModel extends Model
{
    protected $table = "applications";

    /**
     * Save applicant form submission
     */
    public function saveApplication($data)
    {
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
        return $this->db->table($this->table)
            ->where('user_id', $userId)
            ->order_by('date_submitted', 'DESC')
            ->get_all();
    }

    /**
     * Get application by ID and verify it belongs to the user
     */
    public function getApplicationByUserAndId($userId, $applicationId)
    {
        return $this->db->table($this->table)
            ->where('id', $applicationId)
            ->where('user_id', $userId)
            ->get();
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
     * Get application statistics
     */
    public function getStatistics()
    {
        $total = $this->db->table($this->table)->count();
        $pending = $this->db->table($this->table)->where('status', 'pending')->count();
        $approved = $this->db->table($this->table)->where('status', 'Approved')->count();
        $rejected = $this->db->table($this->table)->where('status', 'Rejected')->count();

        return [
            'total' => (int)$total,
            'pending' => (int)$pending,
            'approved' => (int)$approved,
            'rejected' => (int)$rejected
        ];
    }
}
