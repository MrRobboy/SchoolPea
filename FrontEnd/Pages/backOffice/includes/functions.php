<?php
function getAll($table) {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM $table");
    return $stmt->fetchAll();
}

function getById($table, $id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM $table WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function create($table, $data) {
    global $pdo;
    $keys = implode(',', array_keys($data));
    $placeholders = implode(',', array_fill(0, count($data), '?'));
    $values = array_values($data);
    $stmt = $pdo->prepare("INSERT INTO $table ($keys) VALUES ($placeholders)");
    return $stmt->execute($values);
}

function update($table, $id, $data) {
    global $pdo;
    $set = implode(' = ?, ', array_keys($data)) . ' = ?';
    $values = array_values($data);
    $values[] = $id;
    $stmt = $pdo->prepare("UPDATE $table SET $set WHERE id = ?");
    return $stmt->execute($values);
}

function delete($table, $id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM $table WHERE id = ?");
    return $stmt->execute([$id]);
}
?>
