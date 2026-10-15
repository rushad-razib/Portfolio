<?php

function db_run(mysqli $db, string $sql, string $types = '', array $params = []): mysqli_stmt|false
{
    try {
        $stmt = $db->prepare($sql);
        if ($stmt === false) {
            return false;
        }
        if ($types !== '') {
            $refs = [];
            foreach ($params as $key => $value) {
                $refs[$key] = &$params[$key];
            }
            $stmt->bind_param($types, ...$refs);
        }
        $stmt->execute();
        return $stmt;
    } catch (mysqli_sql_exception $e) {
        return false;
    }
}
