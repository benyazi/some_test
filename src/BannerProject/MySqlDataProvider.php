<?php

namespace BannerProject;

use RuntimeException;

class MySqlDataProvider implements DataProviderInterface {

    const TABLE_NAME = 'visitors';
    private \mysqli $connection;

    /**
     * @throws RuntimeException
     */
    public function __construct($host, $username, $password, $database) {
        $this->connection = new \mysqli($host, $username, $password, $database);

        if ($this->connection->connect_error) {
            throw new RuntimeException("Connection failed: " . $this->connection->connect_error);
        }
    }

    /**
     * @throws RuntimeException
     */
    public function createOrUpdate(string $ipAddress, string $userAgent, string $pageUrl): void {

        try {
            $this->connection->begin_transaction();
            //find and lock row for update
            $stmt = $this->connection->prepare('SELECT views_count FROM '.self::TABLE_NAME.' WHERE ip_address=? AND user_agent=? AND page_url=? FOR UPDATE');
            $stmt->bind_param('sss', $ipAddress, $userAgent, $pageUrl);
            $stmt->execute();
            $result = $stmt->get_result();
            $dt = (new \DateTime())->format("Y-m-d H:i:s");

            if ($result->num_rows > 0) {
                // update exist row
                $row = $result->fetch_assoc();
                $query = $this->connection->prepare('UPDATE '.self::TABLE_NAME.' SET views_count=?, view_date=? WHERE ip_address=? AND user_agent=? AND page_url=?');
                $query->bind_param('issss', ++$row['views_count'], $dt, $ipAddress, $userAgent, $pageUrl);
                $query->execute();
            } else {
                // insert new row
                $viewsCount = 1;
                $stmt = $this->connection->prepare('INSERT INTO '.self::TABLE_NAME.' (ip_address, user_agent, page_url, views_count, view_date) VALUES (?,?,?,?,?)');
                $stmt->bind_param('sssis', $ipAddress, $userAgent, $pageUrl, $viewsCount, $dt);
                $stmt->execute();
            }

            $this->connection->commit();
        } catch (\Exception $e) {
            $this->connection->rollback();
            throw new RuntimeException("Transaction failed: " . $e->getMessage());
        }
    }

    public function __destruct() {
        $this->connection->close();
    }
}
