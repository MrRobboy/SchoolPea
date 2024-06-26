<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';

function getAll($table)
{
    include($path);
    $stmt = $dbh->query("USE PA; SELECT * FROM :tab");
    $stmt->bindvalue(':tab', $table);
    return $stmt->fetchAll();
}

function getById($table, $id)
{
    include($path);
    $stmt = $dbh->prepare("SELECT * FROM :tab WHERE id_:tab = :id");
    $stmt->bindvalue(':tab', $table);
    $stmt->bindvalue(':id', $id);
    return $stmt->fetchAll();
}

function create($table, $data)
{
    include($path);
    $keys = implode(',', array_keys($data));
    $placeholders = implode(',', array_fill(0, count($data), '?'));
    $values = array_values($data);
    $stmt = $dbh->prepare("INSERT INTO $table ($keys) VALUES ($placeholders)");
    return $stmt->execute($values);
}

function update($table, $id, $data)
{
    include($path);
    $set = implode(' = ?, ', array_keys($data)) . ' = ?';
    $values = array_values($data);
    $values[] = $id;
    $stmt = $dbh->prepare("UPDATE $table SET $set WHERE id = ?");
    return $stmt->execute($values);
}

function delete($table, $id)
{
    include($path);
    $stmt = $dbh->prepare("DELETE FROM $table WHERE id = ?");
    return $stmt->execute([$id]);
}
